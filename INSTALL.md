# 📦 Panduan Instalasi Database NextStep

## 🚀 Cara Install Database

### Metode 1: Menggunakan Script Install Otomatis (RECOMMENDED)

1. **Pastikan XAMPP/MySQL sudah running**
   - Buka XAMPP Control Panel
   - Start Apache dan MySQL

2. **Jalankan Script Install**
   - Buka browser
   - **Cara 1 (RECOMMENDED):** Akses `http://localhost/PFB Lec/index.php` untuk melihat semua link
   - **Cara 2:** Coba salah satu URL berikut:
     - `http://localhost/PFB%20Lec/php/install.php` (dengan %20 untuk spasi)
     - `http://localhost/PFB Lec/php/install.php` (dengan spasi biasa)
     - `http://localhost/PFB-Lec/php/install.php` (jika folder sudah di-rename tanpa spasi)
   - Script akan membuat database dan semua tabel secara otomatis

3. **Verifikasi**
   - Jika berhasil, akan muncul pesan "✅ Instalasi Berhasil!"
   - Database `nextstep` sudah dibuat dengan semua tabel

4. **Hapus File Install (PENTING!)**
   - Setelah instalasi selesai, **HAPUS** file `php/install.php` untuk keamanan
   - File ini tidak boleh diakses oleh orang lain

### Metode 2: Import Manual melalui phpMyAdmin

1. **Buka phpMyAdmin**
   - Akses: `http://localhost/phpmyadmin`

2. **Import File SQL**
   - Klik "New" untuk membuat database baru
   - Buat database dengan nama: `nextstep`
   - Pilih database `nextstep`
   - Klik tab "Import"
   - Pilih file: `php/databes.db`
   - Klik "Go" untuk import

## ✅ Verifikasi Instalasi

Setelah instalasi, database `nextstep` harus memiliki tabel berikut:

- ✅ `users` - Data pengguna
- ✅ `courses` - Data kursus
- ✅ `modules` - Modul pembelajaran
- ✅ `enrollments` - Data pendaftaran kursus
- ✅ `assessments` - Data assessment/ujian
- ✅ `assessment_results` - Hasil assessment
- ✅ `certificates` - Data sertifikat
- ✅ `forums` - Forum diskusi
- ✅ `forum_posts` - Postingan forum
- ✅ `jobs` - Lowongan pekerjaan
- ✅ `job_applications` - Aplikasi pekerjaan
- ✅ `mentor_sessions` - Sesi mentoring

## 🔧 Konfigurasi Database

File konfigurasi ada di: `php/config.php`

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // Sesuaikan jika ada password
define('DB_NAME', 'nextstep');
```

Jika password MySQL Anda tidak kosong, edit file `php/config.php` dan ubah `DB_PASS`.

## 🎯 Langkah Selanjutnya

Setelah database berhasil diinstall:

1. ✅ Database sudah siap digunakan
2. ✅ Buka halaman login: `http://localhost/PFB%20Lec/Html/login.php`
3. ✅ Daftar user baru: `http://localhost/PFB%20Lec/Html/register.php`

## ⚠️ Troubleshooting

### Error: "Unknown database 'nextstep'"
- Pastikan script install.php sudah dijalankan
- Atau import manual melalui phpMyAdmin

### Error: "Access denied for user 'root'@'localhost'"
- Pastikan MySQL/XAMPP sudah running
- Cek password MySQL di `php/config.php`

### Error: "Connection refused"
- Pastikan MySQL service sudah start di XAMPP
- Cek port MySQL (default: 3306)

### Error: "Not Found" atau "404"
- Pastikan folder project ada di `C:\xampp\htdocs\`
- Coba akses `http://localhost/PFB Lec/index.php` untuk melihat path yang benar
- Jika folder memiliki spasi, gunakan `%20` di URL atau rename folder tanpa spasi
- Pastikan Apache sudah running di XAMPP

## 📞 Butuh Bantuan?

Jika masih ada masalah, pastikan:
1. XAMPP sudah terinstall dan running
2. Apache dan MySQL sudah start
3. File `php/install.php` sudah dijalankan
4. Database `nextstep` sudah ada di phpMyAdmin

