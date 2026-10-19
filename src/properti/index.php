<?php
// src/properti/index.php - Katalog seluruh properti RumahKita

require_once __DIR__ . '/../../utils/koneksi.php';
require_once __DIR__ . '/../../utils/sesi.php';
require_once __DIR__ . '/../layouts/header.php';

// Ambil seluruh data properti berstatus 'active' dari database MySQL
$sql = "SELECT p.*, u.name AS nama_penginput,
               (SELECT image_path FROM property_images WHERE property_id = p.id AND is_primary = 1 LIMIT 1) AS foto_utama
        FROM properties p
        LEFT JOIN users u ON p.user_id = u.id
        WHERE p.status = 'active'
        ORDER BY p.created_at DESC";

$result = $conn->query($sql);
$daftar_properti = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $daftar_properti[] = $row;
    }
}

$tipeLabelMap = [
    'minimalis' => 'Rumah Minimalis',
    'cluster'   => 'Rumah Cluster',
    'villa'     => 'Villa Mewah',
    'apartemen' => 'Apartemen'
];
?>

<main class="min-h-screen bg-slate-50 py-10 sm:py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Breadcrumb & Navigasi -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6">
            <a href="<?= BASE_URL ?>/index.php" class="hover:text-sky-600 transition">Beranda</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Semua Properti</span>
        </nav>

        <!-- Header Halaman -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 pb-6 border-b border-slate-200">
            <div>
                <span class="inline-block text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-100/70 px-3.5 py-1.5 rounded-full mb-3">
                    Katalog Lengkap
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Semua Properti
                </h1>
                <p class="text-slate-600 text-sm sm:text-base mt-2 max-w-2xl">
                    Jelajahi seluruh pilihan hunian terbaik dengan jaminan legalitas terverifikasi, lokasi strategis, dan harga transparan.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold px-4 py-2 bg-white rounded-xl border border-slate-200 text-slate-700 shadow-sm">
                    Total: <strong class="text-sky-600"><?= count($daftar_properti) ?></strong> Unit
                </span>
                <?php if (apakahAdmin()): ?>
                <a href="<?= BASE_URL ?>/src/admin/tambah.php"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition">
                    <span>+ Tambah Properti</span>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Grid Kartu Properti -->
        <?php if (empty($daftar_properti)): ?>
        <!-- Tampilan Empty State -->
        <div class="py-20 text-center bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
            <div class="mx-auto mb-4 w-16 h-16 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800">Belum Ada Properti yang Ditambahkan</h3>
            <p class="text-sm text-slate-500 mt-2 max-w-md mx-auto">
                Saat ini belum ada listing properti aktif di katalog. Administrator dapat menambahkan properti melalui Panel Admin.
            </p>
            <?php if (apakahAdmin()): ?>
            <a href="<?= BASE_URL ?>/src/admin/tambah.php" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                <span>+ Tambah Properti Sekarang</span>
            </a>
            <?php else: ?>
            <a href="<?= BASE_URL ?>/index.php" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-slate-900 hover:bg-sky-600 text-white font-bold text-xs rounded-xl shadow-md transition">
                <span>&larr; Kembali ke Beranda</span>
            </a>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($daftar_properti as $prop): ?>
            <?php
            $fotoCard = urlGambar($prop['foto_utama']);
            $labelTipe = $tipeLabelMap[$prop['property_type']] ?? ucfirst($prop['property_type']);
            ?>
            <div class="property-card bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm flex flex-col hover:shadow-xl hover:border-sky-300 transition-all duration-300">
                
                <!-- Foto Properti -->
                <div class="relative overflow-hidden aspect-[4/3] group">
                    <img src="<?= e($fotoCard) ?>"
                        alt="<?= e($prop['title']) ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    <div class="absolute top-4 left-4 flex flex-wrap gap-1.5">
                        <span class="px-3 py-1 bg-sky-600/95 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow">
                            <?= e($labelTipe) ?>
                        </span>
                        <?php if (!empty($prop['certificate_type'])): ?>
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-slate-800 text-xs font-semibold rounded-full shadow">
                            <?= e($prop['certificate_type']) ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="absolute bottom-3 right-3 px-3 py-1 bg-slate-950/70 backdrop-blur-md rounded-lg text-white text-xs font-medium">
                        <?= e($prop['city']) ?>
                    </div>
                </div>

                <!-- Konten Kartu -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between text-xs font-bold text-sky-600 uppercase tracking-wider mb-1">
                            <span><?= e($labelTipe) ?></span>
                            <span class="text-[10px] text-slate-400 font-normal lowercase">
                                oleh <?= e($prop['nama_penginput'] ?: 'Admin') ?>
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 line-clamp-1 hover:text-sky-600 transition-colors">
                            <?= e($prop['title']) ?>
                        </h3>

                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                            <?= e($prop['description'] ?: 'Hunian nyaman berlegalitas resmi dengan lokasi strategis untuk keluarga Anda.') ?>
                        </p>

                        <!-- Spesifikasi Fasilitas -->
                        <div class="grid grid-cols-3 gap-2 my-4 py-3 border-y border-slate-100 text-center text-xs text-slate-600">
                            <div>
                                <span class="font-bold text-slate-800 block text-sm"><?= (int)($prop['bedrooms'] ?? 0) ?> KT</span>
                                <span>Kamar Tidur</span>
                            </div>
                            <div>
                                <span class="font-bold text-slate-800 block text-sm"><?= (int)($prop['bathrooms'] ?? 0) ?> KM</span>
                                <span>Kamar Mandi</span>
                            </div>
                            <div>
                                <span class="font-bold text-slate-800 block text-sm"><?= number_format((float)($prop['building_area'] ?? 0), 0, ',', '.') ?> m²</span>
                                <span>Bangunan</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <div>
                            <span class="text-[11px] text-slate-400 block font-medium">Harga Penawaran</span>
                            <span class="text-lg font-black text-sky-700">Rp <?= number_format((float)$prop['price'], 0, ',', '.') ?></span>
                        </div>
                        <a href="<?= BASE_URL ?>/src/properti/detail.php?id=<?= urlencode($prop['id']) ?>"
                            class="px-4 py-2.5 text-xs font-bold text-white bg-slate-900 hover:bg-sky-600 rounded-xl transition-all shadow-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
