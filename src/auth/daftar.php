<?php 
require_once __DIR__ . '/../layouts/header.php'; 
?>

<main
    class="bg-[#f8fafc] text-slate-800 font-sans min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased selection:bg-sky-100">

    <div class="w-full max-w-[420px]">

        <!-- Link Kembali -->
        <div class="mb-2">
            <a href="<?= BASE_URL ?>/index.php"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-sky-600 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Card Register Minimalis Modern -->
        <div
            class="bg-white rounded-[28px] p-7 sm:p-9 border border-slate-100 shadow-[0_10px_35px_-8px_rgba(14,165,233,0.08),0_4px_16px_-4px_rgba(15,23,42,0.04)]">

            <!-- Judul Bersih -->
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Akun</h1>
                <p class="text-xs text-slate-400 mt-1">Lengkapi data berikut untuk membuat akun baru.</p>
            </div>

            <!-- Form (Murni Frontend) -->
            <form action="<?= BASE_URL ?>/src/auth/login.php" method="GET" class="space-y-4">

                <div>
                    <label for="nama" class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan Nama Lengkap"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-50/60 border border-slate-200/80 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 focus:bg-white transition-all">
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <input type="email" id="email" name="email" required placeholder="nama@email.com"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-50/60 border border-slate-200/80 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 focus:bg-white transition-all">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-700">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="Masukkan Kata Sandi"
                            class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-slate-50/60 border border-slate-200/80 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 focus:bg-white transition-all">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label for="telepon" class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Telepon</label>
                    <input type="tel" id="telepon" name="telepon" required placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-50/60 border border-slate-200/80 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 focus:bg-white transition-all">
                </div>
                <div class="pt-1">
                    <button type="submit"
                        class="w-full py-3 px-5 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-sm shadow-md shadow-sky-500/20 hover:shadow-lg hover:shadow-sky-500/25 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                        Daftar
                    </button>
                </div>
            </form>
            <!-- Tautan Masuk -->
            <p class="text-center text-xs text-slate-400 mt-6">
                Sudah punya akun? <a href="<?= BASE_URL ?>/src/auth/login.php"
                    class="font-bold text-sky-600 hover:text-sky-700 hover:underline">Masuk di
                    sini</a>
            </p>
        </div>

    </div>

</main>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>