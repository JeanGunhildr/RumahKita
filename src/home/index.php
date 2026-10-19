<?php 
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../data/properti_data.php'; 

$semua_rekomendasi = get_all_properti();
?>

<main class="relative overflow-hidden">

    <!-- Subtle Background Glows (Biru Muda ke Putih) -->
    <div class="hero-glow top-0 left-1/4 -translate-x-1/2"></div>
    <div class="hero-glow top-96 right-0"></div>

    <!-- ========================================== -->
    <!-- 1. HERO SECTION                            -->
    <!-- ========================================== -->
    <section id="hero"
        class="relative pt-8 pb-16 lg:pt-14 lg:pb-24 bg-gradient-to-b from-sky-100/70 via-sky-50/40 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">

                <!-- Kolom Kiri: Copywriting & CTA -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">

                    <!-- Badge Sambutan -->
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/90 border border-sky-200/80 shadow-sm shadow-sky-100 text-sky-700 text-xs sm:text-sm font-semibold">
                        <span>✦ Platform Marketplace Properti Terpercaya #1 di Indonesia</span>
                    </div>

                    <!-- Judul Utama -->
                    <h1 class=" text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight
                            leading-[1.15]">
                        Temukan Rumah Impian <br class="hidden sm:inline">
                        <span
                            class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-600 bg-clip-text text-transparent">
                            Mudah, Cepat & Terpercaya.
                        </span>
                    </h1>

                    <!-- Deskripsi Singkat -->
                    <p
                        class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        Jelajahi ribuan pilihan rumah, villa eksklusif, dan hunian modern berlegalitas resmi.
                        Dapatkan
                        simulasi KPR transparan serta pendampingan agen profesional hingga serah terima kunci.
                    </p>

                    <!-- Tombol Aksi Utama -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="<?= BASE_URL ?>/src/properti/index.php"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-4 text-base font-bold text-white bg-gradient-to-r from-sky-500 via-sky-600 to-blue-600 hover:from-sky-600 hover:to-blue-700 rounded-2xl shadow-lg shadow-sky-500/30 hover:shadow-xl hover:shadow-sky-500/40 hover:-translate-y-0.5 transition-all duration-200">
                            <span>Jelajahi Listing Rumah</span>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="#cara-beli"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 text-base font-semibold text-slate-700 bg-white hover:bg-sky-50/80 border border-sky-200/90 rounded-2xl shadow-sm hover:shadow transition-all duration-200">
                            <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Panduan Cara Beli</span>
                        </a>
                    </div>



                </div>

                <!-- Kolom Kanan: Card Showcase Visual Properti (Sesuai Layout Gambar) -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">

                        <!-- Main Featured Card Image -->
                        <div
                            class="relative rounded-3xl overflow-hidden shadow-2xl shadow-sky-200/50 border-4 border-white group">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1000&q=80"
                                alt="Rumah Mewah Modern RumahKita"
                                class="w-full h-[400px] sm:h-[460px] object-cover object-center group-hover:scale-105 transition-transform duration-700 ease-out">

                            <!-- Overlay Gradient -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/20 to-transparent">
                            </div>

                            <!-- Bottom Card Info -->
                            <div class="absolute bottom-6 left-6 right-6 text-white space-y-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-3 py-1 bg-sky-500/90 backdrop-blur-md rounded-full text-xs font-bold tracking-wide uppercase">
                                        Unit Terverifikasi
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold">
                                        Sertifikat SHM
                                    </span>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold tracking-tight text-white drop-shadow-md">
                                    Emerald Panorama Residence
                                </h3>
                                <p class="text-sky-100 text-xs sm:text-sm flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-sky-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    Cilandak, Jakarta Selatan
                                </p>
                                <div class="pt-2 flex items-center justify-between border-t border-white/20">
                                    <div>
                                        <span class="text-[11px] text-sky-200 block">Harga Mulai</span>
                                        <span class="text-lg sm:text-xl font-extrabold text-white">Rp
                                            1.850.000.000</span>
                                    </div>
                                    <a href="#rekomendasi"
                                        class="px-4 py-2 bg-white text-slate-900 hover:bg-sky-100 text-xs font-bold rounded-xl shadow transition-colors">
                                        Lihat Unit
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Badge 1: Review Klien -->
                        <div
                            class="absolute -top-4 -left-4 sm:-left-6 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl shadow-sky-100 border border-sky-100 flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 font-bold">
                                ★
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-800">4.9 / 5.0 Rating</div>
                                <div class="text-[11px] text-slate-500">Dari 1.200+ Pemilik Rumah</div>
                            </div>
                        </div>

                        <!-- Floating Badge 2: Pendampingan Notaris & KPR -->
                        <div
                            class="hidden sm:flex absolute -bottom-4 -right-4 sm:-right-6 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl shadow-sky-100 border border-sky-100 items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                ✓
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-800">Legalitas 100% Aman</div>
                                <div class="text-[11px] text-slate-500">Cek Notaris & Bank Rekanan</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- 3 Feature Highlight Pills (Persis seperti 3 kapsul di layout gambar) -->
            <div class="mt-14 grid grid-cols-1 md:grid-cols-3 gap-5">

                <!-- Pill 1: Kolam Renang Privat -->
                <div
                    class="bg-white/90 backdrop-blur-sm p-5 rounded-2xl border border-sky-100/90 shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-300 flex items-center gap-4 group">
                    <div
                        class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-base group-hover:text-sky-600 transition-colors">
                            Kolam
                            Renang Privat</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Privasi maksimal, kenyamanan relaksasi & gaya hidup
                            sehat keluarga.</p>
                    </div>
                </div>

                <!-- Pill 2: Taman Asri & Alami -->
                <div
                    class="bg-white/90 backdrop-blur-sm p-5 rounded-2xl border border-sky-100/90 shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-300 flex items-center gap-4 group">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-base group-hover:text-sky-600 transition-colors">
                            Taman
                            Asri & Hijau</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Ruang terbuka hijau alami, udara bersih, dan area
                            bermain anak yang aman.</p>
                    </div>
                </div>

                <!-- Pill 3: Balkon Panorama Luas -->
                <div
                    class="bg-white/90 backdrop-blur-sm p-5 rounded-2xl border border-sky-100/90 shadow-sm hover:shadow-md hover:border-sky-300 transition-all duration-300 flex items-center gap-4 group">
                    <div
                        class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-base group-hover:text-sky-600 transition-colors">
                            Balkon
                            Luas & Pemandangan</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Sirkulasi udara alami dan sudut pemandangan terbuka
                            untuk bersantai sore.</p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- 2. STATS SECTION (Layout Modern & Elegan)  -->
    <!-- ========================================== -->
    <section id="stats" class="py-16 sm:py-20 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-gradient-to-r from-sky-50 via-white to-sky-50 p-8 sm:p-10 rounded-3xl border border-sky-100 shadow-lg shadow-sky-100/60">
                <div
                    class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-sky-100">

                    <!-- Stat 1 -->
                    <div class="pt-4 md:pt-0">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-sky-600 tracking-tight">15.000+
                        </div>
                        <div class="text-sm font-bold text-slate-800 mt-2">Listing Rumah Siap Huni</div>
                        <p class="text-xs text-slate-500 mt-1 max-w-[200px] mx-auto">Telah melalui kurasi kelayakan
                            fisik & harga wajar</p>
                    </div>

                    <!-- Stat 2 -->
                    <div class="pt-4 md:pt-0 md:pl-6">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-sky-600 tracking-tight">98.5%</div>
                        <div class="text-sm font-bold text-slate-800 mt-2">Kepuasan Transaksi Klien</div>
                        <p class="text-xs text-slate-500 mt-1 max-w-[200px] mx-auto">Kepuasan layanan pendampingan &
                            proses KPR</p>
                    </div>

                    <!-- Stat 3 -->
                    <div class="pt-4 md:pt-0 md:pl-6">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-sky-600 tracking-tight">48+</div>
                        <div class="text-sm font-bold text-slate-800 mt-2">Kota Strategis di Indonesia</div>
                        <p class="text-xs text-slate-500 mt-1 max-w-[200px] mx-auto">Jangkauan agen luas di wilayah
                            perkotaan utama</p>
                    </div>

                    <!-- Stat 4 -->
                    <div class="pt-4 md:pt-0 md:pl-6">
                        <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-sky-600 tracking-tight">12+</div>
                        <div class="text-sm font-bold text-slate-800 mt-2">Mitra Bank KPR Resmi</div>
                        <p class="text-xs text-slate-500 mt-1 max-w-[200px] mx-auto">Bekerjasama dengan bank BUMN &
                            Swasta nasional</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 3. REKOMENDASI PROPERTI SECTION            -->
    <!-- ========================================== -->
    <section id="rekomendasi" class="py-16 sm:py-20 bg-gradient-to-b from-white via-sky-50/50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header & Filter Tabs (Sesuai Layout Gambar) -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <span
                        class="inline-block text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-100/70 px-3.5 py-1.5 rounded-full mb-3">
                        Pilihan Terbaik RumahKita
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Rekomendasi Properti Unggulan
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base mt-2 max-w-xl">
                        Koleksi hunian terbaik dengan lokasi strategis, fasilitas lengkap, dan jaminan legalitas resmi
                        untuk masa depan keluarga Anda.
                    </p>
                </div>

                <!-- Category Tabs (Filter interaktif pure vanilla JS) -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-none" id="category-tabs">
                    <button type="button" data-category="all"
                        class="cat-tab-btn active px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition-all bg-sky-600 text-white shadow-sm">
                        Semua
                    </button>
                    <button type="button" data-category="minimalis"
                        class="cat-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-white text-slate-600 hover:text-sky-600 hover:bg-sky-50 border border-sky-100">
                        Minimalis
                    </button>
                    <button type="button" data-category="villa"
                        class="cat-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-white text-slate-600 hover:text-sky-600 hover:bg-sky-50 border border-sky-100">
                        Villa Mewah
                    </button>
                    <button type="button" data-category="cluster"
                        class="cat-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-white text-slate-600 hover:text-sky-600 hover:bg-sky-50 border border-sky-100">
                        Cluster
                    </button>
                    <button type="button" data-category="apartemen"
                        class="cat-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-white text-slate-600 hover:text-sky-600 hover:bg-sky-50 border border-sky-100">
                        Apartemen
                    </button>
                </div>
            </div>

            <!-- Grid Kartu Properti (Dinamis dari properti_data.php) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="property-grid">

                <?php foreach ($semua_rekomendasi as $prop): ?>
                <div class="property-card bg-white rounded-3xl overflow-hidden border border-sky-100/90 shadow-md flex flex-col hover:shadow-xl transition-all duration-300"
                    data-category="<?= htmlspecialchars($prop['kategori']) ?>">
                    <div class="relative overflow-hidden aspect-[4/3] group">
                        <img src="<?= htmlspecialchars($prop['foto_utama']) ?>"
                            alt="<?= htmlspecialchars($prop['nama']) ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 left-4 flex flex-wrap gap-1.5">
                            <?php foreach (array_slice($prop['badges'] ?? [], 0, 2) as $badge): ?>
                            <span class="px-3 py-1 bg-sky-600/95 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow">
                                <?= htmlspecialchars($badge) ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                        <div class="absolute bottom-3 right-3 px-3 py-1 bg-slate-950/70 backdrop-blur-md rounded-lg text-white text-xs font-medium">
                            <?= htmlspecialchars($prop['lokasi_singkat']) ?>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="text-xs font-bold text-sky-600 uppercase tracking-wider mb-1">
                                <?= htmlspecialchars($prop['tipe_label'] ?? ucfirst($prop['kategori'])) ?>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 line-clamp-1 hover:text-sky-600 transition-colors">
                                <?= htmlspecialchars($prop['nama']) ?>
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                <?= htmlspecialchars($prop['deskripsi']) ?>
                            </p>

                            <!-- Spesifikasi Fasilitas -->
                            <div class="grid grid-cols-3 gap-2 my-4 py-3 border-y border-sky-50 text-center text-xs text-slate-600">
                                <div>
                                    <span class="font-bold text-slate-800 block text-sm"><?= (int)($prop['kt'] ?? 0) ?> KT</span>
                                    <span>Kamar Tidur</span>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-800 block text-sm"><?= (int)($prop['km'] ?? 0) ?> KM</span>
                                    <span>Kamar Mandi</span>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-800 block text-sm"><?= (int)($prop['luas_bangunan'] ?? 0) ?> m²</span>
                                    <span>Bangunan</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <div>
                                <span class="text-[11px] text-slate-400 block font-medium">Harga Penawaran</span>
                                <span class="text-lg font-black text-sky-700"><?= htmlspecialchars($prop['harga_format']) ?></span>
                            </div>
                            <a href="<?= BASE_URL ?>/src/properti/detail.php?id=<?= $prop['id'] ?>"
                                class="px-4 py-2.5 text-xs font-bold text-white bg-slate-900 hover:bg-sky-600 rounded-xl transition-all shadow-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>

            <!-- CTA Selengkapnya -->
            <div class="mt-12 text-center">
                <a href="<?= BASE_URL ?>/src/properti/index.php"
                    class="inline-flex items-center gap-2 px-8 py-3.5 bg-white hover:bg-sky-50 text-sky-700 border border-sky-200 font-bold text-sm rounded-2xl shadow-sm hover:shadow transition-all">
                    <span>Lihat Seluruh 1.500+ Listing Properti</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- ========================================== -->
    <!-- 4. PAKET SECTION (Paket Jasa Promosi Rumah)-->
    <!-- ========================================== -->
    <section id="paket" class="py-16 sm:py-20 bg-gradient-to-b from-sky-100/60 via-sky-50 to-sky-100/50 border-y border-sky-200/60 relative">
        <div id="service" class="absolute -top-24"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span
                    class="inline-block text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-100/70 px-3.5 py-1.5 rounded-full mb-3">
                    Jasa Promosi & Pemasaran Rumah
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Paket Promosi Penjualan Rumah
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3">
                    Pilih paket promosi yang tepat untuk menjangkau puluhan ribu calon pembeli potensial dan mempercepat
                    penjualan properti Anda dengan strategi pemasaran terpadu.
                </p>
            </div>

            <!-- Grid 3 Kartu Paket Promosi (01, 02, 03 dengan 03 Luxury di Pinggir Kanan) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">

                <!-- Paket 01: Starter Promosi (Kartu Terang Bersih) -->
                <div
                    class="service-card rounded-3xl p-8 sm:p-10 bg-white text-slate-800 shadow-lg shadow-sky-100/70 border border-sky-100 hover:border-sky-300 flex flex-col justify-between transition-all group">
                    <div>
                        <!-- Nomor & Ikon Paket -->
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <span class="text-5xl font-black text-sky-500 tracking-tighter">01</span>
                                <span
                                    class="block text-xs font-bold uppercase tracking-wider text-slate-400 mt-1">Pemilik
                                    Perorangan</span>
                            </div>
                            <div
                                class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                        </div>

                        <h3
                            class="text-2xl font-bold text-slate-900 mb-2 tracking-tight group-hover:text-sky-600 transition-colors">
                            Paket Starter
                        </h3>
                        <div class="mb-4">
                            <span class="text-3xl font-extrabold text-slate-900">Rp 299.000</span>
                            <span class="text-xs text-slate-400 font-medium">/ 30 hari</span>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Solusi praktis dan hemat untuk memasang iklan rumah Anda langsung ke marketplace RumahKita
                            dengan jangkauan pencarian lokal.
                        </p>
                    </div>

                    <div>
                        <ul class="space-y-3 text-xs text-slate-600 border-t border-sky-100 pt-6 mb-8">
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold text-sm shrink-0">✓</span>
                                <span>Masa tayang listing aktif 30 hari</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold text-sm shrink-0">✓</span>
                                <span>Upload hingga 8 foto resolusi tinggi</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold text-sm shrink-0">✓</span>
                                <span>Tampil di hasil pencarian & filter wilayah</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold text-sm shrink-0">✓</span>
                                <span>Direct chat calon pembeli ke WhatsApp Anda</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-emerald-500 font-bold text-sm shrink-0">✓</span>
                                <span>Laporan statistik tayangan mingguan</span>
                            </li>
                        </ul>

                        <a href="https://wa.me/6281234567890?text=Halo%20RumahKita,%20saya%20tertarik%20dengan%20Paket%20Starter%20Promosi%20Rumah"
                            target="_blank" rel="noopener noreferrer"
                            class="w-full inline-flex items-center justify-center gap-2 py-3 px-5 text-xs sm:text-sm font-bold text-sky-700 bg-sky-50 hover:bg-sky-600 hover:text-white border border-sky-200 rounded-xl transition-all duration-200 shadow-sm">
                            <span>Pilih Paket Starter</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Paket 02: Pro Prioritas (Kartu Paling Diminati) -->
                <div
                    class="service-card rounded-3xl p-8 sm:p-10 bg-white text-slate-800 shadow-xl shadow-sky-100/90 border-2 border-sky-400/80 flex flex-col justify-between transition-all group relative">

                    <!-- Badge Paling Diminati -->
                    <div
                        class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 bg-gradient-to-r from-sky-500 to-sky-600 text-white text-[11px] font-extrabold uppercase tracking-wider rounded-full shadow-md flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-white fill-current shrink-0" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span>Paling Diminati</span>
                    </div>

                    <div>
                        <!-- Nomor & Ikon Paket -->
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <span class="text-5xl font-black text-sky-600 tracking-tighter">02</span>
                                <span
                                    class="block text-xs font-bold uppercase tracking-wider text-sky-600 mt-1">Penjualan
                                    Cepat</span>
                            </div>
                            <div
                                class="w-12 h-12 rounded-2xl bg-sky-500 text-white shadow-md shadow-sky-500/25 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>

                        <h3
                            class="text-2xl font-bold text-slate-900 mb-2 tracking-tight group-hover:text-sky-600 transition-colors">
                            Paket Pro Prioritas
                        </h3>
                        <div class="mb-4">
                            <span class="text-3xl font-extrabold text-sky-600">Rp 699.000</span>
                            <span class="text-xs text-slate-400 font-medium">/ 90 hari</span>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Tingkatkan eksposur properti Anda hingga 5x lipat dengan kampanye iklan media sosial
                            tertarget dan prioritas tayang di katalog utama.
                        </p>
                    </div>

                    <div>
                        <ul class="space-y-3 text-xs text-slate-600 border-t border-sky-100 pt-6 mb-8">
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-600 font-bold text-sm shrink-0">✓</span>
                                <span>Seluruh keuntungan Paket Starter</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-600 font-bold text-sm shrink-0">✓</span>
                                <span>Masa tayang aktif <strong>90 hari (3 bulan)</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-600 font-bold text-sm shrink-0">✓</span>
                                <span>Badge khusus <strong>"Hot Deal / Prioritas"</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-600 font-bold text-sm shrink-0">✓</span>
                                <span>Iklan berbayar di Instagram & Facebook Ads</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-600 font-bold text-sm shrink-0">✓</span>
                                <span>Pembuatan video reels/TikTok promosi singkat</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-600 font-bold text-sm shrink-0">✓</span>
                                <span>Penyaringan awal calon pembeli serius oleh agen</span>
                            </li>
                        </ul>

                        <a href="https://wa.me/6281234567890?text=Halo%20RumahKita,%20saya%20tertarik%20dengan%20Paket%20Pro%20Prioritas%20Promosi%20Rumah"
                            target="_blank" rel="noopener noreferrer"
                            class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 rounded-xl transition-all duration-200 shadow-md shadow-sky-500/25 hover:shadow-lg hover:shadow-sky-500/35">
                            <span>Pilih Paket Pro Prioritas</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Paket 03: Luxury Sultan (Pinggir Kanan, Background Hitam Elegan Kontras) -->
                <div
                    class="service-card rounded-3xl p-8 sm:p-10 bg-gradient-to-br from-slate-900 via-sky-950 to-slate-900 text-white shadow-2xl shadow-sky-950/30 border border-sky-700/50 flex flex-col justify-between relative overflow-hidden group">

                    <!-- Decorative Luxury Glow -->
                    <div
                        class="absolute -right-10 -bottom-10 w-52 h-52 bg-sky-500/15 rounded-full blur-3xl pointer-events-none">
                    </div>
                    <div
                        class="absolute -left-10 -top-10 w-40 h-40 bg-sky-400/15 rounded-full blur-2xl pointer-events-none">
                    </div>

                    <div>
                        <!-- Nomor & Ikon Paket Luxury -->
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <span class="text-5xl font-black text-sky-400 tracking-tighter">03</span>
                                <span class="block text-xs font-bold uppercase tracking-wider text-sky-300 mt-1">✦
                                    Luxury Exclusive</span>
                            </div>
                            <div
                                class="w-12 h-12 rounded-2xl bg-sky-400/20 text-sky-300 border border-sky-400/30 flex items-center justify-center shadow-lg shadow-sky-400/10">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-2 tracking-tight">
                            Paket Luxury Sultan
                        </h3>
                        <div class="mb-4">
                            <span class="text-3xl font-extrabold text-sky-300">Rp 1.890.000</span>
                            <span class="text-xs text-sky-200 font-medium">/ hingga terjual</span>
                        </div>
                        <p class="text-sky-100/80 text-sm leading-relaxed mb-6">
                            Layanan promosi kasta tertinggi untuk villa dan hunian mewah dengan liputan sinematik drone
                            4K, Virtual Tour 360°, dan pendampingan agen VIP penuh.
                        </p>
                    </div>

                    <div>
                        <ul class="space-y-3 text-xs text-sky-100 border-t border-white/10 pt-6 mb-8">
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-400 font-bold text-sm shrink-0">✦</span>
                                <span>Seluruh keuntungan Paket Pro Prioritas</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-400 font-bold text-sm shrink-0">✦</span>
                                <span>Masa tayang aktif <strong>Hingga Unit Terjual</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-400 font-bold text-sm shrink-0">✦</span>
                                <span>Sesi foto profesional & video sinematik drone 4K</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-400 font-bold text-sm shrink-0">✦</span>
                                <span>Pembuatan <strong>Virtual Tour 360° Interaktif</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-400 font-bold text-sm shrink-0">✦</span>
                                <span>Penempatan di <strong>Banner Utama (Homepage Spotlight)</strong></span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-sky-400 font-bold text-sm shrink-0">✦</span>
                                <span>Dedicated VIP Agent untuk survei, negosiasi & notaris</span>
                            </li>
                        </ul>

                        <a href="https://wa.me/6281234567890?text=Halo%20RumahKita,%20saya%20tertarik%20dengan%20Paket%20Luxury%20Sultan%20Promosi%20Rumah"
                            target="_blank" rel="noopener noreferrer"
                            class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 text-xs sm:text-sm font-extrabold text-slate-900 bg-gradient-to-r from-sky-300 via-sky-400 to-sky-300 hover:brightness-105 rounded-xl transition-all duration-200 shadow-lg shadow-sky-400/25">
                            <span>Pilih Paket Luxury</span>
                            <svg class="w-4 h-4 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- 5. CARA BELI SECTION (Alur 4 Langkah Mudah) -->
    <!-- ========================================== -->
    <section id="cara-beli" class="py-16 sm:py-20 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span
                    class="inline-block text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-100/70 px-3.5 py-1.5 rounded-full mb-3">
                    Panduan Pembelian
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Cara Mudah Beli Rumah di RumahKita
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3">
                    Proses pembelian properti yang simpel, transparan, dan terarah dalam 4 tahapan praktis.
                </p>
            </div>

            <!-- Steps Process Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">

                <!-- Step 1 -->
                <div
                    class="relative bg-gradient-to-b from-sky-50/60 to-white p-7 rounded-3xl border border-sky-100 shadow-sm hover:shadow-md transition-all text-center group">
                    <div
                        class="w-14 h-14 mx-auto rounded-2xl bg-sky-600 text-white font-extrabold text-lg flex items-center justify-center shadow-lg shadow-sky-500/25 mb-6 group-hover:scale-110 transition-transform">
                        1
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pilih & Bandingkan</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Telusuri katalog properti sesuai lokasi, bujet, dan kebutuhan Anda. Bandingkan spesifikasi unit
                        dengan fitur komparasi kami.
                    </p>
                </div>

                <!-- Step 2 -->
                <div
                    class="relative bg-gradient-to-b from-sky-50/60 to-white p-7 rounded-3xl border border-sky-100 shadow-sm hover:shadow-md transition-all text-center group">
                    <div
                        class="w-14 h-14 mx-auto rounded-2xl bg-sky-500 text-white font-extrabold text-lg flex items-center justify-center shadow-lg shadow-sky-500/25 mb-6 group-hover:scale-110 transition-transform">
                        2
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Jadwalkan Survei</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Tentukan tanggal dan jam kunjungan. Agen representatif RumahKita akan mendampingi Anda di lokasi
                        secara gratis dan profesional.
                    </p>
                </div>

                <!-- Step 3 -->
                <div
                    class="relative bg-gradient-to-b from-sky-50/60 to-white p-7 rounded-3xl border border-sky-100 shadow-sm hover:shadow-md transition-all text-center group">
                    <div
                        class="w-14 h-14 mx-auto rounded-2xl bg-sky-400 text-white font-extrabold text-lg flex items-center justify-center shadow-lg shadow-sky-500/25 mb-6 group-hover:scale-110 transition-transform">
                        3
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Legalitas & KPR</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pemeriksaan keabsahan dokumen kepemilikan oleh notaris resmi dan fasilitasi pengajuan simulasi
                        KPR ke bank rekanan terbaik.
                    </p>
                </div>

                <!-- Step 4 -->
                <div
                    class="relative bg-gradient-to-b from-sky-50/60 to-white p-7 rounded-3xl border border-sky-100 shadow-sm hover:shadow-md transition-all text-center group">
                    <div
                        class="w-14 h-14 mx-auto rounded-2xl bg-slate-900 text-white font-extrabold text-lg flex items-center justify-center shadow-lg shadow-slate-900/25 mb-6 group-hover:scale-110 transition-transform">
                        4
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Akad & Terima Kunci</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Penandatanganan Akta Jual Beli (AJB) sah di hadapan notaris PPAT dan serah terima kunci rumah
                        baru Anda secara resmi.
                    </p>
                </div>

            </div>

            <!-- Callout Bantuan Konsultasi -->
            <div
                class="mt-14 bg-gradient-to-r from-sky-600 via-sky-500 to-blue-600 rounded-3xl p-6 sm:p-8 border border-sky-400/40 shadow-xl shadow-sky-500/20 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4 text-center sm:text-left">
                    <div
                        class="w-12 h-12 rounded-2xl bg-white/20 text-white flex items-center justify-center shrink-0 shadow-md backdrop-blur-sm border border-white/20">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-base">Butuh Bantuan Selama Proses Pembelian?</h4>
                        <p class="text-xs text-sky-100 mt-0.5">Konsultan spesialis kami siap menjawab pertanyaan dan
                            mendampingi Anda secara personal.</p>
                    </div>
                </div>
                <a href="https://wa.me/6281234567890?text=Halo%20RumahKita,%20saya%20butuh%20bantuan%20konsultasi%20seputar%20pembelian%20properti"
                    target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2.5 px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs sm:text-sm font-bold rounded-xl shadow-lg shadow-sky-950/20 hover:shadow-xl transition-all duration-200 hover:-translate-y-0.5 whitespace-nowrap">
                    <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24">
                        <path
                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                    </svg>
                    <span>Tanya Konsultan Kami via WhatsApp</span>
                </a>
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- 6. QNA / FAQ SECTION (Accordion Interaktif)-->
    <!-- ========================================== -->
    <section id="qna" class="py-16 sm:py-20 bg-white relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span
                    class="inline-block text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-100/70 px-3.5 py-1.5 rounded-full mb-3">
                    Pertanyaan Umum
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Tanya Jawab Seputar RumahKita
                </h2>
                <p class="text-slate-600 text-sm sm:text-base mt-3">
                    Temukan jawaban cepat seputar proses pencarian, survei, legalitas, dan simulasi KPR.
                </p>
            </div>

            <!-- Accordion List -->
            <div class="space-y-4" id="faq-accordion">

                <!-- FAQ Item 1 -->
                <div
                    class="bg-gradient-to-b from-sky-50/50 to-white rounded-2xl border border-sky-100 overflow-hidden shadow-sm">
                    <button type="button"
                        class="faq-btn w-full px-6 py-5 text-left flex items-center justify-between gap-4 font-bold text-slate-900 hover:text-sky-600 transition-colors">
                        <span class="text-base sm:text-lg">Apakah ada biaya perantara atau komisi bagi calon
                            pembeli?</span>
                        <div
                            class="faq-icon w-8 h-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 transition-transform duration-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content accordion-content">
                        <div class="px-6 pb-5 pt-3 text-sm text-slate-600 leading-relaxed border-t border-sky-100">
                            <p>
                                <strong>Sama sekali tidak ada.</strong> Seluruh layanan pencarian properti, konsultasi,
                                dan
                                pendampingan survei fisik ke lokasi unit di RumahKita adalah <strong>100%
                                    gratis</strong>
                                bagi calon pembeli. Anda hanya membayar harga kesepakatan rumah dan biaya resmi
                                kenotariatan/pajak yang berlaku sesuai hukum.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div
                    class="bg-gradient-to-b from-sky-50/50 to-white rounded-2xl border border-sky-100 overflow-hidden shadow-sm">
                    <button type="button"
                        class="faq-btn w-full px-6 py-5 text-left flex items-center justify-between gap-4 font-bold text-slate-900 hover:text-sky-600 transition-colors">
                        <span class="text-base sm:text-lg">Bagaimana cara RumahKita memverifikasi keabsahan legalitas
                            rumah?</span>
                        <div
                            class="faq-icon w-8 h-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 transition-transform duration-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content accordion-content">
                        <div class="px-6 pb-5 pt-3 text-sm text-slate-600 leading-relaxed border-t border-sky-100">
                            <p>
                                Sebelum sebuah unit ditayangkan di website kami, tim legal internal dan notaris PPAT
                                rekanan
                                melakukan verifikasi ganda meliputi: pengecekan sertifikat asli (SHM/HGB) ke kantor BPN,
                                verifikasi Izin Mendirikan Bangunan (IMB/PBG), riwayat pembayaran PBB, serta kepastian
                                bahwa
                                aset tidak dalam status sengketa atau jaminan lelang bermasalah.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div
                    class="bg-gradient-to-b from-sky-50/50 to-white rounded-2xl border border-sky-100 overflow-hidden shadow-sm">
                    <button type="button"
                        class="faq-btn w-full px-6 py-5 text-left flex items-center justify-between gap-4 font-bold text-slate-900 hover:text-sky-600 transition-colors">
                        <span class="text-base sm:text-lg">Apakah tim RumahKita membantu pengajuan KPR hingga
                            disetujui?</span>
                        <div
                            class="faq-icon w-8 h-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 transition-transform duration-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content accordion-content">
                        <div class="px-6 pb-5 pt-3 text-sm text-slate-600 leading-relaxed border-t border-sky-100">
                            <p>
                                Tentu saja! Kami memiliki divisi spesialis KPR yang bekerjasama dengan lebih dari 12
                                bank
                                terkemuka di Indonesia (seperti BCA, Mandiri, BRI, BNI, BTN, CIMB Niaga, OCBC). Kami
                                akan
                                membantu menganalisis profil finansial Anda, memilih program bunga paling murah,
                                menyusun
                                kelengkapan berkas, hingga mendampingi saat penandatanganan akad kredit.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div
                    class="bg-gradient-to-b from-sky-50/50 to-white rounded-2xl border border-sky-100 overflow-hidden shadow-sm">
                    <button type="button"
                        class="faq-btn w-full px-6 py-5 text-left flex items-center justify-between gap-4 font-bold text-slate-900 hover:text-sky-600 transition-colors">
                        <span class="text-base sm:text-lg">Bisakah saya menjadwalkan kunjungan survei pada hari libur
                            atau akhir pekan?</span>
                        <div
                            class="faq-icon w-8 h-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 transition-transform duration-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content accordion-content">
                        <div class="px-6 pb-5 pt-3 text-sm text-slate-600 leading-relaxed border-t border-sky-100">
                            <p>
                                Bisa sekali. Tim agen kami beroperasi setiap hari termasuk hari Sabtu, Minggu, dan hari
                                libur nasional. Anda cukup memilih tombol survei pada halaman properti atau menghubungi
                                layanan WhatsApp kami minimal 1 hari sebelumnya untuk memastikan ketersediaan akses unit
                                bersama pemilik rumah.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div
                    class="bg-gradient-to-b from-sky-50/50 to-white rounded-2xl border border-sky-100 overflow-hidden shadow-sm">
                    <button type="button"
                        class="faq-btn w-full px-6 py-5 text-left flex items-center justify-between gap-4 font-bold text-slate-900 hover:text-sky-600 transition-colors">
                        <span class="text-base sm:text-lg">Bagaimana cara pemilik rumah mendaftarkan propertinya untuk
                            dijual?</span>
                        <div
                            class="faq-icon w-8 h-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 transition-transform duration-300">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div class="faq-content accordion-content">
                        <div class="px-6 pb-5 pt-3 text-sm text-slate-600 leading-relaxed border-t border-sky-100">
                            <p>
                                Sangat mudah! Anda cukup menekan tombol 'Jual Rumah' di bagian navigasi atas, mengisi
                                formulir data properti, spesifikasi, dan foto awal. Tim verifikator RumahKita akan
                                menghubungi Anda dalam waktu 1x24 jam untuk melakukan validasi dokumen serta
                                menjadwalkan
                                sesi foto profesional bila diperlukan.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

</main>

<!-- Vanilla JS Scripts untuk Interaktivitas (Tabs Filter & Accordion) -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // 1. FILTER REKOMENDASI PROPERTI
    const tabButtons = document.querySelectorAll('.cat-tab-btn');
    const propertyCards = document.querySelectorAll('#property-grid .property-card');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.getAttribute('data-category');

            // Update styling active tab
            tabButtons.forEach(b => {
                b.classList.remove('active', 'bg-sky-600', 'text-white', 'shadow-sm');
                b.classList.add('bg-white', 'text-slate-600', 'border',
                    'border-sky-100');
            });
            this.classList.add('active', 'bg-sky-600', 'text-white', 'shadow-sm');
            this.classList.remove('bg-white', 'text-slate-600', 'border', 'border-sky-100');

            // Filter cards
            propertyCards.forEach(card => {
                const cardCat = card.getAttribute('data-category');
                if (category === 'all' || cardCat === category) {
                    card.style.display = 'flex';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.display = 'none';
                    card.style.opacity = '0';
                }
            });
        });
    });

    // 2. ACCORDION QNA (FAQ)
    const faqButtons = document.querySelectorAll('.faq-btn');

    faqButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('.faq-icon');
            const isOpen = content.classList.contains('open');

            // Tutup semua FAQ lainnya (opsional, accordion eksklusif)
            document.querySelectorAll('.faq-content').forEach(c => {
                c.classList.remove('open');
            });
            document.querySelectorAll('.faq-icon').forEach(i => {
                i.style.transform = 'rotate(0deg)';
            });

            // Toggle FAQ yang diklik
            if (!isOpen) {
                content.classList.add('open');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Buka FAQ pertama secara default agar user langsung melihat contoh konten
    if (faqButtons.length > 0) {
        faqButtons[0].click();
    }

});
</script>

<?php 
require_once __DIR__ . '/../layouts/footer.php'; 
?>