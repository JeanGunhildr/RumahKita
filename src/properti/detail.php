<?php 
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../data/properti_data.php'; 

// Ambil ID Properti dari URL, default ke 1 jika tidak ada / tidak valid
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$properti = get_properti_by_id($id);

if (!$properti) {
    $properti = get_properti_by_id(1); // fallback aman
}

// Ambil properti terkait (selain unit ini)
$semua_properti = get_all_properti();
$properti_terkait = [];
foreach ($semua_properti as $item) {
    if ($item['id'] !== $properti['id']) {
        $properti_terkait[] = $item;
    }
    if (count($properti_terkait) >= 3) break;
}

// Format URL WhatsApp untuk pertanyaan spesifik unit ini
$wa_text = urlencode("Halo RumahKita, saya tertarik dan ingin konsultasi lebih lanjut mengenai properti: " . $properti['nama'] . " (Kode: " . $properti['kode'] . ") seharga " . $properti['harga_format'] . " di " . $properti['lokasi_singkat'] . ".");
$wa_link = "https://wa.me/" . $properti['agen']['telepon'] . "?text=" . $wa_text;
?>

<main class="min-h-screen bg-slate-50/70 pb-20 pt-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- ========================================== -->
        <!-- 1. BREADCRUMB & HEADER ATAS                -->
        <!-- ========================================== -->
        <nav
            class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 mb-6 overflow-x-auto whitespace-nowrap pb-1">
            <a href="<?= BASE_URL ?>/src/home/index.php"
                class="hover:text-sky-600 transition-colors font-medium">Beranda</a>
            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="<?= BASE_URL ?>/src/properti/index.php"
                class="hover:text-sky-600 transition-colors font-medium">Cari Rumah</a>
            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-sky-600 font-bold truncate"><?= htmlspecialchars($properti['nama']) ?></span>
        </nav>

        <!-- Judul & Aksi Atas -->
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6 mb-8">
            <div>
                <!-- Badges Status -->
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-sky-600 text-white text-xs font-bold rounded-lg shadow-sm">
                        <?= htmlspecialchars($properti['tipe_label']) ?>
                    </span>
                    <?php foreach ($properti['badges'] as $badge): ?>
                    <span class="px-3 py-1 bg-sky-100 text-sky-800 text-xs font-bold rounded-lg border border-sky-200">
                        <?= htmlspecialchars($badge) ?>
                    </span>
                    <?php endforeach; ?>
                    <span
                        class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Unit Tersedia
                    </span>
                    <span class="text-xs text-slate-600 font-medium ml-1">
                        ID: <?= htmlspecialchars($properti['kode']) ?>
                    </span>
                </div>

                <!-- Nama Properti -->
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    <?= htmlspecialchars($properti['nama']) ?>
                </h1>

                <!-- Alamat Lengkap -->
                <p class="flex items-center gap-2 text-slate-600 text-sm mt-2">
                    <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span><?= htmlspecialchars($properti['alamat_lengkap']) ?></span>
                </p>
            </div>

            <!-- Tombol Berbagi & Wishlist -->
            <div class="flex items-center gap-3 shrink-0">
                <button type="button" onclick="salinTautan()" id="btn-salin"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-sky-50 text-slate-700 text-xs sm:text-sm font-semibold rounded-xl border border-sky-100 shadow-sm transition-all">
                    <svg class="w-4 h-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    <span id="text-salin">Bagikan</span>
                </button>
                <button type="button" onclick="toggleSimpan(this)"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-rose-50 text-slate-700 hover:text-rose-600 text-xs sm:text-sm font-semibold rounded-xl border border-sky-100 shadow-sm transition-all">
                    <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 2. GALERI FOTO INTERAKTIF                  -->
        <!-- ========================================== -->
        <div class="mb-10">
            <!-- Foto Utama Besar -->
            <div
                class="relative w-full aspect-[16/9] sm:aspect-[21/9] rounded-3xl overflow-hidden border border-sky-100 shadow-lg group">
                <img id="main-gallery-img" src="<?= htmlspecialchars($properti['foto_utama']) ?>"
                    alt="<?= htmlspecialchars($properti['nama']) ?>"
                    class="w-full h-full object-cover transition-all duration-500">

                <div
                    class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent pointer-events-none">
                </div>

                <!-- Badge Watermark Keaslian -->
                <div
                    class="absolute bottom-4 left-4 sm:bottom-6 sm:left-6 flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-900/80 backdrop-blur-md text-white text-xs font-semibold border border-white/10">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>Foto Asli Terverifikasi Tim RumahKita</span>
                </div>

                <!-- Tombol Fullscreen -->
                <button type="button" onclick="bukaModalFoto()"
                    class="absolute bottom-4 right-4 sm:bottom-6 sm:right-6 px-4 py-2 rounded-xl bg-white/90 hover:bg-white text-slate-800 text-xs font-bold shadow-md transition-all flex items-center gap-2 backdrop-blur-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <span>Lihat Fullscreen</span>
                </button>
            </div>

            <!-- Thumbnail Carousel / Grid Foto -->
            <div class="flex items-center gap-3 mt-4 overflow-x-auto pb-2 scrollbar-none" id="thumbnail-container">
                <?php foreach ($properti['galeri'] as $index => $foto): ?>
                <button type="button" onclick="gantiFotoUtama('<?= htmlspecialchars($foto) ?>', this)"
                    class="thumbnail-btn relative shrink-0 w-24 sm:w-32 aspect-[4/3] rounded-2xl overflow-hidden border-2 <?= $index === 0 ? 'border-sky-600 ring-2 ring-sky-300' : 'border-transparent opacity-75 hover:opacity-100' ?> transition-all">
                    <img src="<?= htmlspecialchars($foto) ?>" alt="Foto Thumbnail <?= $index + 1 ?>"
                        class="w-full h-full object-cover">
                </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 3. KONTEN DETAIL UTAMA & SIDEBAR           -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- KOLOM KIRI (KONTEN LENGKAP) -->
            <div class="lg:col-span-8 space-y-10">

                <!-- Kapsul Spesifikasi Cepat (Highlight Box) -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sky-100 shadow-md">
                    <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Ringkasan Spesifikasi Utama</span>
                    </h2>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                        <!-- KT -->
                        <div class="p-4 rounded-2xl bg-sky-50/60 border border-sky-100/80 text-center">
                            <span class="block text-2xl font-black text-sky-700"><?= $properti['kt'] ?></span>
                            <span class="text-xs font-bold text-slate-700 mt-1 block">Kamar Tidur</span>
                            <span class="text-[11px] text-slate-500">Kamar luas & terang</span>
                        </div>
                        <!-- KM -->
                        <div class="p-4 rounded-2xl bg-sky-50/60 border border-sky-100/80 text-center">
                            <span class="block text-2xl font-black text-sky-700"><?= $properti['km'] ?></span>
                            <span class="text-xs font-bold text-slate-700 mt-1 block">Kamar Mandi</span>
                            <span class="text-[11px] text-slate-500">Sanitasi premium</span>
                        </div>
                        <!-- Luas Bangunan -->
                        <div class="p-4 rounded-2xl bg-sky-50/60 border border-sky-100/80 text-center">
                            <span class="block text-2xl font-black text-sky-700"><?= $properti['luas_bangunan'] ?>
                                m²</span>
                            <span class="text-xs font-bold text-slate-700 mt-1 block">Luas Bangunan</span>
                            <span class="text-[11px] text-slate-500">Efisiensi optimal</span>
                        </div>
                        <!-- Luas Tanah -->
                        <div class="p-4 rounded-2xl bg-sky-50/60 border border-sky-100/80 text-center">
                            <span class="block text-2xl font-black text-sky-700"><?= $properti['luas_tanah'] ?>
                                m²</span>
                            <span class="text-xs font-bold text-slate-700 mt-1 block">Luas Tanah</span>
                            <span class="text-[11px] text-slate-500">Sertifikat terdaftar</span>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Lengkap -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sky-100 shadow-md">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        <span>Deskripsi Properti</span>
                    </h2>
                    <div class="text-slate-600 leading-relaxed text-sm sm:text-base space-y-4">
                        <p><?= nl2br(htmlspecialchars($properti['deskripsi'])) ?></p>
                        <p>Unit ini telah melalui pemeriksaan menyeluruh (*due diligence*) oleh tim legal dan teknis
                            RumahKita, mencakup validitas dokumen pertanahan (BPN), kelayakan struktur fisik, dan bebas
                            sengketa. Pembelian dapat dilakukan secara tunai keras, tunai bertahap, maupun fasilitas KPR
                            dari seluruh mitra perbankan RumahKita.</p>
                    </div>
                </div>

                <!-- Fasilitas Unggulan -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sky-100 shadow-md">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <span>Fasilitas & Keunggulan Hunian</span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <?php foreach ($properti['fasilitas'] as $fasilitas): ?>
                        <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-sky-50/50 border border-sky-100/70">
                            <div
                                class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span
                                class="text-xs sm:text-sm font-semibold text-slate-800"><?= htmlspecialchars($fasilitas) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Spesifikasi Teknis / Legalitas -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sky-100 shadow-md">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Rincian Spesifikasi & Legalitas Dokumen</span>
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                        <div class="flex justify-between py-2.5 border-b border-sky-50">
                            <span class="text-slate-500 font-medium">Sertifikat Legalitas</span>
                            <span
                                class="font-bold text-slate-900"><?= htmlspecialchars($properti['sertifikat']) ?></span>
                        </div>
                        <div class="flex justify-between py-2.5 border-b border-sky-50">
                            <span class="text-slate-500 font-medium">Kondisi Perabot</span>
                            <span class="font-bold text-slate-900"><?= htmlspecialchars($properti['kondisi']) ?></span>
                        </div>
                        <div class="flex justify-between py-2.5 border-b border-sky-50">
                            <span class="text-slate-500 font-medium">Kapasitas Listrik</span>
                            <span class="font-bold text-slate-900"><?= htmlspecialchars($properti['listrik']) ?></span>
                        </div>
                        <div class="flex justify-between py-2.5 border-b border-sky-50">
                            <span class="text-slate-500 font-medium">Sumber Pasokan Air</span>
                            <span class="font-bold text-slate-900"><?= htmlspecialchars($properti['air']) ?></span>
                        </div>
                        <div class="flex justify-between py-2.5 border-b border-sky-50">
                            <span class="text-slate-500 font-medium">Jumlah Lantai</span>
                            <span class="font-bold text-slate-900"><?= $properti['lantai'] ?> Lantai</span>
                        </div>
                        <div class="flex justify-between py-2.5 border-b border-sky-50">
                            <span class="text-slate-500 font-medium">Kapasitas Garasi / Carport</span>
                            <span class="font-bold text-slate-900"><?= $properti['carport'] ?> Kendaraan</span>
                        </div>
                        <div class="flex justify-between py-2.5 border-b border-sky-50">
                            <span class="text-slate-500 font-medium">Arah Hadap Bangunan</span>
                            <span
                                class="font-bold text-slate-900"><?= htmlspecialchars($properti['arah_hadap']) ?></span>
                        </div>
                        <div class="flex justify-between py-2.5 border-b border-sky-50">
                            <span class="text-slate-500 font-medium">Tahun Bangun / Renovasi</span>
                            <span class="font-bold text-slate-900"><?= $properti['tahun_dibangun'] ?></span>
                        </div>
                    </div>
                </div>

                <!-- Aksesibilitas & Lokasi Sekitar -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-sky-100 shadow-md">
                    <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Aksesibilitas & Waktu Tempuh</span>
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach ($properti['akses'] as $akses): ?>
                        <div class="flex items-start gap-3.5 p-4 rounded-2xl bg-sky-50/40 border border-sky-100/70">
                            <div
                                class="px-2.5 py-1.5 rounded-xl bg-sky-600 text-white font-extrabold text-xs shrink-0 shadow-sm">
                                <?= htmlspecialchars($akses['waktu']) ?>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-xs sm:text-sm">
                                    <?= htmlspecialchars($akses['tujuan']) ?></h4>
                                <span class="text-[11px] text-slate-500">Kondisi lalu lintas lancar</span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Peta Lokasi Mockup Interaktif -->
                    <div
                        class="mt-8 rounded-2xl overflow-hidden border border-sky-100 bg-slate-100 relative p-6 text-center">
                        <div class="max-w-md mx-auto space-y-3">
                            <div
                                class="w-12 h-12 rounded-2xl bg-sky-600 text-white flex items-center justify-center mx-auto shadow-md">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-900 text-base">Lokasi Terverifikasi</h4>
                            <p class="text-xs text-slate-500"><?= htmlspecialchars($properti['alamat_lengkap']) ?></p>
                            <a href="https://maps.google.com/?q=<?= urlencode($properti['alamat_lengkap']) ?>"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-sky-600 text-white text-xs font-bold rounded-xl shadow transition-all">
                                <span>Buka di Google Maps</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- KOLOM KANAN (STICKY SIDEBAR HARGA, KONSULTAN, & SIMULASI KPR) -->
            <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">

                <!-- Card Harga & CTA Utama -->
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-sky-100 shadow-xl shadow-sky-100/70">
                    <div class="mb-4">
                        <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Harga
                            Penawaran</span>
                        <div class="text-3xl font-black text-sky-700 tracking-tight mt-1">
                            <?= htmlspecialchars($properti['harga_format']) ?>
                        </div>
                        <span class="text-xs text-emerald-600 font-semibold block mt-1">✓ Termasuk PPN & Biaya Notaris
                            PPAT</span>
                    </div>

                    <!-- Tombol Aksi Kontak -->
                    <div class="space-y-3 pt-4 border-t border-sky-100">
                        <a href="<?= $wa_link ?>" target="_blank" rel="noopener noreferrer"
                            class="w-full py-3.5 px-5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm rounded-2xl shadow-lg shadow-emerald-500/20 hover:shadow-xl transition-all flex items-center justify-center gap-2.5">
                            <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                            <span>Tanya via WhatsApp</span>
                        </a>

                        <button type="button" onclick="bukaModalSurvei()"
                            class="w-full py-3.5 px-5 bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm rounded-2xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Jadwalkan Survei Lokasi</span>
                        </button>
                    </div>

                    <div
                        class="mt-4 pt-4 border-t border-sky-50 flex items-center justify-center gap-4 text-xs text-slate-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Tanpa Biaya Agen
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-sky-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Pendampingan KPR
                        </span>
                    </div>
                </div>

                <!-- Profil Konsultan Spesialis -->
                <div class="bg-white rounded-3xl p-6 border border-sky-100 shadow-md">
                    <span class="text-xs font-bold uppercase tracking-wider text-sky-600 block mb-3">Konsultan Resmi
                        Properti</span>

                    <div class="flex items-center gap-4 mb-4">
                        <img src="<?= htmlspecialchars($properti['agen']['foto']) ?>"
                            alt="<?= htmlspecialchars($properti['agen']['nama']) ?>"
                            class="w-14 h-14 rounded-2xl object-cover border border-sky-200 shadow-sm shrink-0">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">
                                <?= htmlspecialchars($properti['agen']['nama']) ?></h4>
                            <p class="text-xs text-slate-500"><?= htmlspecialchars($properti['agen']['peran']) ?></p>
                            <div class="flex items-center gap-1 mt-1 text-xs text-amber-500 font-semibold">
                                <span>★</span>
                                <span class="text-slate-700"><?= htmlspecialchars($properti['agen']['rating']) ?></span>
                            </div>
                        </div>
                    </div>

                    <a href="<?= $wa_link ?>" target="_blank" rel="noopener noreferrer"
                        class="w-full py-2.5 px-4 bg-sky-50 hover:bg-sky-100/80 text-sky-700 font-bold text-xs rounded-xl border border-sky-200/80 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>Chat Konsultan Ini</span>
                    </a>
                </div>

                <!-- Kalkulator KPR Interaktif Real-Time -->
                <div
                    class="bg-gradient-to-br from-sky-50 via-white to-sky-50 rounded-3xl p-6 sm:p-7 border border-sky-200 shadow-md">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-sky-600 text-white flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Simulasi Angsuran KPR</h3>
                            <p class="text-[11px] text-slate-500">Hitung estimasi cicilan bulanan Anda</p>
                        </div>
                    </div>

                    <!-- Input Nilai Properti (Readonly) -->
                    <div class="space-y-3.5 text-xs">
                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Harga Rumah</label>
                            <input type="text" id="kpr-harga" readonly
                                value="<?= number_format($properti['harga'], 0, ',', '.') ?>"
                                class="w-full bg-white border border-sky-100 rounded-xl px-3.5 py-2 font-bold text-slate-800">
                        </div>

                        <!-- Pilihan Uang Muka DP -->
                        <div>
                            <div class="flex justify-between font-semibold text-slate-600 mb-1">
                                <span>Uang Muka (DP)</span>
                                <span id="kpr-dp-persen" class="text-sky-600 font-bold">15%</span>
                            </div>
                            <input type="range" id="kpr-dp-slider" min="10" max="50" step="5" value="15"
                                class="w-full accent-sky-600 cursor-pointer">
                            <div class="flex justify-between text-[11px] text-slate-500 mt-1">
                                <span>10%</span>
                                <span id="kpr-dp-nominal" class="font-semibold text-slate-700">Rp 0</span>
                                <span>50%</span>
                            </div>
                        </div>

                        <!-- Jangka Waktu Tenor -->
                        <div>
                            <label class="block font-semibold text-slate-600 mb-1">Jangka Waktu (Tenor)</label>
                            <select id="kpr-tenor"
                                class="w-full bg-white border border-sky-100 rounded-xl px-3.5 py-2 font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-sky-400">
                                <option value="10">10 Tahun (120 Bulan)</option>
                                <option value="15">15 Tahun (180 Bulan)</option>
                                <option value="20" selected>20 Tahun (240 Bulan)</option>
                                <option value="25">25 Tahun (300 Bulan)</option>
                            </select>
                        </div>

                        <!-- Suku Bunga Promo -->
                        <div>
                            <div class="flex justify-between font-semibold text-slate-600 mb-1">
                                <span>Suku Bunga KPR Promo</span>
                                <span class="text-emerald-600 font-bold">4.5% p.a. Fixed</span>
                            </div>
                        </div>

                        <!-- Kotak Hasil Estimasi -->
                        <div class="p-4 rounded-2xl bg-white border border-sky-200/90 text-center shadow-sm">
                            <span class="text-[11px] text-slate-400 block font-medium">Estimasi Cicilan per Bulan</span>
                            <div id="kpr-cicilan" class="text-2xl font-black text-sky-700 my-1">
                                Rp 0
                            </div>
                            <span class="text-[10px] text-slate-500 block">*Perhitungan estimasi suku bunga fix
                                awal</span>
                        </div>

                        <a href="https://wa.me/<?= $properti['agen']['telepon'] ?>?text=<?= urlencode("Halo RumahKita, saya ingin konsultasi dan dibantu pengajuan KPR untuk unit: " . $properti['nama']) ?>"
                            target="_blank"
                            class="w-full py-2.5 px-4 bg-slate-900 hover:bg-sky-600 text-white font-bold text-xs rounded-xl shadow transition-all flex items-center justify-center gap-2">
                            <span>Ajukan KPR Dibantu RumahKita</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <!-- ========================================== -->
        <!-- 4. REKOMENDASI PROPERTI TERKAIT            -->
        <!-- ========================================== -->
        <div class="mt-20 pt-12 border-t border-sky-100">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <span
                        class="text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-100/70 px-3 py-1 rounded-full">
                        Alternatif Pilihan
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-2">
                        Properti Menarik Lainnya
                    </h2>
                </div>
                <a href="<?= BASE_URL ?>/src/properti/index.php"
                    class="text-sm font-bold text-sky-600 hover:text-sky-700 flex items-center gap-1.5">
                    <span>Lihat Semua Katalog</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Grid 3 Properti Terkait -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($properti_terkait as $item): ?>
                <div
                    class="property-card bg-white rounded-3xl overflow-hidden border border-sky-100/90 shadow-md flex flex-col group">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="<?= htmlspecialchars($item['foto_utama']) ?>"
                            alt="<?= htmlspecialchars($item['nama']) ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="px-3 py-1 bg-sky-600 text-white text-xs font-bold rounded-full shadow">
                                <?= htmlspecialchars($item['tipe_label']) ?>
                            </span>
                        </div>
                        <div
                            class="absolute bottom-3 right-3 px-3 py-1 bg-slate-950/70 backdrop-blur-md rounded-lg text-white text-xs font-medium">
                            <?= htmlspecialchars($item['lokasi_singkat']) ?>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3
                                class="text-lg font-bold text-slate-900 group-hover:text-sky-600 transition-colors line-clamp-1">
                                <?= htmlspecialchars($item['nama']) ?>
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                                <?= htmlspecialchars($item['deskripsi']) ?>
                            </p>
                            <div
                                class="grid grid-cols-3 gap-2 my-4 py-3 border-y border-sky-50 text-center text-xs text-slate-600">
                                <div><span class="font-bold text-slate-800 block text-sm"><?= $item['kt'] ?>
                                        KT</span><span>Kamar Tidur</span></div>
                                <div><span class="font-bold text-slate-800 block text-sm"><?= $item['km'] ?>
                                        KM</span><span>Kamar Mandi</span></div>
                                <div><span class="font-bold text-slate-800 block text-sm"><?= $item['luas_bangunan'] ?>
                                        m²</span><span>Luas</span></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2">
                            <div>
                                <span class="text-[11px] text-slate-400 block font-medium">Harga</span>
                                <span
                                    class="text-base font-black text-sky-700"><?= htmlspecialchars($item['harga_format']) ?></span>
                            </div>
                            <a href="<?= BASE_URL ?>/src/properti/detail.php?id=<?= $item['id'] ?>"
                                class="px-4 py-2 text-xs font-bold text-white bg-slate-900 hover:bg-sky-600 rounded-xl transition-all shadow-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</main>

<!-- ========================================== -->
<!-- 5. MODAL JADWALKAN SURVEI LOKASI           -->
<!-- ========================================== -->
<div id="modal-survei"
    class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div
        class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 border border-sky-100 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <button type="button" onclick="tutupModalSurvei()"
            class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 p-2 rounded-xl hover:bg-sky-50 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900">Jadwalkan Survei Rumah</h3>
                <p class="text-xs text-slate-500">Gratis pendampingan langsung oleh konsultan</p>
            </div>
        </div>

        <form id="form-survei" onsubmit="kirimSurveiWhatsApp(event)" class="space-y-4 text-xs sm:text-sm">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" id="survei-nama" required placeholder="Cth: Muhammad Rifqi"
                    class="w-full bg-sky-50/50 border border-sky-100 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-400">
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Nomor WhatsApp</label>
                <input type="tel" id="survei-wa" required placeholder="Cth: 081234567890"
                    class="w-full bg-sky-50/50 border border-sky-100 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-400">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Rencana Tanggal</label>
                    <input type="date" id="survei-tgl" required
                        class="w-full bg-sky-50/50 border border-sky-100 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-400">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Pilihan Waktu</label>
                    <select id="survei-jam"
                        class="w-full bg-sky-50/50 border border-sky-100 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-400">
                        <option value="Pagi (09:00 - 11:30)">Pagi (09:00 - 11:30)</option>
                        <option value="Siang (13:00 - 15:00)">Siang (13:00 - 15:00)</option>
                        <option value="Sore (15:30 - 17:30)">Sore (15:30 - 17:30)</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                <textarea id="survei-catatan" rows="2" placeholder="Cth: Ingin cek akses mobil dan fasilitas sekitar"
                    class="w-full bg-sky-50/50 border border-sky-100 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-sky-400"></textarea>
            </div>

            <button type="submit"
                class="w-full py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2">
                <span>Konfirmasi Jadwal via WhatsApp</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- ========================================== -->
<!-- 6. MODAL FOTO FULLSCREEN                   -->
<!-- ========================================== -->
<div id="modal-foto"
    class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-md flex items-center justify-center p-4">
    <button type="button" onclick="tutupModalFoto()"
        class="absolute top-5 right-5 text-white/80 hover:text-white p-2 rounded-xl bg-white/10 hover:bg-white/20 transition-all">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="max-w-5xl max-h-[85vh] w-full flex items-center justify-center">
        <img id="modal-img-display" src="<?= htmlspecialchars($properti['foto_utama']) ?>" alt="Foto Fullscreen"
            class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl">
    </div>
</div>

<!-- ========================================== -->
<!-- 7. SCRIPT LOGIC JAVASCRIPT                 -->
<!-- ========================================== -->
<script>
// Data properti untuk Javascript
const HARGA_PROPERTI = <?= (float)$properti['harga'] ?>;
const NAMA_PROPERTI = <?= json_encode($properti['nama']) ?>;
const KODE_PROPERTI = <?= json_encode($properti['kode']) ?>;
const TELEPON_AGEN = <?= json_encode($properti['agen']['telepon']) ?>;

// 1. Ganti Foto Galeri Utama
function gantiFotoUtama(src, btn) {
    const mainImg = document.getElementById('main-gallery-img');
    const modalImg = document.getElementById('modal-img-display');
    if (mainImg) {
        mainImg.style.opacity = '0.3';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.opacity = '1';
        }, 150);
    }
    if (modalImg) {
        modalImg.src = src;
    }
    // Update border thumbnail aktif
    document.querySelectorAll('#thumbnail-container .thumbnail-btn').forEach(b => {
        b.classList.remove('border-sky-600', 'ring-2', 'ring-sky-300', 'opacity-100');
        b.classList.add('border-transparent', 'opacity-75');
    });
    btn.classList.add('border-sky-600', 'ring-2', 'ring-sky-300', 'opacity-100');
    btn.classList.remove('border-transparent', 'opacity-75');
}

// 2. Fullscreen Modal Foto
function bukaModalFoto() {
    const modal = document.getElementById('modal-foto');
    if (modal) modal.classList.remove('hidden');
}

function tutupModalFoto() {
    const modal = document.getElementById('modal-foto');
    if (modal) modal.classList.add('hidden');
}

// 3. Modal Jadwalkan Survei
function bukaModalSurvei() {
    const modal = document.getElementById('modal-survei');
    if (modal) modal.classList.remove('hidden');
}

function tutupModalSurvei() {
    const modal = document.getElementById('modal-survei');
    if (modal) modal.classList.add('hidden');
}

function kirimSurveiWhatsApp(e) {
    e.preventDefault();
    const nama = document.getElementById('survei-nama').value;
    const wa = document.getElementById('survei-wa').value;
    const tgl = document.getElementById('survei-tgl').value;
    const jam = document.getElementById('survei-jam').value;
    const catatan = document.getElementById('survei-catatan').value;

    const pesan = `Halo RumahKita, saya ingin menjadwalkan survei lokasi:\n\n` +
        `• Properti: ${NAMA_PROPERTI} (${KODE_PROPERTI})\n` +
        `• Nama Pemohon: ${nama}\n` +
        `• Kontak WA: ${wa}\n` +
        `• Rencana Tanggal: ${tgl}\n` +
        `• Pilihan Waktu: ${jam}\n` +
        (catatan ? `• Catatan: ${catatan}\n` : '') +
        `\nMohon konfirmasi kesiapan konsultan pendamping. Terima kasih!`;

    const url = `https://wa.me/${TELEPON_AGEN}?text=${encodeURIComponent(pesan)}`;
    window.open(url, '_blank');
    tutupModalSurvei();
}

// 4. Kalkulator Simulasi KPR
function formatRupiah(num) {
    return 'Rp ' + Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function hitungKPR() {
    const sliderDP = document.getElementById('kpr-dp-slider');
    const persenDP = sliderDP ? parseInt(sliderDP.value) : 15;
    const tenorTahun = parseInt(document.getElementById('kpr-tenor').value);
    const sukuBungaTahunan = 0.045; // 4.5% promo

    const nominalDP = (HARGA_PROPERTI * persenDP) / 100;
    const pokokPinjaman = HARGA_PROPERTI - nominalDP;
    const totalBulan = tenorTahun * 12;
    const bungaPerBulan = sukuBungaTahunan / 12;

    // Rumus Anuitas KPR: P * (r * (1 + r)^n) / ((1 + r)^n - 1)
    const cicilanPerBulan = (pokokPinjaman * (bungaPerBulan * Math.pow(1 + bungaPerBulan, totalBulan))) / (Math.pow(1 +
        bungaPerBulan, totalBulan) - 1);

    document.getElementById('kpr-dp-persen').innerText = persenDP + '%';
    document.getElementById('kpr-dp-nominal').innerText = formatRupiah(nominalDP);
    document.getElementById('kpr-cicilan').innerText = formatRupiah(cicilanPerBulan);
}

document.addEventListener('DOMContentLoaded', () => {
    const sliderDP = document.getElementById('kpr-dp-slider');
    const selectTenor = document.getElementById('kpr-tenor');

    if (sliderDP && selectTenor) {
        sliderDP.addEventListener('input', hitungKPR);
        selectTenor.addEventListener('change', hitungKPR);
        hitungKPR();
    }
});

// 5. Salin Tautan Halaman
function salinTautan() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const textSalin = document.getElementById('text-salin');
        if (textSalin) {
            textSalin.innerText = 'Tersalin!';
            setTimeout(() => {
                textSalin.innerText = 'Bagikan';
            }, 2500);
        }
    }).catch(() => {
        alert('Tautan properti berhasil disalin: ' + window.location.href);
    });
}

// 6. Toggle Simpan / Wishlist
function toggleSimpan(btn) {
    const svg = btn.querySelector('svg');
    const span = btn.querySelector('span');
    if (span.innerText === 'Simpan') {
        span.innerText = 'Disimpan';
        svg.setAttribute('fill', 'currentColor');
        btn.classList.add('bg-rose-50', 'text-rose-600', 'border-rose-200');
    } else {
        span.innerText = 'Simpan';
        svg.setAttribute('fill', 'none');
        btn.classList.remove('bg-rose-50', 'text-rose-600', 'border-rose-200');
    }
}
</script>

<?php 
require_once __DIR__ . '/../layouts/footer.php'; 
?>