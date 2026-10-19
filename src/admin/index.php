<?php
// src/admin/index.php - Dashboard Panel Admin RumahKita

require_once __DIR__ . '/../../utils/koneksi.php';
require_once __DIR__ . '/../../utils/sesi.php';

wajibPeran('admin');

$admin_user = penggunaAktif();
$admin_name = $admin_user['name'];
$admin_role = ucfirst($admin_user['role']);
$admin_initial = strtoupper(substr($admin_name, 0, 1));

$flash_sukses = $_SESSION['flash_sukses'] ?? null;
unset($_SESSION['flash_sukses']);

// Query seluruh properti dengan JOIN ke tabel users dan subquery gambar utama serta daftar fasilitas
$sql = "SELECT p.*, u.name AS nama_penginput,
               (SELECT image_path FROM property_images WHERE property_id = p.id AND is_primary = 1 LIMIT 1) AS primary_image,
               (SELECT GROUP_CONCAT(facility_name SEPARATOR '||') FROM property_facilities WHERE property_id = p.id) AS fasilitas_list
        FROM properties p
        LEFT JOIN users u ON p.user_id = u.id
        ORDER BY p.created_at DESC";

$result = $conn->query($sql);
$properti_list = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $properti_list[] = $row;
    }
}

// Hitung ringkasan statistik
$total_properti = count($properti_list);
$properti_aktif = 0;
$properti_pending = 0;

foreach ($properti_list as $p) {
    if ($p['status'] === 'active') {
        $properti_aktif++;
    } elseif ($p['status'] === 'pending') {
        $properti_pending++;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Properti | Panel Admin RumahKita</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        transition: .2s;
    }

    .sidebar-link:hover {
        background: #f0f9ff;
        color: #0284c7;
    }

    .sidebar-active {
        background: #e0f2fe;
        color: #0369a1;
    }
    </style>
</head>

<body class="bg-slate-50 text-slate-800">

    <div class="min-h-screen lg:flex">

        <!-- SIDEBAR -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-200
               p-6 flex flex-col transform -translate-x-full
               transition-transform duration-300 lg:translate-x-0">

            <!-- Logo -->
            <a href="<?= BASE_URL ?>/src/admin/index.php" class="flex items-center gap-3 mb-10">
                <span class="text-xl font-extrabold tracking-tight">
                    Rumah<span class="text-sky-600">Kita</span>
                </span>
            </a>

            <!-- Menu -->
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
                Menu Dashboard
            </p>

            <nav class="space-y-2">
                <a href="<?= BASE_URL ?>/src/admin/index.php" class="sidebar-link sidebar-active">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10.5L12 3l9 7.5V21H3V10.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 21v-7h6v7" />
                    </svg>
                    Kelola Properti
                </a>

                <a href="<?= BASE_URL ?>/src/admin/tambah.php" class="sidebar-link text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Properti
                </a>
            </nav>

            <!-- Admin info -->
            <div class="mt-auto pt-6 border-t border-slate-100">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center font-bold">
                        <?= e($admin_initial) ?>
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold text-sm truncate"><?= e($admin_name) ?></p>
                        <p class="text-xs text-slate-400 truncate">Peran: <?= e($admin_role) ?></p>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>/src/auth/logout.php"
                    class="mt-4 block text-sm font-semibold text-rose-600 hover:text-rose-700">
                    Keluar akun
                </a>
            </div>

        </aside>

        <!-- OVERLAY MOBILE -->
        <div id="overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-slate-900/40 z-30 lg:hidden"></div>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 min-w-0 lg:ml-64">

            <!-- HEADER -->
            <header
                class="sticky top-0 z-20 bg-white border-b border-slate-200 px-5 sm:px-8 py-5 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-slate-100"
                        aria-label="Buka menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                            Kelola Properti
                        </h1>
                        <p class="text-sm text-slate-500 mt-0.5 hidden sm:block">
                            Dashboard pengelolaan data katalog properti RumahKita.
                        </p>
                    </div>
                </div>

                <!-- Tombol Tambah Properti Baru -->
                <a href="<?= BASE_URL ?>/src/admin/tambah.php"
                    class="shrink-0 inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-md shadow-sky-500/20 transition">
                    <span class="text-lg leading-none">+</span>
                    <span class="hidden sm:inline">Tambah Properti</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
            </header>

            <!-- ISI HALAMAN -->
            <div class="p-5 sm:p-8 space-y-7">

                <!-- Pesan Flash Sukses -->
                <?php if ($flash_sukses): ?>
                <div
                    class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span><?= e($flash_sukses) ?></span>
                </div>
                <?php endif; ?>

                <!-- STATISTIK -->
                <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    <div class="bg-white border border-slate-200 rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-500">Total Properti</p>
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10.5L12 3l9 7.5V21H3V10.5z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold mt-4"><?= $total_properti ?></p>
                        <p class="text-xs text-slate-400 mt-1">Seluruh data tercatat di database</p>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-500">Properti Aktif</p>
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12l4 4L19 6" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold mt-4"><?= $properti_aktif ?></p>
                        <p class="text-xs text-slate-400 mt-1">Status 'active' tayang di beranda</p>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-500">Pending Review</p>
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" stroke-width="2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 7v5l3 2" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-extrabold mt-4"><?= $properti_pending ?></p>
                        <p class="text-xs text-slate-400 mt-1">Menunggu konfirmasi admin</p>
                    </div>

                </section>

                <!-- TABEL PROPERTI -->
                <section class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">

                    <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-900">Daftar Properti Database</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Seluruh properti yang diinput oleh admin (diurutkan
                                dari yang terbaru).</p>
                        </div>
                        <a href="<?= BASE_URL ?>/src/admin/tambah.php"
                            class="text-xs font-bold text-sky-600 hover:text-sky-700">
                            + Tambah Data
                        </a>
                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500">
                                <tr class="text-xs uppercase tracking-wider">
                                    <th class="px-5 py-4 font-bold">Properti</th>
                                    <th class="px-5 py-4 font-bold">Penginput (JOIN)</th>
                                    <th class="px-5 py-4 font-bold">Lokasi</th>
                                    <th class="px-5 py-4 font-bold">Harga</th>
                                    <th class="px-5 py-4 font-bold">Status</th>
                                    <th class="px-5 py-4 font-bold text-right">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                <?php if (empty($properti_list)): ?>
                                <tr>
                                    <td colspan="6" class="px-5 py-16 text-center">
                                        <div
                                            class="mx-auto mb-3 w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10.5L12 3l9 7.5V21H3V10.5z" />
                                            </svg>
                                        </div>
                                        <p class="font-bold text-slate-700">Belum Ada Data Properti</p>
                                        <p class="text-xs text-slate-400 mt-1">Silakan klik tombol "+ Tambah Properti"
                                            untuk menginput data pertama.</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($properti_list as $p): ?>
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <?php 
                                                $imgThumb = urlGambar($p['primary_image']);
                                                ?>
                                            <img src="<?= e($imgThumb) ?>" alt="<?= e($p['title']) ?>"
                                                class="w-12 h-10 rounded-xl object-cover border border-slate-200 shrink-0">
                                            <div class="min-w-0">
                                                <p class="font-bold text-slate-900 truncate max-w-xs">
                                                    <?= e($p['title']) ?></p>
                                                <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-400">
                                                    <span class="font-mono font-medium"><?= e($p['id']) ?></span>
                                                    <span>&bull;</span>
                                                    <span class="capitalize"><?= e($p['property_type']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Menampilkan nama penginput dari hasil JOIN ke tabel users -->
                                    <td class="px-5 py-4">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-medium">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <?= e($p['nama_penginput'] ?: 'Admin') ?>
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-slate-600">
                                        <p class="font-semibold text-slate-800 text-xs sm:text-sm"><?= e($p['city']) ?>
                                        </p>
                                        <p class="text-xs text-slate-400 truncate max-w-[180px]"><?= e($p['address']) ?>
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="font-bold text-slate-900 text-sm">
                                            Rp <?= number_format((float)$p['price'], 0, ',', '.') ?>
                                        </span>
                                    </td>

                                    <td class="px-5 py-4">
                                        <?php if ($p['status'] === 'active'): ?>
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                                        <?php elseif ($p['status'] === 'pending'): ?>
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">Pending</span>
                                        <?php elseif ($p['status'] === 'sold'): ?>
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">Terjual</span>
                                        <?php else: ?>
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200"><?= e($p['status']) ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        <button type="button"
                                            onclick='tampilModalDetail(<?= json_encode($p, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-bold text-sky-600 hover:text-white bg-sky-50 hover:bg-sky-600 rounded-lg transition"
                                            title="Lihat Detail Properti di Dashboard">
                                            <span>Lihat</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer tabel -->
                    <div
                        class="px-5 py-4 border-t border-slate-100 text-xs text-slate-400 flex items-center justify-between">
                        <span>Menampilkan <?= $total_properti ?> data properti dari database `properties`</span>
                        <span>RumahKita Admin Panel</span>
                    </div>

                </section>

            </div>
        </main>
    </div>

    <!-- MODAL DETAIL PROPERTI KHUSUS ADMIN DI DASHBOARD -->
    <div id="modal-detail"
        class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div
            class="relative bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 overflow-hidden max-h-[90vh] flex flex-col">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 shrink-0">
                <div>
                    <span id="modal-type"
                        class="text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-50 px-2.5 py-1 rounded-full"></span>
                    <h3 id="modal-title" class="text-xl font-bold text-slate-900 mt-2"></h3>
                </div>
                <button type="button" onclick="tutupModalDetail()"
                    class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="overflow-y-auto py-4 space-y-4 pr-1">
                <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-slate-100">
                    <img id="modal-img" src="" alt="Foto Properti" class="w-full h-full object-cover">
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block">Harga</span>
                        <strong id="modal-price" class="text-sky-700 font-extrabold text-sm block mt-0.5"></strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block">Kamar</span>
                        <strong id="modal-rooms" class="text-slate-800 font-bold block mt-0.5"></strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block">Luas Bangunan</span>
                        <strong id="modal-area" class="text-slate-800 font-bold block mt-0.5"></strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 block">Sertifikat</span>
                        <strong id="modal-cert" class="text-slate-800 font-bold block mt-0.5"></strong>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lokasi & Alamat</h4>
                    <p id="modal-location" class="text-sm font-semibold text-slate-800 mt-1"></p>
                    <p id="modal-address" class="text-xs text-slate-500 mt-0.5"></p>
                </div>

                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Fasilitas Properti</h4>
                    <div id="modal-facilities" class="flex flex-wrap gap-1.5 mt-2"></div>
                </div>

                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Deskripsi</h4>
                    <p id="modal-desc" class="text-xs text-slate-600 mt-1 leading-relaxed whitespace-pre-line"></p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span id="modal-inputter"></span>
                    <span id="modal-status" class="font-bold"></span>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end shrink-0">
                <button type="button" onclick="tutupModalDetail()"
                    class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
        document.getElementById('overlay').classList.toggle('hidden');
    }

    function tampilModalDetail(data) {
        document.getElementById('modal-title').textContent = data.title || '-';
        document.getElementById('modal-type').textContent = (data.property_type || '').toUpperCase();

        let imgUrl = data.primary_image || '';
        if (imgUrl && !imgUrl.startsWith('http://') && !imgUrl.startsWith('https://')) {
            imgUrl = '<?= BASE_URL ?>/' + imgUrl.replace(/^\/+/, '');
        }
        if (!imgUrl) {
            imgUrl = 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=600&q=80';
        }
        document.getElementById('modal-img').src = imgUrl;

        document.getElementById('modal-price').textContent = 'Rp ' + Number(data.price || 0).toLocaleString('id-ID');
        document.getElementById('modal-rooms').textContent = (data.bedrooms || 0) + ' KT / ' + (data.bathrooms || 0) +
            ' KM';
        document.getElementById('modal-area').textContent = (data.building_area || 0) + ' m²';
        document.getElementById('modal-cert').textContent = data.certificate_type || '-';
        document.getElementById('modal-location').textContent = (data.city || '') + (data.province ? ', ' + data
            .province : '');
        document.getElementById('modal-address').textContent = data.address || '-';
        document.getElementById('modal-desc').textContent = data.description || 'Tidak ada keterangan tambahan.';
        document.getElementById('modal-inputter').textContent = 'Diinput oleh: ' + (data.nama_penginput || 'Admin');
        document.getElementById('modal-status').textContent = 'Status: ' + (data.status || 'Active').toUpperCase();

        const facContainer = document.getElementById('modal-facilities');
        facContainer.innerHTML = '';
        if (data.fasilitas_list) {
            const list = data.fasilitas_list.split('||');
            list.forEach(item => {
                if (item.trim()) {
                    const badge = document.createElement('span');
                    badge.className =
                        'px-2.5 py-1 bg-sky-50 text-sky-700 rounded-lg text-xs font-semibold border border-sky-100';
                    badge.textContent = item.trim();
                    facContainer.appendChild(badge);
                }
            });
        } else {
            facContainer.innerHTML = '<span class="text-xs text-slate-400 italic">Tidak ada fasilitas tercatat.</span>';
        }

        document.getElementById('modal-detail').classList.remove('hidden');
    }

    function tutupModalDetail() {
        document.getElementById('modal-detail').classList.add('hidden');
    }
    </script>
</body>

</html>