<?php
if (!defined('BASE_URL')) {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    define('BASE_URL', stripos($scriptName, '/RumahKita') !== false ? '/RumahKita' : '');
}

$current_page = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$is_home = (stripos($current_page, '/src/home/index.php') !== false) || (substr($current_page, -9) === 'index.php' && stripos($current_page, '/src/') === false);
$is_properti = stripos($current_page, '/src/properti/') !== false;
$is_auth = stripos($current_page, '/src/auth/') !== false;
$is_admin = stripos($current_page, '/src/admin/') !== false;
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
                <a href="<?= BASE_URL ?>/src/home/index.php" class="flex items-center gap-3 group shrink-0">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-sky-600 to-sky-400
                    flex items-center justify-center shadow-md shadow-sky-500/25
                    group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>

                    <div>
                        <span class="text-2xl font-extrabold tracking-tight text-slate-900 group-hover:text-sky-600 transition-colors">
                            Rumah<span class="text-sky-500">Kita</span>
                        </span>
                        <span class="block text-[10px] font-semibold uppercase tracking-wider text-sky-600 -mt-1">
                            Properti Idaman
                        </span>
                    </div>
                </a>

                <!-- Navigasi Desktop -->
                <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                    <a href="<?= BASE_URL ?>/src/home/index.php"
                        class="px-3.5 py-2 text-sm font-bold rounded-xl transition-all <?= $is_home ? 'text-sky-600 bg-sky-50' : 'text-slate-700 hover:text-sky-600 hover:bg-sky-50' ?>">
                        Beranda
                    </a>

                    <a href="<?= BASE_URL ?>/src/properti/index.php" 
                        class="px-3.5 py-2 text-sm font-semibold rounded-xl transition-all <?= $is_properti ? 'text-sky-600 bg-sky-50' : 'text-slate-700 hover:text-sky-600 hover:bg-sky-50' ?>">
                        Cari Rumah
                    </a>

                    <a href="<?= BASE_URL ?>/src/home/index.php#paket" 
                        class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition-all">
                        Paket
                    </a>

                    <a href="<?= BASE_URL ?>/src/home/index.php#cara-beli" 
                        class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition-all">
                        Cara Beli
                    </a>

                    <a href="<?= BASE_URL ?>/src/admin/index.php" 
                        class="px-3.5 py-2 text-sm font-semibold text-slate-700 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition-all flex items-center gap-1.5">
                        <span>Admin</span>
                        <span class="text-[9px] bg-sky-100 text-sky-700 font-bold px-1.5 py-0.5 rounded">Kelola</span>
                    </a>
                </nav>

                <!-- Aksi Desktop -->
                <div class="hidden md:flex items-center gap-3">

                    <a href="<?= BASE_URL ?>/src/properti/index.php#jual" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold
                    text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200/80
                    rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Jual Rumah
                    </a>

                    <a href="<?= BASE_URL ?>/src/auth/login.php" class="inline-flex items-center justify-center px-5 py-2.5 text-sm
                    font-semibold text-white bg-gradient-to-r from-sky-500 to-sky-600
                    hover:from-sky-600 hover:to-sky-700 rounded-xl shadow-md
                    shadow-sky-500/25 transition-all">
                        Masuk / Daftar
                    </a>
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

            <a href="<?= BASE_URL ?>/src/home/index.php"
                class="block px-4 py-3 rounded-xl <?= $is_home ? 'bg-sky-50 text-sky-700 font-bold' : 'text-slate-700 hover:bg-sky-50 font-semibold' ?> text-sm">
                Beranda
            </a>

            <a href="<?= BASE_URL ?>/src/properti/index.php" 
                class="block px-4 py-3 rounded-xl <?= $is_properti ? 'bg-sky-50 text-sky-700 font-bold' : 'text-slate-700 hover:bg-sky-50 font-semibold' ?> text-sm">
                Cari Rumah
            </a>

            <a href="<?= BASE_URL ?>/src/home/index.php#paket" 
                class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-sky-50 hover:text-sky-600 font-semibold text-sm">
                Paket
            </a>

            <a href="<?= BASE_URL ?>/src/home/index.php#cara-beli" 
                class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-sky-50 hover:text-sky-600 font-semibold text-sm">
                Cara Beli
            </a>

            <a href="<?= BASE_URL ?>/src/admin/index.php" 
                class="block px-4 py-3 rounded-xl text-slate-700 hover:bg-sky-50 hover:text-sky-600 font-semibold text-sm">
                Panel Admin
            </a>

            <a href="<?= BASE_URL ?>/src/properti/index.php#jual" 
                class="block px-4 py-3 rounded-xl text-sky-700 bg-sky-50 hover:bg-sky-100 font-semibold text-sm">
                + Jual Rumah
            </a>

            <a href="<?= BASE_URL ?>/src/auth/login.php" class="block text-center px-4 py-3 mt-3 rounded-xl text-white
            bg-gradient-to-r from-sky-500 to-sky-600 font-bold text-sm">
                Masuk / Daftar
            </a>
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