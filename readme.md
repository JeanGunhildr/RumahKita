# 🏡 RumahKita — Platform Katalog Properti

Proyek Website Katalog Properti berbasis **PHP Native** dan **MySQL** (MySQLi) dengan autentikasi peran (Admin & User), validasi ketat di sisi server, pencegahan XSS, dan operasi basis data aman menggunakan **Prepared Statements**.

Proyek ini disusun untuk memenuhi spesifikasi **Mini Project Mata Kuliah Pemrograman Web I (IF21305)** - Sub-CPMK-01, Sub-CPMK-02, dan Sub-CPMK-03.

---

## 🚀 Panduan Menjalankan Aplikasi di XAMPP

### 1. Prasyarat Sistem
- **XAMPP** dengan PHP 8.1+ dan MySQL / MariaDB berjalan aktif.
- Web Browser modern (Google Chrome, Mozilla Firefox, Microsoft Edge).

### 2. Penempatan Folder Proyek
Pastikan folder proyek berada pada direktori:
```
C:\xampp\htdocs\RumahKita
```

### 3. Impor Basis Data (Database)
1. Buka browser dan akses **phpMyAdmin**: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Buat database baru bernama: `rumahkita` (collation: `utf8mb4_general_ci`).
3. Pilih database `rumahkita`, klik tab **Import**.
4. Pilih file database yang disediakan:
   - `c:\xampp\htdocs\RumahKita\database\app.sql` (atau file `rumahkita.sql`)
5. Klik **Import / Kirim** hingga muncul pesan berhasil.

### 4. Menjalankan Aplikasi
Buka web browser dan akses URL:
```
http://localhost/RumahKita/
```
(Aplikasi otomatis mengarahkan ke halaman Beranda `src/home/index.php`).

---

## 👥 Akun Uji Coba (Credentials)

Sesuai spesifikasi tugas, sistem menyediakan dua jenis peran akun yang siap digunakan:

| No | Peran (Role) | Email Login | Kata Sandi | Hak Akses |
|---|---|---|---|---|
| 1 | **Admin** | `admin@gmail.com` | `admin123` | Melihat katalog, melihat detail properti, mengakses Panel Admin, dan menambah properti baru. |
| 2 | **User / Anggota** | `user@gmail.com` | `user123` | Melihat katalog beranda dan melihat detail properti (Ditolak dengan HTTP 403 jika membuka form tambah properti). |

> **Catatan Registrasi Akun Baru:**  
> Pengunjung juga dapat mendaftar akun baru langsung melalui menu **Daftar** (`src/auth/daftar.php`). Semua akun yang mendaftar baru secara otomatis ditetapkan dengan peran **`user`** oleh sistem (keamanan sisi server).

---

## 🛠️ Ringkasan Fitur & Spesifikasi Teknis

### 1. Autentikasi & Otorisasi
- **Registrasi Akun Baru**:
- **Login & Logout**:
- **Role-Based Access Control (RBAC)**:

### 2. Fitur Tambah Properti (Khusus Admin)

### 3. Beranda & Tampilan Katalog Properti

### 4. Halaman Detail Properti


## 📁 Struktur Berkas Proyek

```
RumahKita/
├── database/
│   └── app.sql                 <- Skema database dan akun uji coba
├── public/
│   └── css/
│       └── global.css          <- Custom CSS pelengkap Tailwind
├── src/
│   ├── admin/
│   │   ├── index.php           <- Panel Dashboard kelola properti (JOIN users)
│   │   └── tambah.php          <- Form Tambah Properti khusus Admin (PRG & Validasi)
│   ├── auth/
│   │   ├── daftar.php          <- Form Registrasi Akun Pengguna Baru
│   │   ├── login.php           <- Form Masuk Pengguna (password_verify)
│   │   └── logout.php          <- Pemroses Logout (Penghancur Sesi)
│   ├── home/
│   │   └── index.php           <- Halaman Beranda (Katalog Dinamis MySQL)
│   ├── layouts/
│   │   ├── header.php          <- Template Untuk Header 
│   │   └── footer.php          <- Template Untuk Footer
│   └── properti/
│       ├── detail.php          <- Detail Properti 
│       └── index.php           <- Menampilkan Daftar Semua Properti
├── utils/
│   ├── koneksi.php             <- Koneksi MySQLi 
│   ├── sesi.php                <- Helper sesi, RBAC, dan fungsi e()
│   └── validasi.php            <- Helper validasi server (teks, angka, whitelist, email)
├── index.php                   <- Entry point root (redirect ke src/home/index.php)
├── pengujian.docs              <- Laporan & Skenario Pengujian Sistem
└── readme.md                   <- Dokumentasi petunjuk penggunaan
```