<?php
// src/auth/logout.php - Skrip pemrosesan logout akun pengguna RumahKita

require_once __DIR__ . '/../../utils/sesi.php';

// Kosongkan seluruh array sesi
$_SESSION = [];

// Jika sesi menggunakan cookie, hapus cookie sesi dari browser klien
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Hancurkan data sesi di server
session_destroy();

// Redirect ke halaman login
header('Location: ' . BASE_URL . '/src/auth/login.php');
exit;