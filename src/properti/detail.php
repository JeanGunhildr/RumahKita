<?php
// src/properti/detail.php - Halaman detail properti RumahKita

require_once __DIR__ . '/../../utils/koneksi.php';
require_once __DIR__ . '/../../utils/sesi.php';

// Logika pembatasan: Pengguna wajib login terlebih dahulu untuk mengakses rincian detail properti
if (!sudahLogin()) {
    $_SESSION['flash_info'] = 'Silakan masuk ke akun Anda terlebih dahulu untuk melihat detail properti.';
    header('Location: ' . BASE_URL . '/src/auth/login.php');
    exit;
}

// Ambil parameter ID dari URL
$id_raw = trim($_GET['id'] ?? '');

$properti = null;
$error_detail = null;
$fasilitas_list = [];

if ($id_raw === '') {
    $error_detail = 'ID properti tidak disertakan pada tautan.';
} else {
    // Ambil data properti menggunakan prepared statement dengan JOIN ke tabel users
    $sql = "SELECT p.*, u.name AS nama_penginput, u.email AS email_penginput, u.phone AS phone_penginput,
                   (SELECT image_path FROM property_images WHERE property_id = p.id AND is_primary = 1 LIMIT 1) AS foto_utama
            FROM properties p
            LEFT JOIN users u ON p.user_id = u.id
            WHERE p.id = ? LIMIT 1";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('s', $id_raw);
        $stmt->execute();
        $res = $stmt->get_result();
        $properti = $res->fetch_assoc();
        $stmt->close();

        if (!$properti) {
            $error_detail = 'Properti dengan ID "' . e($id_raw) . '" tidak ditemukan atau sudah tidak tersedia.';
        } else {
            // Ambil daftar fasilitas
            $sqlFac = "SELECT facility_name FROM property_facilities WHERE property_id = ?";
            $stmtFac = $conn->prepare($sqlFac);
            if ($stmtFac) {
                $stmtFac->bind_param('s', $id_raw);
                $stmtFac->execute();
                $resFac = $stmtFac->get_result();
                while ($fRow = $resFac->fetch_assoc()) {
                    $fasilitas_list[] = $fRow['facility_name'];
                }
                $stmtFac->close();
            }
        }
    } else {
        error_log('Detail Prepare Error: ' . $conn->error);
        $error_detail = 'Terjadi kesalahan sistem saat memuat data properti.';
    }
}

// Sertakan layout header umum
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="min-h-screen bg-slate-50/70 pb-20 pt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb Navigasi -->
        <nav
            class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 mb-6 overflow-x-auto whitespace-nowrap pb-1">
            <a href="<?= BASE_URL ?>/index.php" class="hover:text-sky-600 transition-colors font-medium">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="<?= BASE_URL ?>/index.php#rekomendasi"
                class="hover:text-sky-600 transition-colors font-medium">Katalog Properti</a>
            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span
                class="text-sky-600 font-bold truncate"><?= $properti ? e($properti['title']) : 'Detail Properti' ?></span>
        </nav>

        <?php if ($error_detail): ?>
        <!-- Tampilan Galat jika ID Tidak Valid / Data Tidak Ditemukan -->
        <div
            class="bg-white rounded-3xl p-10 sm:p-14 text-center border border-slate-200 shadow-sm max-w-xl mx-auto my-12">
            <div class="w-16 h-16 mx-auto mb-4 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h1 class="text-2xl font-black text-slate-800 mb-2">Properti Tidak Ditemukan</h1>
            <p class="text-sm text-slate-500 mb-6"><?= $error_detail ?></p>
            <a href="<?= BASE_URL ?>/index.php"
                class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm rounded-xl transition">
                <span>&larr; Kembali ke Katalog Utama</span>
            </a>
        </div>
        <?php else: ?>

        <?php
        $fotoUtama = urlGambar($properti['foto_utama']);
        $tipeLabelMap = [
            'minimalis' => 'Rumah Minimalis',
            'cluster'   => 'Rumah Cluster',
            'villa'     => 'Villa Mewah',
            'apartemen' => 'Apartemen'
        ];
        $tipeLabel = $tipeLabelMap[$properti['property_type']] ?? ucfirst($properti['property_type']);
        ?>

        <!-- Header Atas: Judul, Badges, dan Harga -->
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6 mb-8">
            <div>
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-sky-600 text-white text-xs font-bold rounded-lg shadow-sm">
                        <?= e($tipeLabel) ?>
                    </span>
                    <?php if (!empty($properti['certificate_type'])): ?>
                    <span class="px-3 py-1 bg-sky-100 text-sky-800 text-xs font-bold rounded-lg border border-sky-200">
                        <?= e($properti['certificate_type']) ?>
                    </span>
                    <?php endif; ?>
                    <span
                        class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-mono font-semibold rounded-lg border border-slate-200">
                        ID: <?= e($properti['id']) ?>
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    <?= e($properti['title']) ?>
                </h1>

                <p class="flex items-center gap-2 text-slate-500 text-sm mt-2">
                    <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    <span><?= e($properti['address']) ?>, <?= e($properti['city']) ?>,
                        <?= e($properti['province']) ?></span>
                </p>
            </div>

            <!-- Box Harga & Status -->
            <div class="lg:text-right shrink-0 p-5 rounded-2xl shadow-sm">
                <span class="text-xs font-medium text-slate-400 block uppercase tracking-wider">Harga Penawaran</span>
                <span class="text-2xl sm:text-3xl font-black text-sky-600 block mt-1">
                    Rp <?= number_format((float)$properti['price'], 0, ',', '.') ?>
                </span>
                <span
                    class="inline-block mt-2 text-xs font-bold px-2.5 py-1 rounded-full <?= $properti['status'] === 'active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' ?>">
                    Status: <?= e(ucfirst($properti['status'])) ?>
                </span>
            </div>
        </div>

        <!-- Grid Konten Utama: 8 Kolom Kiri, 4 Kolom Kanan (Agen / Kontak) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Kolom Kiri: Foto, Spesifikasi, Deskripsi -->
            <div class="lg:col-span-8 space-y-8">

                <!-- Foto Utama Properti -->
                <div
                    class="relative rounded-3xl overflow-hidden bg-slate-900 shadow-md aspect-[16/9] border-4 border-white">
                    <img src="<?= e($fotoUtama) ?>" alt="<?= e($properti['title']) ?>"
                        class="w-full h-full object-cover">
                </div>

                <!-- Spesifikasi Ringkas Properti -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Spesifikasi Utama Bangunan & Tanah</span>
                    </h2>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="p-4 rounded-2xl bg-sky-50/50 border border-sky-100 text-center">
                            <span
                                class="block text-xl font-black text-sky-700"><?= (int)($properti['bedrooms'] ?? 0) ?></span>
                            <span class="text-xs text-slate-500 font-medium">Kamar Tidur</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-sky-50/50 border border-sky-100 text-center">
                            <span
                                class="block text-xl font-black text-sky-700"><?= (int)($properti['bathrooms'] ?? 0) ?></span>
                            <span class="text-xs text-slate-500 font-medium">Kamar Mandi</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-sky-50/50 border border-sky-100 text-center">
                            <span
                                class="block text-xl font-black text-sky-700"><?= number_format((float)($properti['building_area'] ?? 0), 0, ',', '.') ?>
                                m²</span>
                            <span class="text-xs text-slate-500 font-medium">Luas Bangunan</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-sky-50/50 border border-sky-100 text-center">
                            <span
                                class="block text-xl font-black text-sky-700"><?= number_format((float)($properti['land_area'] ?? 0), 0, ',', '.') ?>
                                m²</span>
                            <span class="text-xs text-slate-500 font-medium">Luas Tanah</span>
                        </div>
                    </div>

                    <!-- Detail Spesifikasi Tambahan -->
                    <div
                        class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 text-sm">
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Legalitas</span>
                            <span
                                class="font-bold text-slate-800"><?= e($properti['certificate_type'] ?: 'SHM') ?></span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Tipe Hunian</span>
                            <span
                                class="font-bold text-slate-800 capitalize"><?= e($properti['property_type']) ?></span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Kota / Wilayah</span>
                            <span class="font-bold text-slate-800"><?= e($properti['city']) ?></span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Provinsi</span>
                            <span class="font-bold text-slate-800"><?= e($properti['province']) ?></span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Tanggal Terbit</span>
                            <span
                                class="font-bold text-slate-800"><?= e(date('d F Y', strtotime($properti['created_at']))) ?></span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-500">Dipublikasikan Oleh</span>
                            <span
                                class="font-bold text-sky-600"><?= e($properti['nama_penginput'] ?: 'Admin RumahKita') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Fasilitas Properti -->
                <?php if (!empty($fasilitas_list)): ?>
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Fasilitas Properti</span>
                    </h2>
                    <div class="flex flex-wrap gap-2.5">
                        <?php foreach ($fasilitas_list as $fItem): ?>
                        <span
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-sky-50 text-sky-800 text-xs font-bold rounded-xl border border-sky-100">
                            <svg class="w-3.5 h-3.5 text-sky-600 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span><?= e($fItem) ?></span>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Deskripsi Lengkap Properti -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        <span>Deskripsi Properti</span>
                    </h2>
                    <div class="text-slate-600 leading-relaxed text-sm whitespace-pre-line">
                        <?= e($properti['description'] ?: 'Tidak ada deskripsi tambahan untuk properti ini.') ?>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Kotak Pemilik / Penginput (Hasil JOIN) & Hubungi Agen -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Card Penginput Data Properti (JOIN Tabel Users) -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm sticky top-28">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Informasi Penginput</h3>

                    <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
                        <div
                            class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center font-black text-lg">
                            <?= e(strtoupper(substr($properti['nama_penginput'] ?: 'A', 0, 1))) ?>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base">
                                <?= e($properti['nama_penginput'] ?: 'Admin RumahKita') ?></h4>
                            <p class="text-xs text-slate-400">Pengelola Resmi RumahKita</p>
                        </div>
                    </div>

                    <div class="py-4 space-y-2.5 text-xs text-slate-600">
                        <?php if (!empty($properti['email_penginput'])): ?>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span><?= e($properti['email_penginput']) ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($properti['phone_penginput'])): ?>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span><?= e($properti['phone_penginput']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="pt-2">
                        <?php
                        $nomorWA = $properti['phone_penginput'] ?: '081234567890';
                        $nomorWA_clean = preg_replace('/[^0-9]/', '', $nomorWA);
                        if (substr($nomorWA_clean, 0, 1) === '0') {
                            $nomorWA_clean = '62' . substr($nomorWA_clean, 1);
                        }
                        $pesanWA = urlencode("Halo RumahKita, saya tertarik dengan properti: " . $properti['title'] . " (ID: " . $properti['id'] . ") seharga Rp " . number_format((float)$properti['price'], 0, ',', '.') . ".");
                        ?>
                        <a href="https://wa.me/<?= e($nomorWA_clean) ?>?text=<?= $pesanWA ?>" target="_blank"
                            class="w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-md shadow-emerald-500/20 transition">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            <span>Hubungi Agen via WhatsApp</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>