<?php
require_once __DIR__ . '/utils/sesi.php';

// Jika admin mengakses root, arahkan langsung ke dashboard admin
if (apakahAdmin()) {
    header('Location: ' . BASE_URL . '/src/admin/index.php');
    exit;
}

// Pengunjung umum dan pengguna diarahkan ke beranda utama
header('Location: ' . BASE_URL . '/src/home/index.php');
exit;