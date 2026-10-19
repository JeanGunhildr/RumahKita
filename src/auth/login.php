<?php
// src/auth/login.php - Halaman autentikasi masuk pengguna RumahKita

require_once __DIR__ . '/../../utils/koneksi.php';
require_once __DIR__ . '/../../utils/sesi.php';

// Jika pengguna sudah login, arahkan sesuai peran (admin ke dashboard, user ke beranda)
if (sudahLogin()) {
    if (apakahAdmin()) {
        header('Location: ' . BASE_URL . '/src/admin/index.php');
    } else {
        header('Location: ' . BASE_URL . '/index.php');
    }
    exit;
}

$galat = '';
$email_val = '';

// Ambil dan hapus pesan flash sukses jika ada (misal setelah registrasi akun baru)
$flash_sukses = $_SESSION['flash_sukses'] ?? null;
unset($_SESSION['flash_sukses']);

// Ambil dan hapus pesan flash info jika ada (misal akses detail properti tanpa login)
$flash_info = $_SESSION['flash_info'] ?? null;
unset($_SESSION['flash_info']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_val = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';

    if ($email_val === '' || $password === '') {
        $galat = 'Email dan kata sandi wajib diisi.';
    } else {
        // Ambil data akun berdasarkan email dengan prepared statement
        $sql = "SELECT id, name, email, password, phone, role FROM users WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('s', $email_val);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            // Sesuai spesifikasi: Gunakan pesan error SAMA untuk email tidak ditemukan maupun password salah (Mencegah user enumeration)
            if ($user === null || !password_verify($password, $user['password'])) {
                $galat = 'Email atau kata sandi yang Anda masukkan salah.';
            } else {
                // Login Berhasil: Regenerasi ID Sesi untuk mencegah Session Fixation Attack
                session_regenerate_id(true);

                // Simpan identitas akun ke Session
                $_SESSION['user_id']    = (int)$user['id'];
                $_SESSION['user_name']  = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role']  = $user['role'];
                $_SESSION['user_phone'] = $user['phone'] ?? '';

                // Admin HANYA bisa ke dashboard admin, user biasa ke beranda utama
                if ($user['role'] === 'admin') {
                    header('Location: ' . BASE_URL . '/src/admin/index.php');
                } else {
                    header('Location: ' . BASE_URL . '/index.php');
                }
                exit;
            }
        } else {
            error_log('Login Prepare Error: ' . $conn->error);
            $galat = 'Terjadi kesalahan sistem saat memproses login.';
        }
    }
}

// Sertakan layout header umum setelah seluruh logika redirect selesai
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="bg-[#f8fafc] text-slate-800 font-sans py-10 sm:py-14 flex justify-center px-4 sm:px-6 antialiased selection:bg-sky-100">

    <div class="w-full max-w-[420px]">

        <!-- Link Navigasi Kembali -->
        <div class="mb-3">
            <a href="<?= BASE_URL ?>/index.php"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-sky-600 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Card Form Minimalis Modern -->
        <div class="bg-white rounded-[28px] p-7 sm:p-9 border border-slate-100 shadow-[0_10px_35px_-8px_rgba(14,165,233,0.08),0_4px_16px_-4px_rgba(15,23,42,0.04)]">

            <!-- Judul Bersih -->
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk</h1>
                <p class="text-xs text-slate-400 mt-1">Masukkan email dan kata sandi Anda untuk melanjutkan.</p>
            </div>

            <!-- Pesan Flash Sukses (misal baru daftar) -->
            <?php if (!empty($flash_sukses)): ?>
            <div class="mb-4 p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span><?= e($flash_sukses) ?></span>
            </div>
            <?php endif; ?>

            <!-- Pesan Flash Info (misal diarahkan karena belum login) -->
            <?php if (!empty($flash_info)): ?>
            <div class="mb-4 p-3 rounded-2xl bg-sky-50 border border-sky-200 text-sky-800 text-xs font-medium flex items-center gap-2.5">
                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= e($flash_info) ?></span>
            </div>
            <?php endif; ?>

            <!-- Pesan Galat Login -->
            <?php if ($galat !== ''): ?>
            <div class="mb-4 p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium flex items-center gap-2.5">
                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= e($galat) ?></span>
            </div>
            <?php endif; ?>

            <!-- Formulir Login (Metode POST) -->
            <form action="<?= BASE_URL ?>/src/auth/login.php" method="POST" class="space-y-4" novalidate>

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                    <input type="email" id="email" name="email" value="<?= e($email_val) ?>" required placeholder="nama@email.com"
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
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                            title="Tampilkan / Sembunyikan Sandi">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Akses Cepat Akun Demo untuk Pengujian Dosen / Mahasiswa -->
                <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-medium">Isi cepat akun demo:</span>
                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="pilihDemo('user@gmail.com', 'user123')"
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition-colors">
                            User
                        </button>
                        <button type="button" onclick="pilihDemo('admin@gmail.com', 'admin123')"
                            class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-sky-50 text-sky-700 hover:bg-sky-100 border border-sky-200 transition-colors">
                            Admin
                        </button>
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit"
                        class="w-full py-3 px-5 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-sm shadow-md shadow-sky-500/20 hover:shadow-lg hover:shadow-sky-500/25 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                        Masuk
                    </button>
                </div>
            </form>

            <!-- Tautan ke Halaman Daftar -->
            <p class="text-center text-xs text-slate-400 mt-6">
                Belum punya akun? <a href="<?= BASE_URL ?>/src/auth/daftar.php"
                    class="font-bold text-sky-600 hover:text-sky-700 hover:underline">Daftar sekarang</a>
            </p>
        </div>

    </div>
</main>

<script>
function pilihDemo(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}

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