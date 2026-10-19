<?php

// Kumpulan fungsi helper validasi input formulir di sisi server.
function validasiTeks(string $nilai, string $namaField, int $min = 3, int $max = 150): ?string
{
    $panjang = mb_strlen(trim($nilai), 'UTF-8');
    if ($panjang === 0) {
        return "{$namaField} wajib diisi dan tidak boleh kosong.";
    }
    if ($panjang < $min || $panjang > $max) {
        return "{$namaField} harus memiliki panjang antara {$min} sampai {$max} karakter.";
    }
    return null;
}

//   Validasi kolom deskripsi properti.

function validasiDeskripsi(string $nilai, string $namaField, int $max = 2000): ?string
{
    $panjang = mb_strlen(trim($nilai), 'UTF-8');
    if ($panjang > $max) {
        return "{$namaField} tidak boleh melebihi {$max} karakter (saat ini {$panjang} karakter).";
    }
    return null;
}

//   Validasi kolom bertipe angka / numerik dengan rentang batas nilai.

function validasiAngka($nilai, string $namaField, float $min = 0, float $max = 999999999999): ?string
{
    $nilaiStr = trim((string)$nilai);
    if ($nilaiStr === '') {
        return "{$namaField} wajib diisi.";
    }
    if (!is_numeric($nilaiStr)) {
        return "{$namaField} harus berupa bilangan angka yang valid.";
    }
    $angka = (float)$nilaiStr;
    if ($angka < $min || $angka > $max) {
        $minFmt = number_format($min, 0, ',', '.');
        $maxFmt = number_format($max, 0, ',', '.');
        return "{$namaField} harus berada dalam rentang {$minFmt} sampai {$maxFmt}.";
    }
    return null;
}


//   Validasi pilihan (ENUM)

function validasiPilihan(string $nilai, array $daftarPilihan, string $namaField): ?string
{
    if (!in_array($nilai, $daftarPilihan, true)) {
        return "Pilihan {$namaField} tidak valid atau tidak tersedia dalam daftar.";
    }
    return null;
}


//  Validasi format email.

function validasiEmail(string $email): ?string
{
    $email = trim($email);
    if ($email === '') {
        return 'Alamat email wajib diisi.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Format alamat email tidak valid (contoh: nama@domain.com).';
    }
    if (mb_strlen($email, 'UTF-8') > 150) {
        return 'Alamat email terlalu panjang (maksimal 150 karakter).';
    }
    return null;
}