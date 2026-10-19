<?php 
require_once __DIR__ . '/../layouts/header.php'; 
require_once __DIR__ . '/../data/properti_data.php'; 

// Ambil parameter filter dari GET
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$tipe = isset($_GET['tipe']) ? trim($_GET['tipe']) : '';
$harga = isset($_GET['harga']) ? trim($_GET['harga']) : '';

$semua_properti = get_all_properti();
$properti_list = [];

foreach ($semua_properti as $item) {
    // Filter Kata Kunci
    if (!empty($q)) {
        $q_lower = strtolower($q);
        $match_nama = strpos(strtolower($item['nama']), $q_lower) !== false;
        $match_lokasi = strpos(strtolower($item['lokasi_singkat']), $q_lower) !== false;
        $match_alamat = strpos(strtolower($item['alamat_lengkap']), $q_lower) !== false;
        if (!$match_nama && !$match_lokasi && !$match_alamat) {
            continue;
        }
    }

    // Filter Tipe Properti
    if (!empty($tipe)) {
        if ($tipe === 'rumah' && $item['kategori'] !== 'minimalis') continue;
        if ($tipe !== 'rumah' && $item['kategori'] !== $tipe) continue;
    }

    // Filter Kisaran Harga
    if (!empty($harga)) {
        $nominal = $item['harga'];
        if ($harga === '1' && $nominal >= 500000000) continue;
        if ($harga === '2' && ($nominal < 500000000 || $nominal > 1000000000)) continue;
        if ($harga === '3' && ($nominal <= 1000000000 || $nominal > 2000000000)) continue;
        if ($harga === '4' && $nominal <= 2000000000) continue;
    }

    $properti_list[] = $item;
}
?>

<main class="relative min-h-screen py-10 bg-gradient-to-b from-sky-50/60 via-white to-sky-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Halaman Cari Rumah -->
        <div class="mb-10 text-center sm:text-left">
            <span class="inline-block text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-100/70 px-3.5 py-1.5 rounded-full mb-3">
                Katalog Properti Terverifikasi
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Cari & Temukan Rumah Impian Anda
            </h1>
            <p class="text-slate-600 text-sm sm:text-base mt-2 max-w-2xl">
                Jelajahi pilihan rumah, villa, dan apartemen siap huni dengan jaminan legalitas resmi di berbagai lokasi strategis.
            </p>
        </div>

        <!-- Filter Bar Pencarian Lengkap -->
        <div class="bg-white p-6 rounded-3xl border border-sky-100 shadow-lg shadow-sky-100/60 mb-12">
            <form action="" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kata Kunci / Lokasi</label>
                    <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cth: Jagakarsa, BSD, Dago..." 
                        class="w-full bg-sky-50/50 border border-sky-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Properti</label>
                    <select name="tipe" class="w-full bg-sky-50/50 border border-sky-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400 font-medium">
                        <option value="">Semua Tipe</option>
                        <option value="rumah" <?= $tipe === 'rumah' ? 'selected' : '' ?>>Rumah Minimalis</option>
                        <option value="villa" <?= $tipe === 'villa' ? 'selected' : '' ?>>Villa Mewah</option>
                        <option value="apartemen" <?= $tipe === 'apartemen' ? 'selected' : '' ?>>Apartemen</option>
                        <option value="cluster" <?= $tipe === 'cluster' ? 'selected' : '' ?>>Cluster Perumahan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kisaran Harga</label>
                    <select name="harga" class="w-full bg-sky-50/50 border border-sky-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-sky-400 font-medium">
                        <option value="">Semua Harga</option>
                        <option value="1" <?= $harga === '1' ? 'selected' : '' ?>>&lt; Rp 500 Juta</option>
                        <option value="2" <?= $harga === '2' ? 'selected' : '' ?>>Rp 500 Juta - 1 Miliar</option>
                        <option value="3" <?= $harga === '3' ? 'selected' : '' ?>>Rp 1 Miliar - 2 Miliar</option>
                        <option value="4" <?= $harga === '4' ? 'selected' : '' ?>>&gt; Rp 2 Miliar</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="w-full py-3 px-6 bg-slate-900 hover:bg-sky-600 text-white font-bold text-sm rounded-xl shadow-md transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Cari Properti</span>
                    </button>
                    <?php if (!empty($q) || !empty($tipe) || !empty($harga)): ?>
                        <a href="<?= BASE_URL ?>/src/properti/index.php" class="py-3 px-4 bg-sky-50 hover:bg-sky-100 text-sky-700 text-xs font-bold rounded-xl border border-sky-200 shrink-0 flex items-center justify-center" title="Reset Filter">
                            Reset
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Grid Katalog Properti -->
        <?php if (empty($properti_list)): ?>
            <div class="bg-white rounded-3xl p-12 text-center border border-sky-100 max-w-lg mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Properti Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 mb-6">Coba ubah kata kunci lokasi atau filter kriteria pencarian Anda.</p>
                <a href="<?= BASE_URL ?>/src/properti/index.php" class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow transition-all">
                    Tampilkan Semua Properti
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($properti_list as $unit): ?>
                    <div class="property-card bg-white rounded-3xl overflow-hidden border border-sky-100/90 shadow-md flex flex-col group">
                        <div class="relative overflow-hidden aspect-[4/3]">
                            <img src="<?= htmlspecialchars($unit['foto_utama']) ?>" alt="<?= htmlspecialchars($unit['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4 flex gap-2">
                                <span class="px-3 py-1 bg-sky-600 text-white text-xs font-bold rounded-full shadow">
                                    <?= htmlspecialchars($unit['tipe_label']) ?>
                                </span>
                                <?php if (!empty($unit['badges'][1])): ?>
                                    <span class="px-3 py-1 bg-white/90 text-slate-800 text-xs font-semibold rounded-full shadow">
                                        <?= htmlspecialchars($unit['badges'][1]) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="absolute bottom-3 right-3 px-3 py-1 bg-slate-950/70 backdrop-blur-md rounded-lg text-white text-xs font-medium">
                                <?= htmlspecialchars($unit['lokasi_singkat']) ?>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="text-xs font-bold text-sky-600 uppercase tracking-wider mb-1">ID: <?= htmlspecialchars($unit['kode']) ?></div>
                                <h3 class="text-xl font-bold text-slate-900 group-hover:text-sky-600 transition-colors line-clamp-1">
                                    <a href="<?= BASE_URL ?>/src/properti/detail.php?id=<?= $unit['id'] ?>">
                                        <?= htmlspecialchars($unit['nama']) ?>
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2"><?= htmlspecialchars($unit['deskripsi']) ?></p>
                                
                                <div class="grid grid-cols-3 gap-2 my-4 py-3 border-y border-sky-50 text-center text-xs text-slate-600">
                                    <div><span class="font-bold text-slate-800 block text-sm"><?= $unit['kt'] ?> KT</span><span>Kamar Tidur</span></div>
                                    <div><span class="font-bold text-slate-800 block text-sm"><?= $unit['km'] ?> KM</span><span>Kamar Mandi</span></div>
                                    <div><span class="font-bold text-slate-800 block text-sm"><?= $unit['luas_bangunan'] ?> m²</span><span>Luas Bangunan</span></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-2">
                                <div>
                                    <span class="text-[11px] text-slate-400 block font-medium">Harga Penawaran</span>
                                    <span class="text-lg font-black text-sky-700"><?= htmlspecialchars($unit['harga_format']) ?></span>
                                </div>
                                <a href="<?= BASE_URL ?>/src/properti/detail.php?id=<?= $unit['id'] ?>" class="px-4 py-2.5 text-xs font-bold text-white bg-slate-900 hover:bg-sky-600 rounded-xl transition-all shadow-sm">
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

<?php 
require_once __DIR__ . '/../layouts/footer.php'; 
?>
