<?php
// src/auth/daftar.php - Halaman pendaftaran akun pengguna baru RumahKita

require_once __DIR__ . '/../../utils/koneksi.php';
require_once __DIR__ . '/../../utils/sesi.php';
require_once __DIR__ . '/../../utils/validasi.php';

// Jika pengguna sudah login, arahkan sesuai peran (admin ke dashboard, user ke beranda)
if (sudahLogin()) {
    if (apakahAdmin()) {
        header('Location: ' . BASE_URL . '/src/admin/index.php');
    } else {
        header('Location: ' . BASE_URL . '/index.php');
    }
    exit;
}

$errors = [];
$nama_val = '';
$email_val = '';
$telepon_val = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil dan bersihkan data input dari formulir
    $nama_val    = trim($_POST['nama'] ?? '');
    $email_val   = trim($_POST['email'] ?? '');
    $password    = $_POST['password'] ?? '';
    $telepon_val = trim($_POST['phone'] ?? '');

    // 1. Validasi Nama Lengkap (3 - 100 karakter sesuai kolom database `name`)
    $errNama = validasiTeks($nama_val, 'Nama Lengkap', 3, 100);
    if ($errNama) {
        $errors['nama'] = $errNama;
    }

    // 2. Validasi Format Email
    $errEmail = validasiEmail($email_val);
    if ($errEmail) {
        $errors['email'] = $errEmail;
    }

    // 3. Validasi Kata Sandi (Minimal 6 karakter)
    if (empty($password)) {
        $errors['password'] = 'Kata sandi wajib diisi.';
    } elseif (mb_strlen($password, 'UTF-8') < 6) {
        $errors['password'] = 'Kata sandi minimal terdiri dari 6 karakter.';
    }

    // 4. Validasi Nomor Telepon jika diisi (maksimal 25 karakter sesuai kolom `phone`)
    if ($telepon_val !== '' && mb_strlen($telepon_val, 'UTF-8') > 25) {
        $errors['phone'] = 'Nomor telepon tidak boleh lebih dari 25 karakter.';
    }

    // Jika tidak ada kesalahan validasi formulir, simpan ke database
    if (empty($errors)) {
        // Enkripsi kata sandi menggunakan fungsi hashing satu arah yang aman
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        // Tetapkan role secara kaku di backend ke 'user' (tidak menerima input peran dari form)
        $roleDefault = 'user';

        // Siapkan prepared statement untuk INSERT ke tabel `users`
        $sql = "INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('sssss', $nama_val, $email_val, $hashPassword, $telepon_val, $roleDefault);

            try {
                $stmt->execute();
                $stmt->close();

                // Simpan flash message berhasil registrasi ke session
                $_SESSION['flash_sukses'] = 'Pendaftaran akun berhasil! Silakan masuk dengan email dan kata sandi Anda.';

                // Terapkan pola Post/Redirect/Get (PRG)
                header('Location: ' . BASE_URL . '/src/auth/login.php');
                exit;
            } catch (mysqli_sql_exception $e) {
                // Tangani pelanggaran UNIQUE constraint pada email (MySQL error code: 1062)
                if ($conn->errno === 1062 || strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $errors['email'] = 'Alamat email ini sudah terdaftar. Silakan gunakan email lain atau langsung masuk.';
                } else {
                    error_log('Register DB Error: ' . $e->getMessage());
                    $errors['umum'] = 'Terjadi kesalahan sistem saat mendaftarkan akun. Silakan coba kembali nanti.';
                }
            }
        } else {
            error_log('Prepare Error: ' . $conn->error);
            $errors['umum'] = 'Gagal memproses data registrasi.';
        }
    }
}

// Sertakan layout header umum
require_once __DIR__ . '/../layouts/header.php';
?>

<main
    class="bg-[#f8fafc] text-slate-800 font-sans py-10 sm:py-14 flex justify-center px-4 sm:px-6 antialiased selection:bg-sky-100">

    <div class="w-full max-w-[440px]">

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

        <!-- Card Register Minimalis Modern -->
        <div
            class="bg-white rounded-[28px] p-7 sm:p-9 border border-slate-100 shadow-[0_10px_35px_-8px_rgba(14,165,233,0.08),0_4px_16px_-4px_rgba(15,23,42,0.04)]">

            <!-- Judul Bersih -->
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Akun</h1>
                <p class="text-xs text-slate-400 mt-1">Lengkapi data berikut untuk membuat akun pengguna RumahKita.</p>
            </div>

            <!-- Pesan Kesalahan Umum jika ada -->
            <?php if (!empty($errors['umum'])): ?>
            <div
                class="mb-4 p-3 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium flex items-center gap-2.5">
                <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= e($errors['umum']) ?></span>
            </div>
            <?php endif; ?>

            <!-- Formulir Registrasi (Metode POST) -->
            <form action="<?= BASE_URL ?>/src/auth/daftar.php" method="POST" class="space-y-4" novalidate>

                <!-- Input Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="<?= e($nama_val) ?>" required
                        placeholder="Contoh: Budi Santoso"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-50/60 border <?= isset($errors['nama']) ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200/80' ?> text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 focus:bg-white transition-all">
                    <?php if (isset($errors['nama'])): ?>
                    <p class="text-xs text-rose-600 mt-1 font-medium"><?= e($errors['nama']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Input Alamat Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="<?= e($email_val) ?>" required
                        placeholder="nama@email.com"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-50/60 border <?= isset($errors['email']) ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200/80' ?> text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 focus:bg-white transition-all">
                    <?php if (isset($errors['email'])): ?>
                    <p class="text-xs text-rose-600 mt-1 font-medium"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Input Kata Sandi -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter"
                            class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-slate-50/60 border <?= isset($errors['password']) ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200/80' ?> text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 focus:bg-white transition-all">
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
                    <?php if (isset($errors['password'])): ?>
                    <p class="text-xs text-rose-600 mt-1 font-medium"><?= e($errors['password']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Input Nomor Telepon (Opsional / Database Phone) -->
                <div>
                    <label for="phone" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nomor Telepon <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <input type="number" id="phone" name="phone" value="<?= e($telepon_val) ?>"
                        placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-2.5 rounded-xl bg-slate-50/60 border <?= isset($errors['phone']) ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200/80' ?> text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 focus:bg-white transition-all">
                    <?php if (isset($errors['phone'])): ?>
                    <p class="text-xs text-rose-600 mt-1 font-medium"><?= e($errors['phone']) ?></p>
                    <?php endif; ?>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-3 px-5 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-sm shadow-md shadow-sky-500/20 hover:shadow-lg hover:shadow-sky-500/25 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                        Daftar Akun
                    </button>
                </div>
            </form>

            <!-- Tautan ke Halaman Masuk -->
            <p class="text-center text-xs text-slate-400 mt-6">
                Sudah punya akun? <a href="<?= BASE_URL ?>/src/auth/login.php"
                    class="font-bold text-sky-600 hover:text-sky-700 hover:underline">Masuk di sini</a>
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