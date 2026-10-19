<?php
// src/layouts/header.php - Komponen header & navbar utama RumahKita

require_once __DIR__ . '/../../utils/sesi.php';

$current_page = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$is_home = (stripos($current_page, '/src/home/index.php') !== false) || (substr($current_page, -9) === 'index.php' && stripos($current_page, '/src/') === false);
$is_properti = stripos($current_page, '/src/properti/') !== false;
$is_auth = stripos($current_page, '/src/auth/') !== false;
$is_admin = stripos($current_page, '/src/admin/') !== false;

$user_aktif = penggunaAktif();

// Batasi akses: Admin HANYA bisa berada di dashboard admin, tidak boleh mengakses halaman utama publik
if (apakahAdmin() && stripos($current_page, '/src/admin/') === false) {
    header('Location: ' . BASE_URL . '/src/admin/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RumahKita — Temukan Hunian Impian Anda dengan Mudah</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#f0f9ff',
                        100: '#e0f2fe',
                        200: '#bae6fd',
                        300: '#7dd3fc',
                        400: '#38bdf8',
                        500: '#0ea5e9',
                        600: '#0284c7',
                        700: '#0369a1',
                        800: '#075985',
                        900: '#0c4a6e',
                    },
                    brand: {
                        light: '#f0f9ff',
                        soft: '#e0f2fe',
                        DEFAULT: '#0284c7',
                        dark: '#0369a1',
                    }
                },
                fontFamily: {
                    sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                }
            }
        }
    }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/global.css">
</head>

<body class="bg-[#f8fbff] text-slate-800 antialiased selection:bg-sky-200 selection:text-sky-900">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 w-full border-b border-sky-100/80 bg-white/90 backdrop-blur-xl transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo Brand -->
                <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-3 group shrink-0">
                    <div>
                        <span class="text-2xl font-extrabold tracking-tight text-slate-900">
                            Rumah<span class="text-sky-500">Kita</span>
                        </span>
                    </div>
                </a>

                <!-- Navigasi Desktop -->
                <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                    <a href="<?= BASE_URL ?>/index.php"
                        class="px-3.5 py-2 text-sm font-bold rounded-xl transition-all <?= $is_home ? 'text-sky-600 bg-sky-50' : 'text-slate-700 hover:text-sky-600 hover:bg-sky-50' ?>">
                        Beranda
                    </a>

                    <a href="<?= BASE_URL ?>/index.php#rekomendasi"
                        class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all text-slate-700 hover:text-sky-600 hover:bg-sky-50">
                        Katalog Properti
                    </a>

                    <a href="<?= BASE_URL ?>/index.php#paket"
                        class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition-all">
                        Paket
                    </a>

                </nav>

                <!-- Aksi Pengguna Desktop -->
                <div class="hidden md:flex items-center gap-3">
                    <?php if ($user_aktif): ?>
                    <!-- Tampilan Profil Singkat Pengguna yang Login -->
                    <div class="flex items-center gap-2.5 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-2xl">
                        <div
                            class="w-8 h-8 rounded-xl <?= $user_aktif['role'] === 'admin' ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700' ?> flex items-center justify-center font-bold text-xs">
                            <?= e(strtoupper(substr($user_aktif['name'], 0, 1))) ?>
                        </div>
                        <div class="text-left text-xs leading-tight">
                            <span
                                class="font-bold text-slate-900 block max-w-[120px] truncate"><?= e($user_aktif['name']) ?></span>
                            <span
                                class="text-[10px] uppercase font-semibold text-slate-400 block"><?= e($user_aktif['role']) ?></span>
                        </div>
                    </div>

                    <!-- Tombol Keluar -->
                    <a href="<?= BASE_URL ?>/src/auth/logout.php"
                        class="inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 rounded-xl transition-all duration-200"
                        title="Keluar dari akun">
                        Keluar
                    </a>
                    <?php else: ?>
                    <!-- Tombol Masuk / Daftar untuk Pengunjung -->
                    <a href="<?= BASE_URL ?>/src/auth/login.php" class="inline-flex items-center justify-center px-5 py-2.5 text-sm
                        font-semibold text-white bg-gradient-to-r from-sky-500 to-sky-600
                        hover:from-sky-600 hover:to-sky-700 rounded-xl shadow-md
                        shadow-sky-500/25 transition-all">
                        Masuk / Daftar
                    </a>
                    <?php endif; ?>
                </div>

                <!-- Tombol Hamburger Mobile -->
                <button id="mobile-menu-btn" type="button" class="md:hidden p-2.5 rounded-xl text-slate-600
                hover:text-sky-600 hover:bg-sky-50 transition-colors" aria-label="Buka menu" aria-expanded="false"
                    aria-controls="mobile-menu">

                    <svg id="menu-icon-open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>

                    <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
        </div>

        <!-- Menu Mobile -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-sky-100 bg-white px-4 py-4 space-y-2">

            <?php if ($user_aktif): ?>
            <div class="p-3 mb-2 bg-slate-50 border border-slate-100 rounded-xl flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-xl <?= $user_aktif['role'] === 'admin' ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700' ?> flex items-center justify-center font-bold text-sm">
                    <?= e(strtoupper(substr($user_aktif['name'], 0, 1))) ?>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-800"><?= e($user_aktif['name']) ?></p>
                    <p class="text-[10px] text-slate-400 capitalize">Peran: <?= e($user_aktif['role']) ?></p>
                </div>
            </div>
            <?php endif; ?>

            <a href="<?= BASE_URL ?>/index.php"
                class="block px-4 py-3 rounded-xl <?= $is_home ? 'bg-sky-50 text-sky-700 font-bold' : 'text-slate-700 hover:bg-sky-50 font-semibold' ?> text-sm">
                Beranda
            </a>

            <a href="<?= BASE_URL ?>/index.php#rekomendasi"
                class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-sky-50 font-semibold text-sm">
                Katalog Properti
            </a>

            <a href="<?= BASE_URL ?>/index.php#paket"
                class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-sky-50 hover:text-sky-600 font-semibold text-sm">
                Paket
            </a>



            <?php if ($user_aktif): ?>
            <a href="<?= BASE_URL ?>/src/auth/logout.php"
                class="block text-center px-4 py-3 mt-3 rounded-xl text-rose-700 bg-rose-50 hover:bg-rose-100 font-bold text-sm border border-rose-200">
                Keluar Akun
            </a>
            <?php else: ?>
            <a href="<?= BASE_URL ?>/src/auth/login.php" class="block text-center px-4 py-3 mt-3 rounded-xl text-white
            bg-gradient-to-r from-sky-500 to-sky-600 font-bold text-sm">
                Masuk / Daftar
            </a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Interaksi Menu Mobile -->
    <script>
    (() => {
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');

        if (!mobileBtn || !mobileMenu || !iconOpen || !iconClose) return;

        mobileBtn.addEventListener('click', () => {
            const isOpening = mobileMenu.classList.contains('hidden');

            mobileMenu.classList.toggle('hidden', !isOpening);
            iconOpen.classList.toggle('hidden', isOpening);
            iconClose.classList.toggle('hidden', !isOpening);

            mobileBtn.setAttribute('aria-expanded', String(isOpening));
            mobileBtn.setAttribute(
                'aria-label',
                isOpening ? 'Tutup menu' : 'Buka menu'
            );
        });

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
                mobileBtn.setAttribute('aria-expanded', 'false');
                mobileBtn.setAttribute('aria-label', 'Buka menu');
            });
        });
    })();
    </script>