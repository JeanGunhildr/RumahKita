<?php
// utils/sesi.php - Pengelolaan sesi pengguna, hak akses peran (RBAC), dan helper keamanan

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

if (!defined('BASE_URL')) {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    define('BASE_URL', stripos($scriptName, '/RumahKita') !== false ? '/RumahKita' : '');
}


//   Helper escaping keluaran HTML (Sanitasi XSS).
function e($teks): string
{
    return htmlspecialchars((string)($teks ?? ''), ENT_QUOTES, 'UTF-8');
}

//  Helper URL gambar properti (mendukung upload lokal maupun URL eksternal).

function urlGambar(?string $path): string
{
    if (empty($path)) {
        return 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=800&q=80';
    }
    if (stripos($path, 'http://') === 0 || stripos($path, 'https://') === 0) {
        return $path;
    }
    return BASE_URL . '/' . ltrim($path, '/');
}

//  Mengambil data pengguna yang sedang login saat ini dari sesi.
function penggunaAktif(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    return [
        'id'    => $_SESSION['user_id'],
        'name'  => $_SESSION['user_name'] ?? '',
        'email' => $_SESSION['user_email'] ?? '',
        'role'  => $_SESSION['user_role'] ?? 'user',
        'phone' => $_SESSION['user_phone'] ?? '',
    ];
}

//  Pengecekan apakah pengguna sudah login.
function sudahLogin(): bool
{
    return penggunaAktif() !== null;
}

//  Memeriksa apakah pengguna yang login memiliki role admin.
function apakahAdmin(): bool
{
    $user = penggunaAktif();
    return $user !== null && $user['role'] === 'admin';
}

//   Penjaga halaman (Guard) yang mewajibkan login.
//   Jika pengunjung belum login, arahkan ke halaman login.

function wajibLogin(): void
{
    if (!sudahLogin()) {
        header('Location: ' . BASE_URL . '/src/auth/login.php');
        exit;
    }
}

// Fungsi untuk mewajibkan peran tertentu.
function wajibPeran(string $peran): void
{
    wajibLogin();
    $user = penggunaAktif();
    if ($user === null || $user['role'] !== $peran) {
        http_response_code(403);
        // Tampilkan halaman 403
        ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>403 — Akses Ditolak | RumahKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen p-4 text-slate-800 font-sans">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-sm border border-slate-200 text-center">
        <div
            class="w-14 h-14 mx-auto mb-4 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center text-2xl font-bold">
            ✕
        </div>
        <h1 class="text-xl font-extrabold text-slate-900 mb-2">403 — Akses Ditolak</h1>
        <p class="text-sm text-slate-500 mb-6">
            Halaman ini dikhususkan untuk akun dengan peran <strong><?= e($peran) ?></strong>. Akun Anda tidak memiliki
            hak akses ke bagian ini.
        </p>
        <a href="<?= BASE_URL ?>/index.php"
            class="inline-block px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm rounded-xl transition">
            Kembali ke Beranda
        </a>
    </div>
</body>

</html>
<?php
        exit;
    }
}