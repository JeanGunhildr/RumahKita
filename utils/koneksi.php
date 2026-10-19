<?php

$host     = 'localhost';
$username = 'root';
$password = '';
$database = 'rumahkita';

// Atur laporan kesalahan mysqli agar melemparkan pengecualian (mysqli_sql_exception)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $username, $password, $database); // Koneksi ke MYSQL.
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $err) {
    error_log('Database Connection Error: ' . $err->getMessage());
    http_response_code(500);
    die('Mohon maaf, terjadi gangguan koneksi ke basis data. Silakan hubungi administrator sistem.');
}