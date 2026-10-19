<?php
// Halaman Admin RumahKita
// Terintegrasi dengan data/properti_data.php

require_once __DIR__ . '/../data/properti_data.php';

if (!defined('BASE_URL')) {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');

    define(
        'BASE_URL',
        stripos($scriptName, '/RumahKita') !== false ? '/RumahKita' : ''
    );
}

// Ambil data properti terpusat dari properti_data.php
$all_raw = get_all_properti();

// Status pemetaan sesuai database: 'draft', 'pending', 'aktif', 'terjual', 'ditolak'
$status_map = [
    1 => 'aktif',
    2 => 'aktif',
    3 => 'pending',
    4 => 'aktif',
    5 => 'draft',
    6 => 'terjual'
];

// Contoh properti berstatus 'ditolak' agar kelima status dapat teruji dengan baik di frontend
$properti_list = [];
foreach ($all_raw as $id => $item) {
    $st = $status_map[$id] ?? 'aktif';
    $item['status'] = $st;
    $properti_list[$id] = $item;
}

if (!isset($properti_list[7])) {
    $properti_list[7] = [
        'id' => 7,
        'kode' => 'RK-007',
        'nama' => 'Cluster Taman Asri Bukit Duri',
        'kategori' => 'rumah',
        'tipe_label' => 'Rumah Cluster',
        'lokasi_singkat' => 'Tebet, Jakarta Selatan',
        'alamat_lengkap' => 'Jl. Bukit Duri Selatan No. 12, Tebet, Jakarta Selatan',
        'harga' => 850000000,
        'harga_format' => 'Rp 850.000.000',
        'foto_utama' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1200&q=80',
        'status' => 'ditolak'
    ];
}

// Hitung ringkasan statistik untuk kartu atas
$total_properti = count($properti_list);
$properti_aktif = 0;
$properti_pending = 0;

foreach ($properti_list as $p) {
    if ($p['status'] === 'aktif') {
        $properti_aktif++;
    } elseif ($p['status'] === 'pending') {
        $properti_pending++;
    }
}

// Info admin untuk tampilan UI frontend
$admin_name = 'Administrator';
$admin_role = 'Admin RumahKita';
$admin_initial = 'A';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Properti | RumahKita</title>

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
            <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-xl bg-sky-600 text-white
                       flex items-center justify-center font-extrabold text-xl">
                    R
                </div>

                <span class="text-xl font-extrabold tracking-tight">
                    Rumah<span class="text-sky-600">Kita</span>
                </span>
            </a>

            <!-- Menu -->
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">
                Menu Utama
            </p>

            <nav class="space-y-2">

                <a href="#" class="sidebar-link sidebar-active">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10.5L12 3l9 7.5V21H3V10.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 21v-7h6v7" />
                    </svg>
                    Kelola Properti
                </a>

                <a href="<?= BASE_URL ?>/index.php" class="sidebar-link text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 3h7v7m-11 4L21 3M19 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6" />
                    </svg>
                    Lihat Website
                </a>

            </nav>

            <!-- Admin info -->
            <div class="mt-auto pt-6 border-t border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-sky-100 text-sky-700
                           flex items-center justify-center font-bold">
                        <?= $admin_initial ?>
                    </div>

                    <div class="min-w-0">
                        <p class="font-bold text-sm truncate"><?= $admin_name ?></p>
                        <p class="text-xs text-slate-400 truncate"><?= $admin_role ?></p>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>/src/auth/login.php" class="mt-4 block text-sm font-semibold text-rose-600
                       hover:text-rose-700">
                    Keluar akun
                </a>
            </div>

        </aside>

        <!-- OVERLAY MOBILE -->
        <div id="overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-slate-900/40 z-30 lg:hidden"></div>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 min-w-0 lg:ml-64">

            <!-- HEADER -->
            <header class="sticky top-0 z-20 bg-white border-b border-slate-200
                   px-5 sm:px-8 py-5 flex items-center justify-between gap-4">

                <div class="flex items-center gap-3">

                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-slate-100"
                        aria-label="Buka menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-xl sm:text-2xl font-extrabold">
                            Kelola Properti
                        </h1>

                        <p class="text-sm text-slate-500 mt-1 hidden sm:block">
                            Kelola data properti RumahKita.
                        </p>
                    </div>

                </div>

                <button type="button" onclick="alert('Fitur tambah properti baru sedang dalam tahap pengembangan.')" class="shrink-0 inline-flex items-center gap-2
                       bg-sky-600 hover:bg-sky-700 text-white
                       px-4 py-3 rounded-xl text-sm font-bold transition">
                    <span class="text-lg leading-none">+</span>
                    <span class="hidden sm:inline">Tambah Properti</span>
                    <span class="sm:hidden">Tambah</span>
                </button>

            </header>

            <!-- ISI HALAMAN -->
            <div class="p-5 sm:p-8 space-y-7">

                <!-- STATISTIK -->
                <section class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    <div class="bg-white border border-slate-200 rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-500">
                                Total Properti
                            </p>

                            <div class="w-10 h-10 rounded-xl bg-sky-50
                                    text-sky-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10.5L12 3l9 7.5V21H3V10.5z" />
                                </svg>
                            </div>
                        </div>

                        <p class="text-3xl font-extrabold mt-4"><?= $total_properti ?></p>
                        <p class="text-xs text-slate-400 mt-1">
                            Seluruh data properti
                        </p>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-500">
                                Properti Aktif
                            </p>

                            <div class="w-10 h-10 rounded-xl bg-emerald-50
                                    text-emerald-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12l4 4L19 6" />
                                </svg>
                            </div>
                        </div>

                        <p class="text-3xl font-extrabold mt-4"><?= $properti_aktif ?></p>
                        <p class="text-xs text-slate-400 mt-1">
                            Properti berstatus aktif
                        </p>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-500">
                                Pending Review
                            </p>

                            <div class="w-10 h-10 rounded-xl bg-amber-50
                                    text-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" stroke-width="2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 7v5l3 2" />
                                </svg>
                            </div>
                        </div>

                        <p class="text-3xl font-extrabold mt-4"><?= $properti_pending ?></p>
                        <p class="text-xs text-slate-400 mt-1">
                            Menunggu verifikasi admin
                        </p>
                    </div>

                </section>

                <!-- TABEL PROPERTI -->
                <section class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">

                    <!-- Judul dan pencarian -->
                    <div class="p-5 sm:p-6 border-b border-slate-100
                           flex flex-col gap-4">
                        <div>
                            <h2 class="text-lg font-extrabold">
                                Daftar Properti
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Lihat dan kelola properti yang terdaftar.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <div class="relative flex-1">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2
                                       w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="7" stroke-width="2" />
                                    <path stroke-linecap="round" stroke-width="2" d="m16 16 4 4" />
                                </svg>

                                <input id="searchInput" type="search" placeholder="Cari nama, kode, atau lokasi properti..."
                                    class="w-full border border-slate-200 rounded-xl
                                       pl-10 pr-4 py-3 text-sm outline-none
                                       focus:border-sky-500 focus:ring-2
                                       focus:ring-sky-100">
                            </div>

                            <select id="statusFilter" class="sm:w-48 border border-slate-200 rounded-xl
                                   px-4 py-3 text-sm bg-white outline-none
                                   focus:border-sky-500">
                                <option value="">Semua Status</option>
                                <option value="draft">Draft</option>
                                <option value="pending">Pending</option>
                                <option value="aktif">Aktif</option>
                                <option value="terjual">Terjual</option>
                                <option value="ditolak">Ditolak</option>
                            </select>

                        </div>
                    </div>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">

                        <table class="w-full text-sm text-left">

                            <thead class="bg-slate-50 text-slate-500">
                                <tr class="text-xs uppercase tracking-wider">
                                    <th class="px-5 py-4 font-bold">
                                        Properti
                                    </th>

                                    <th class="px-5 py-4 font-bold">
                                        Lokasi
                                    </th>

                                    <th class="px-5 py-4 font-bold">
                                        Harga
                                    </th>

                                    <th class="px-5 py-4 font-bold">
                                        Status
                                    </th>

                                    <th class="px-5 py-4 font-bold text-right">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="propertyTable" class="divide-y divide-slate-100">
                                <?php foreach ($properti_list as $p): ?>
                                    <?php
                                    $st = strtolower(trim($p['status']));
                                    
                                    switch ($st) {
                                        case 'aktif':
                                            $status_classes = 'bg-emerald-50 text-emerald-700 border border-emerald-200';
                                            $status_label = 'Aktif';
                                            break;
                                        case 'pending':
                                            $status_classes = 'bg-amber-50 text-amber-700 border border-amber-200';
                                            $status_label = 'Pending';
                                            break;
                                        case 'terjual':
                                            $status_classes = 'bg-purple-50 text-purple-700 border border-purple-200';
                                            $status_label = 'Terjual';
                                            break;
                                        case 'ditolak':
                                            $status_classes = 'bg-rose-50 text-rose-700 border border-rose-200';
                                            $status_label = 'Ditolak';
                                            break;
                                        case 'draft':
                                        default:
                                            $status_classes = 'bg-slate-100 text-slate-600 border border-slate-200';
                                            $status_label = 'Draft';
                                            break;
                                    }
                                    ?>
                                    <tr class="property-row hover:bg-slate-50/70 transition"
                                        data-nama="<?= htmlspecialchars(strtolower($p['nama'] . ' ' . $p['kode'])) ?>"
                                        data-lokasi="<?= htmlspecialchars(strtolower($p['lokasi_singkat'] . ' ' . $p['alamat_lengkap'])) ?>"
                                        data-status="<?= htmlspecialchars($st) ?>">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <img src="<?= htmlspecialchars($p['foto_utama']) ?>" 
                                                     alt="<?= htmlspecialchars($p['nama']) ?>" 
                                                     class="w-14 h-12 rounded-xl object-cover border border-slate-200 shrink-0">
                                                <div class="min-w-0">
                                                    <p class="font-bold text-slate-900 truncate max-w-xs">
                                                        <?= htmlspecialchars($p['nama']) ?>
                                                    </p>
                                                    <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-400">
                                                        <span class="font-mono font-medium"><?= htmlspecialchars($p['kode']) ?></span>
                                                        <span>•</span>
                                                        <span><?= htmlspecialchars($p['tipe_label'] ?? ucfirst($p['kategori'])) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-5 py-4 text-slate-600">
                                            <p class="font-semibold text-slate-800 text-xs sm:text-sm"><?= htmlspecialchars($p['lokasi_singkat']) ?></p>
                                            <p class="text-xs text-slate-400 truncate max-w-[200px] mt-0.5" title="<?= htmlspecialchars($p['alamat_lengkap']) ?>">
                                                <?= htmlspecialchars($p['alamat_lengkap']) ?>
                                            </p>
                                        </td>

                                        <td class="px-5 py-4">
                                            <span class="font-bold text-slate-900 text-sm">
                                                <?= htmlspecialchars($p['harga_format']) ?>
                                            </span>
                                        </td>

                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold <?= $status_classes ?>">
                                                <?= $status_label ?>
                                            </span>
                                        </td>

                                        <td class="px-5 py-4 text-right">
                                            <div class="inline-flex items-center gap-1">
                                                <a href="<?= BASE_URL ?>/src/properti/detail.php?id=<?= $p['id'] ?>"
                                                   target="_blank"
                                                   class="p-2 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition"
                                                   title="Lihat Halaman Publik">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <button type="button"
                                                        onclick="editProperti(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['nama'])) ?>')"
                                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition"
                                                        title="Edit Properti">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                        onclick="hapusProperti(this, '<?= htmlspecialchars(addslashes($p['nama'])) ?>')"
                                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                        title="Hapus Properti">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- Row Kosong saat Pencarian / Filter Tidak Ditemukan -->
                                <tr id="noDataRow" class="hidden">
                                    <td colspan="5" class="px-5 py-14 text-center">
                                        <div class="mx-auto mb-3 w-12 h-12 rounded-2xl
                                               bg-slate-100 text-slate-400
                                               flex items-center justify-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <p class="font-bold text-slate-700">
                                            Tidak ada properti yang cocok
                                        </p>
                                        <p class="text-sm text-slate-400 mt-1">
                                            Coba gunakan kata kunci pencarian lain atau ubah filter status.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                    </div>

                    <!-- Footer tabel -->
                    <div class="px-5 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-slate-400">
                        <span id="propertyCountInfo">Menampilkan <?= $total_properti ?> dari <?= $total_properti ?> properti</span>
                        <span>RumahKita Admin Panel</span>
                    </div>

                </section>

            </div>
        </main>
    </div>

    <script>
    function toggleSidebar() {
        document.getElementById('sidebar')
            .classList.toggle('-translate-x-full');

        document.getElementById('overlay')
            .classList.toggle('hidden');
    }

    // Filter & Search handler
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const propertyRows = document.querySelectorAll('.property-row');
    const noDataRow = document.getElementById('noDataRow');
    const propertyCountInfo = document.getElementById('propertyCountInfo');
    const totalCount = propertyRows.length;

    function filterProperties() {
        const query = (searchInput.value || '').trim().toLowerCase();
        const selectedStatus = (statusFilter.value || '').trim().toLowerCase();
        let visibleCount = 0;

        propertyRows.forEach(row => {
            const nama = row.getAttribute('data-nama') || '';
            const lokasi = row.getAttribute('data-lokasi') || '';
            const status = row.getAttribute('data-status') || '';

            const matchQuery = !query || nama.includes(query) || lokasi.includes(query);
            const matchStatus = !selectedStatus || status === selectedStatus;

            if (matchQuery && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            noDataRow.classList.remove('hidden');
        } else {
            noDataRow.classList.add('hidden');
        }

        if (propertyCountInfo) {
            propertyCountInfo.textContent = `Menampilkan ${visibleCount} dari ${totalCount} properti`;
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterProperties);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', filterProperties);
    }

    function editProperti(id, nama) {
        alert(`Buka mode edit untuk properti:\n"${nama}" (ID: ${id})`);
    }

    function hapusProperti(btn, nama) {
        if (confirm(`Apakah Anda yakin ingin menghapus properti "${nama}"?`)) {
            const row = btn.closest('tr');
            if (row) {
                row.remove();
                filterProperties();
            }
        }
    }
    </script>

</body>

</html>