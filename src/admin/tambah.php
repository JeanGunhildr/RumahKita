<?php
// src/admin/tambah.php - Halaman formulir tambah properti baru admin RumahKita

require_once __DIR__ . '/../../utils/koneksi.php';
require_once __DIR__ . '/../../utils/sesi.php';
require_once __DIR__ . '/../../utils/validasi.php';

wajibPeran('admin');

$errors = [];
$form = [
    'title'            => '',
    'property_type'    => 'minimalis',
    'price'            => '',
    'city'             => '',
    'province'         => '',
    'address'          => '',
    'bedrooms'         => '',
    'bathrooms'        => '',
    'building_area'    => '',
    'land_area'        => '',
    'certificate_type' => 'SHM',
    'status'           => 'active',
    'description'      => '',
];

$fasilitas_terpilih = [];
$whitelist_type = ['minimalis', 'cluster', 'villa', 'apartemen'];
$whitelist_sertifikat = ['SHM', 'SHGB', 'Strata Title', 'Lainnya'];
$whitelist_status = ['active', 'pending', 'draft', 'sold', 'rejected'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['title']            = trim($_POST['title'] ?? '');
    $form['property_type']    = trim($_POST['property_type'] ?? '');
    $form['price']            = trim($_POST['price'] ?? '');
    $form['city']             = trim($_POST['city'] ?? '');
    $form['province']         = trim($_POST['province'] ?? '');
    $form['address']          = trim($_POST['address'] ?? '');
    $form['bedrooms']         = trim($_POST['bedrooms'] ?? '');
    $form['bathrooms']        = trim($_POST['bathrooms'] ?? '');
    $form['building_area']    = trim($_POST['building_area'] ?? '');
    $form['land_area']        = trim($_POST['land_area'] ?? '');
    $form['certificate_type'] = trim($_POST['certificate_type'] ?? '');
    $form['status']           = trim($_POST['status'] ?? 'active');
    $form['description']      = trim($_POST['description'] ?? '');

    // Ambil fasilitas dari input form
    if (isset($_POST['facilities']) && is_array($_POST['facilities'])) {
        foreach ($_POST['facilities'] as $fac) {
            $cleanFac = trim($fac);
            if ($cleanFac !== '' && !in_array($cleanFac, $fasilitas_terpilih, true)) {
                $fasilitas_terpilih[] = $cleanFac;
            }
        }
    }

    // 1. Validasi Judul
    $errJudul = validasiTeks($form['title'], 'Judul properti', 3, 150);
    if ($errJudul) $errors['title'] = $errJudul;

    // 2. Validasi Tipe Properti
    $errType = validasiPilihan($form['property_type'], $whitelist_type, 'Tipe properti');
    if ($errType) $errors['property_type'] = $errType;

    // 3. Validasi Harga
    $errPrice = validasiAngka($form['price'], 'Harga properti', 1000000, 100000000000);
    if ($errPrice) $errors['price'] = $errPrice;

    // 4. Validasi Kota & Provinsi
    $errCity = validasiTeks($form['city'], 'Kota / Kabupaten', 3, 100);
    if ($errCity) $errors['city'] = $errCity;

    $errProvince = validasiTeks($form['province'], 'Provinsi', 3, 100);
    if ($errProvince) $errors['province'] = $errProvince;

    // 5. Validasi Alamat
    if (mb_strlen($form['address'], 'UTF-8') < 5) {
        $errors['address'] = 'Alamat lengkap wajib diisi minimal 5 karakter.';
    }

    // 6. Validasi Kamar Tidur & Mandi
    if ($form['bedrooms'] !== '') {
        $errBed = validasiAngka($form['bedrooms'], 'Jumlah kamar tidur', 0, 50);
        if ($errBed) $errors['bedrooms'] = $errBed;
    }
    if ($form['bathrooms'] !== '') {
        $errBath = validasiAngka($form['bathrooms'], 'Jumlah kamar mandi', 0, 50);
        if ($errBath) $errors['bathrooms'] = $errBath;
    }

    // 7. Validasi Luas Bangunan & Tanah
    if ($form['building_area'] !== '') {
        $errBA = validasiAngka($form['building_area'], 'Luas bangunan', 10, 50000);
        if ($errBA) $errors['building_area'] = $errBA;
    }
    if ($form['land_area'] !== '') {
        $errLA = validasiAngka($form['land_area'], 'Luas tanah', 10, 50000);
        if ($errLA) $errors['land_area'] = $errLA;
    }

    // 8. Validasi Status
    if (!in_array($form['status'], $whitelist_status, true)) {
        $form['status'] = 'active';
    }

    // 9. Validasi Deskripsi
    $errDesc = validasiDeskripsi($form['description'], 'Deskripsi properti', 2000);
    if ($errDesc) $errors['description'] = $errDesc;

    // 10. Validasi Berkas Gambar Properti (Maksimal 1 file per properti)
    $has_image_file = isset($_FILES['property_image']) && $_FILES['property_image']['error'] !== UPLOAD_ERR_NO_FILE;
    if ($has_image_file) {
        $file = $_FILES['property_image'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors['property_image'] = 'Terjadi kesalahan saat mengunggah berkas gambar.';
        } elseif ($file['size'] > 5 * 1024 * 1024) {
            $errors['property_image'] = 'Ukuran gambar maksimal adalah 5 MB.';
        } else {
            $allowed_exts = ['jpg', 'jpeg', 'png', 'webp'];
            $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($file_ext, $allowed_exts, true) || !in_array($mime_type, $allowed_mimes, true)) {
                $errors['property_image'] = 'Format gambar tidak didukung. Gunakan format JPG, PNG, atau WEBP.';
            }
        }
    }

    // Jika seluruh validasi berhasil, simpan ke database
    if (empty($errors)) {
        $current_user = penggunaAktif();
        $user_id = $current_user['id'];
        $property_id = 'PR-' . strtoupper(substr(uniqid(), -6));

        $price_num     = (float)$form['price'];
        $bedrooms_num  = ($form['bedrooms'] !== '') ? (int)$form['bedrooms'] : null;
        $bathrooms_num = ($form['bathrooms'] !== '') ? (int)$form['bathrooms'] : null;
        $b_area_num    = ($form['building_area'] !== '') ? (float)$form['building_area'] : null;
        $l_area_num    = ($form['land_area'] !== '') ? (float)$form['land_area'] : null;

        $sql = "INSERT INTO properties (
                    id, user_id, title, description, property_type, price, 
                    address, city, province, bedrooms, bathrooms, 
                    building_area, land_area, certificate_type, status
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param(
                'sisssdsssiddsss',
                $property_id,
                $user_id,
                $form['title'],
                $form['description'],
                $form['property_type'],
                $price_num,
                $form['address'],
                $form['city'],
                $form['province'],
                $bedrooms_num,
                $bathrooms_num,
                $b_area_num,
                $l_area_num,
                $form['certificate_type'],
                $form['status']
            );

            try {
                $stmt->execute();
                $stmt->close();

                // Simpan berkas gambar jika diunggah
                if ($has_image_file) {
                    $upload_dir = __DIR__ . '/../../public/uploads/properties/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $file_ext = strtolower(pathinfo($_FILES['property_image']['name'], PATHINFO_EXTENSION));
                    $filename = 'prop_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_ext;
                    $target_file = $upload_dir . $filename;

                    if (move_uploaded_file($_FILES['property_image']['tmp_name'], $target_file)) {
                        $saved_rel_path = 'public/uploads/properties/' . $filename;
                        $sqlImg = "INSERT INTO property_images (property_id, image_path, is_primary) VALUES (?, ?, 1)";
                        $stmtImg = $conn->prepare($sqlImg);
                        if ($stmtImg) {
                            $stmtImg->bind_param('ss', $property_id, $saved_rel_path);
                            $stmtImg->execute();
                            $stmtImg->close();
                        }
                    }
                }

                // Simpan daftar fasilitas properti (bebas jumlahnya)
                if (!empty($fasilitas_terpilih)) {
                    $sqlFac = "INSERT INTO property_facilities (property_id, facility_name) VALUES (?, ?)";
                    $stmtFac = $conn->prepare($sqlFac);
                    if ($stmtFac) {
                        foreach ($fasilitas_terpilih as $fName) {
                            $fName = mb_substr(trim($fName), 0, 100, 'UTF-8');
                            if ($fName !== '') {
                                $stmtFac->bind_param('ss', $property_id, $fName);
                                $stmtFac->execute();
                            }
                        }
                        $stmtFac->close();
                    }
                }

                $_SESSION['flash_sukses'] = "Properti '{$form['title']}' berhasil ditambahkan!";
                header('Location: ' . BASE_URL . '/src/admin/index.php');
                exit;
            } catch (mysqli_sql_exception $e) {
                error_log('Insert Property Error: ' . $e->getMessage());
                $errors['umum'] = 'Terjadi kesalahan sistem saat menyimpan properti ke database.';
            }
        } else {
            error_log('Prepare Property Error: ' . $conn->error);
            $errors['umum'] = 'Gagal menyiapkan perintah simpan properti.';
        }
    }
}

$admin_user = penggunaAktif();
$admin_name = $admin_user['name'] ?? 'Admin';
$admin_role = ucfirst($admin_user['role'] ?? 'admin');
$admin_initial = strtoupper(substr($admin_name, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Properti Baru | Panel Admin RumahKita</title>

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
                <a href="<?= BASE_URL ?>/src/admin/index.php" class="sidebar-link text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10.5L12 3l9 7.5V21H3V10.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 21v-7h6v7" />
                    </svg>
                    Kelola Properti
                </a>

                <a href="<?= BASE_URL ?>/src/admin/tambah.php" class="sidebar-link sidebar-active">
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

            <!-- HEADER ATAS -->
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
                            Tambah Properti
                        </h1>
                        <p class="text-sm text-slate-500 mt-0.5 hidden sm:block">
                            Formulir penambahan listing properti baru ke katalog publik RumahKita.
                        </p>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>/src/admin/index.php"
                    class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    &larr; <span class="hidden sm:inline">Kembali ke</span> Dashboard
                </a>
            </header>

            <!-- ISI FORMULIR -->
            <div class="p-5 sm:p-8 max-w-4xl">

                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">

                    <div class="border-b border-slate-100 pb-5 mb-8">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold mb-2 border border-emerald-200">
                            <span>Khusus Administrator</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Rincian Properti Baru</h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Lengkapi seluruh data properti berikut untuk diterbitkan ke katalog publik RumahKita.
                        </p>
                    </div>

                    <?php if (!empty($errors['umum'])): ?>
                    <div
                        class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-medium flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?= e($errors['umum']) ?></span>
                    </div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>/src/admin/tambah.php" method="POST" enctype="multipart/form-data"
                        class="space-y-8" novalidate>

                        <!-- 1. Informasi Utama -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-slate-900 border-l-4 border-sky-600 pl-3">1. Informasi
                                Utama</h3>

                            <div>
                                <label for="title"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Nama / Judul Properti <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="title" name="title" value="<?= e($form['title']) ?>" required
                                    placeholder="Contoh: Grand Royal Mansion Jagakarsa"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['title']) ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                <?php if (isset($errors['title'])): ?>
                                <p class="text-xs text-rose-600 mt-1.5 font-medium"><?= e($errors['title']) ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label for="property_type"
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Tipe Properti <span class="text-rose-500">*</span>
                                    </label>
                                    <select id="property_type" name="property_type" required
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['property_type']) ? 'border-rose-400' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                        <option value="minimalis"
                                            <?= $form['property_type'] === 'minimalis' ? 'selected' : '' ?>>Rumah
                                            Minimalis</option>
                                        <option value="cluster"
                                            <?= $form['property_type'] === 'cluster' ? 'selected' : '' ?>>Rumah Cluster
                                        </option>
                                        <option value="villa"
                                            <?= $form['property_type'] === 'villa' ? 'selected' : '' ?>>Villa Mewah
                                        </option>
                                        <option value="apartemen"
                                            <?= $form['property_type'] === 'apartemen' ? 'selected' : '' ?>>Apartemen
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="price"
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Harga (Rp) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="number" id="price" name="price" value="<?= e($form['price']) ?>"
                                        required placeholder="Contoh: 850000000" min="1000000" step="1000000"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['price']) ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                    <?php if (isset($errors['price'])): ?>
                                    <p class="text-xs text-rose-600 mt-1.5 font-medium"><?= e($errors['price']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label for="status"
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Status Publikasi <span class="text-rose-500">*</span>
                                    </label>
                                    <select id="status" name="status" required
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                        <option value="active" <?= $form['status'] === 'active' ? 'selected' : '' ?>>
                                            Aktif (Tayang)</option>
                                        <option value="pending" <?= $form['status'] === 'pending' ? 'selected' : '' ?>>
                                            Pending Review</option>
                                        <option value="draft" <?= $form['status'] === 'draft' ? 'selected' : '' ?>>Draft
                                        </option>
                                        <option value="sold" <?= $form['status'] === 'sold' ? 'selected' : '' ?>>Terjual
                                            (Sold)</option>
                                        <option value="rejected"
                                            <?= $form['status'] === 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Lokasi Properti -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-slate-900 border-l-4 border-sky-600 pl-3">2. Lokasi
                                Properti</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="city"
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Kota / Kabupaten <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" id="city" name="city" value="<?= e($form['city']) ?>" required
                                        placeholder="Contoh: Jakarta Selatan"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['city']) ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                    <?php if (isset($errors['city'])): ?>
                                    <p class="text-xs text-rose-600 mt-1.5 font-medium"><?= e($errors['city']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label for="province"
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Provinsi <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" id="province" name="province" value="<?= e($form['province']) ?>"
                                        required placeholder="Contoh: DKI Jakarta"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['province']) ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                    <?php if (isset($errors['province'])): ?>
                                    <p class="text-xs text-rose-600 mt-1.5 font-medium"><?= e($errors['province']) ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div>
                                <label for="address"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Alamat Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <textarea id="address" name="address" rows="2" required
                                    placeholder="Contoh: Jl. Margonda Raya No. 12, RT 02/RW 04"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['address']) ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"><?= e($form['address']) ?></textarea>
                                <?php if (isset($errors['address'])): ?>
                                <p class="text-xs text-rose-600 mt-1.5 font-medium"><?= e($errors['address']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 3. Spesifikasi Fisik & Legalitas -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-slate-900 border-l-4 border-sky-600 pl-3">3. Spesifikasi
                                & Sertifikat</h3>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                <div>
                                    <label for="bedrooms"
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Kamar Tidur
                                    </label>
                                    <input type="number" id="bedrooms" name="bedrooms"
                                        value="<?= e($form['bedrooms']) ?>" min="0" max="50" placeholder="Contoh: 3"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['bedrooms']) ? 'border-rose-400' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                </div>

                                <div>
                                    <label for="bathrooms"
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Kamar Mandi
                                    </label>
                                    <input type="number" id="bathrooms" name="bathrooms"
                                        value="<?= e($form['bathrooms']) ?>" min="0" max="50" placeholder="Contoh: 2"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['bathrooms']) ? 'border-rose-400' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                </div>

                                <div>
                                    <label for="building_area"
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Luas Bangunan (m²)
                                    </label>
                                    <input type="number" id="building_area" name="building_area"
                                        value="<?= e($form['building_area']) ?>" min="10" step="1"
                                        placeholder="Contoh: 120"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['building_area']) ? 'border-rose-400' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                </div>

                                <div>
                                    <label for="land_area"
                                        class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                        Luas Tanah (m²)
                                    </label>
                                    <input type="number" id="land_area" name="land_area"
                                        value="<?= e($form['land_area']) ?>" min="10" step="1" placeholder="Contoh: 150"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['land_area']) ? 'border-rose-400' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                </div>
                            </div>

                            <div>
                                <label for="certificate_type"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Jenis Sertifikat
                                </label>
                                <select id="certificate_type" name="certificate_type"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                    <option value="SHM" <?= $form['certificate_type'] === 'SHM' ? 'selected' : '' ?>>SHM
                                        — Sertifikat Hak Milik</option>
                                    <option value="SHGB" <?= $form['certificate_type'] === 'SHGB' ? 'selected' : '' ?>>
                                        SHGB — Sertifikat Hak Guna Bangunan</option>
                                    <option value="Strata Title"
                                        <?= $form['certificate_type'] === 'Strata Title' ? 'selected' : '' ?>>Strata
                                        Title (Apartemen)</option>
                                    <option value="Lainnya"
                                        <?= $form['certificate_type'] === 'Lainnya' ? 'selected' : '' ?>>Lainnya
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- 4. Fasilitas Properti (Bebas Jumlahnya) -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-slate-900 border-l-4 border-sky-600 pl-3">4. Fasilitas
                                Properti</h3>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Tambah Fasilitas (Bebas Jumlahnya)
                                </label>
                                <p class="text-xs text-slate-400 mb-3">
                                    Ketik fasilitas lalu klik Tambah, atau klik salah satu rekomendasi fasilitas cepat
                                    di bawah.
                                </p>

                                <!-- Rekomendasi Cepat -->
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <button type="button" onclick="tambahFasilitasOtomatis('Kolam Renang')"
                                        class="px-2.5 py-1 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-semibold border border-sky-200 transition">+
                                        Kolam Renang</button>
                                    <button type="button" onclick="tambahFasilitasOtomatis('Garasi Mobil')"
                                        class="px-2.5 py-1 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-semibold border border-sky-200 transition">+
                                        Garasi Mobil</button>
                                    <button type="button" onclick="tambahFasilitasOtomatis('Taman Asri')"
                                        class="px-2.5 py-1 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-semibold border border-sky-200 transition">+
                                        Taman Asri</button>
                                    <button type="button" onclick="tambahFasilitasOtomatis('Keamanan 24 Jam')"
                                        class="px-2.5 py-1 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-semibold border border-sky-200 transition">+
                                        Keamanan 24 Jam</button>
                                    <button type="button" onclick="tambahFasilitasOtomatis('CCTV')"
                                        class="px-2.5 py-1 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-semibold border border-sky-200 transition">+
                                        CCTV</button>
                                    <button type="button" onclick="tambahFasilitasOtomatis('WiFi Cepat')"
                                        class="px-2.5 py-1 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-semibold border border-sky-200 transition">+
                                        WiFi Cepat</button>
                                    <button type="button" onclick="tambahFasilitasOtomatis('AC Tiap Kamar')"
                                        class="px-2.5 py-1 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-semibold border border-sky-200 transition">+
                                        AC Tiap Kamar</button>
                                    <button type="button" onclick="tambahFasilitasOtomatis('Balkon Luas')"
                                        class="px-2.5 py-1 bg-sky-50 hover:bg-sky-100 text-sky-700 rounded-lg text-xs font-semibold border border-sky-200 transition">+
                                        Balkon Luas</button>
                                </div>

                                <!-- Input Fasilitas Manual -->
                                <div class="flex gap-2">
                                    <input type="text" id="input-fasilitas"
                                        placeholder="Ketik nama fasilitas lainnya..."
                                        class="flex-1 px-4 py-2.5 rounded-xl bg-slate-50/70 border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                                    <button type="button" onclick="tambahFasilitasDariInput()"
                                        class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition">
                                        + Tambah
                                    </button>
                                </div>

                                <!-- Container Tag Fasilitas yang Dipilih -->
                                <div id="fasilitas-container"
                                    class="flex flex-wrap gap-2 mt-4 p-3 bg-slate-50/60 rounded-2xl border border-slate-200 min-h-[48px] items-center">
                                    <?php if (empty($fasilitas_terpilih)): ?>
                                    <span id="fasilitas-kosong-note" class="text-xs text-slate-400 italic">Belum ada
                                        fasilitas ditambahkan.</span>
                                    <?php else: ?>
                                    <?php foreach ($fasilitas_terpilih as $idx => $facItem): ?>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-sky-100 text-sky-800 rounded-xl text-xs font-bold border border-sky-200 facility-tag">
                                        <span><?= e($facItem) ?></span>
                                        <input type="hidden" name="facilities[]" value="<?= e($facItem) ?>">
                                        <button type="button" onclick="hapusFasilitas(this)"
                                            class="text-sky-600 hover:text-rose-600 transition font-black ml-1">&times;</button>
                                    </span>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Gambar & Deskripsi Properti -->
                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-slate-900 border-l-4 border-sky-600 pl-3">5. Gambar &
                                Deskripsi</h3>

                            <!-- Unggah Gambar Properti (Maksimal 1 Gambar) -->
                            <div>
                                <label for="property_image"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Unggah Foto Utama Properti <span class="text-slate-400 font-normal">(Maksimal 1
                                        foto, format JPG/PNG/WEBP, maks 5 MB)</span>
                                </label>

                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 <?= isset($errors['property_image']) ? 'border-rose-400 bg-rose-50/10' : 'border-slate-200' ?> border-dashed rounded-2xl bg-slate-50/50 hover:border-sky-400 transition">
                                    <div class="space-y-2 text-center">
                                        <div id="image-preview-container" class="hidden mx-auto mb-3 max-w-xs">
                                            <img id="image-preview" src="#" alt="Pratinjau Foto"
                                                class="rounded-xl h-40 w-full object-cover border border-slate-200 shadow-sm mx-auto">
                                        </div>

                                        <svg id="upload-icon" class="mx-auto h-10 w-10 text-slate-400"
                                            stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>

                                        <div class="flex text-sm text-slate-600 justify-center">
                                            <label for="property_image"
                                                class="relative cursor-pointer bg-white rounded-md font-bold text-sky-600 hover:text-sky-500 focus-within:outline-none">
                                                <span>Pilih Berkas Gambar</span>
                                                <input id="property_image" name="property_image" type="file"
                                                    accept="image/jpeg,image/png,image/webp" class="sr-only"
                                                    onchange="previewImage(this)">
                                            </label>
                                            <p class="pl-1 text-slate-500">atau tarik ke sini</p>
                                        </div>
                                        <p class="text-[11px] text-slate-400">JPG, PNG, atau WEBP hingga 5 MB</p>
                                        <p id="file-name-chosen" class="text-xs text-sky-700 font-semibold mt-1 hidden">
                                        </p>
                                    </div>
                                </div>
                                <?php if (isset($errors['property_image'])): ?>
                                <p class="text-xs text-rose-600 mt-1.5 font-medium"><?= e($errors['property_image']) ?>
                                </p>
                                <?php endif; ?>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="description"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Deskripsi Properti <span class="text-slate-400 font-normal">(maksimal 2.000
                                        karakter)</span>
                                </label>
                                <textarea id="description" name="description" rows="4" maxlength="2000"
                                    placeholder="Jelaskan keunggulan hunian, fasilitas lingkungan, akses transportasi, dan kondisi fisik properti..."
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50/70 border <?= isset($errors['description']) ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200' ?> text-sm focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"><?= e($form['description']) ?></textarea>
                                <?php if (isset($errors['description'])): ?>
                                <p class="text-xs text-rose-600 mt-1.5 font-medium"><?= e($errors['description']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                            <a href="<?= BASE_URL ?>/src/admin/index.php"
                                class="px-6 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 rounded-xl text-sm font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-500/20 transition-all">
                                Simpan Properti
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>

    </div>

    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    // Penanganan Fasilitas Dinamis
    function tambahFasilitasOtomatis(nama) {
        tambahTagFasilitas(nama);
    }

    function tambahFasilitasDariInput() {
        const input = document.getElementById('input-fasilitas');
        const val = input.value.trim();
        if (val) {
            tambahTagFasilitas(val);
            input.value = '';
            input.focus();
        }
    }

    document.getElementById('input-fasilitas').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            tambahFasilitasDariInput();
        }
    });

    function tambahTagFasilitas(nama) {
        const container = document.getElementById('fasilitas-container');
        const note = document.getElementById('fasilitas-kosong-note');
        if (note) note.remove();

        // Cek duplikat
        const existing = container.querySelectorAll('input[name="facilities[]"]');
        for (let item of existing) {
            if (item.value.toLowerCase() === nama.toLowerCase()) {
                return;
            }
        }

        const span = document.createElement('span');
        span.className =
            'inline-flex items-center gap-1.5 px-3 py-1.5 bg-sky-100 text-sky-800 rounded-xl text-xs font-bold border border-sky-200 facility-tag';
        span.innerHTML = `
            <span>${escapeHtml(nama)}</span>
            <input type="hidden" name="facilities[]" value="${escapeHtml(nama)}">
            <button type="button" onclick="hapusFasilitas(this)" class="text-sky-600 hover:text-rose-600 transition font-black ml-1">&times;</button>
        `;
        container.appendChild(span);
    }

    function hapusFasilitas(btn) {
        const tag = btn.closest('.facility-tag');
        if (tag) tag.remove();

        const container = document.getElementById('fasilitas-container');
        if (container.querySelectorAll('.facility-tag').length === 0) {
            container.innerHTML =
                '<span id="fasilitas-kosong-note" class="text-xs text-slate-400 italic">Belum ada fasilitas ditambahkan.</span>';
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Pratinjau Gambar Upload
    function previewImage(input) {
        const previewContainer = document.getElementById('image-preview-container');
        const previewImg = document.getElementById('image-preview');
        const fileNameEl = document.getElementById('file-name-chosen');
        const uploadIcon = document.getElementById('upload-icon');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
                if (uploadIcon) uploadIcon.classList.add('hidden');
                fileNameEl.textContent = 'Berkas dipilih: ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(
                    2) + ' MB)';
                fileNameEl.classList.remove('hidden');
            }

            reader.readAsDataURL(file);
        }
    }
    </script>

</body>

</html>