# 🚀 NextStep Platform

NextStep adalah sebuah platform pembelajaran dan karier yang dirancang khusus untuk membantu mahasiswa membangun skill profesional, mendapatkan sertifikasi digital, dan menemukan peluang karier yang lebih baik.

## 📋 Deskripsi Project

Platform ini hadir sebagai jawaban dari kebutuhan nyata mahasiswa zaman sekarang—yang bukan cuma butuh teori dari kampus, tapi juga skill praktis yang beneran dipakai di dunia kerja. NextStep bertindak sebagai "jembatan" yang menghubungkan mahasiswa dari tahap belum punya skill ke tahap siap kerja melalui assessment, project kecil, komunitas, mentoring, dan akses lowongan kerja dalam satu ekosistem.

## ✨ Fitur Utama

### 1. **Learning Management System**
- Kursus interaktif dengan modul pembelajaran terstruktur
- Tracking progress belajar per course
- Dashboard pribadi untuk monitoring perkembangan skill
- Rekomendasi skill berikutnya berdasarkan progress

### 2. **Assessment & Sertifikasi**
- Quiz interaktif untuk validasi pemahaman
- Mini project dan studi kasus
- Sertifikat digital resmi setelah menyelesaikan pelatihan
- Download sertifikat dalam format PDF

### 3. **Community Forum**
- Forum diskusi untuk tanya jawab
- Sharing pengalaman belajar
- Minta feedback desain atau project
- Kolaborasi project dengan partner belajar

### 4. **Job Board**
- Lowongan kerja dan magang dari berbagai perusahaan
- Filter berdasarkan skill yang dipelajari
- Apply langsung melalui platform
- Recruiter bisa melihat sertifikat dan progress belajar

### 5. **Mentorship**
- Booking sesi dengan mentor profesional
- Konsultasi karier dan direction
- Review portofolio
- Tips interview dan persiapan kerja

### 6. **User Management**
- Sistem login dan register
- Role-based access (Student, Mentor, Admin)
- Profile management dengan LinkedIn integration

## 🛠️ Teknologi yang Digunakan

- **Frontend:**
  - HTML5
  - CSS3 (Custom CSS)
  - JavaScript (Vanilla JS)
  - Bootstrap 5.0.2

- **Backend:**
  - PHP 7.4+
  - MySQL Database

- **Server:**
  - XAMPP (Apache + MySQL + PHP)

## 📁 Struktur Folder

```
PFB Lec/
├── Asset/                  # File assets (logo, images, icons)
├── bootstrap-5.0.2-dist/   # Bootstrap CSS & JS files
├── Foto Job/               # Job-related images
├── Html/                   # Public pages (Home, About, Login, Register)
│   ├── home.php
│   ├── about.php
│   ├── login.php
│   └── register.php
├── Html User/              # User dashboard pages (Protected)
│   ├── dashborad_mahasigma.php
│   ├── mycourse.php
│   ├── assestment.php
│   ├── certi.php
│   ├── mentor.php
│   ├── getAJOBBB.php
│   └── komuniti.php
├── Js/                     # JavaScript files
│   └── Sekerip.js
├── php/                    # PHP backend files
│   ├── config.php          # Database configuration
│   ├── login_process.php
│   ├── register_process.php
│   ├── logout.php
│   ├── forum_create.php
│   └── databes.db          # SQL schema file
├── Style/                  # CSS stylesheets
│   ├── main.css
│   ├── header.css
│   ├── footer.css
│   ├── home.css
│   ├── about.css
│   ├── login.css
│   ├── register.css
│   └── [other CSS files]
├── index.php               # Root redirect to home
└── README.md               # Documentation

```

## 🚀 Cara Instalasi

### Persyaratan Sistem

- XAMPP (PHP 7.4+ dan MySQL 5.7+)
- Web browser modern (Chrome, Firefox, Edge)
- Text editor (VS Code, PhpStorm, dll)

### Langkah Instalasi

1. **Clone atau Download Project**
   ```bash
   # Letakkan folder project di htdocs XAMPP
   C:\xampp\htdocs\PFB Lec\
   ```

2. **Start XAMPP Services**
   - Buka XAMPP Control Panel
   - Start Apache
   - Start MySQL

3. **Setup Database**

   **Opsi 1: Manual (phpMyAdmin)**
   - Buka `http://localhost/phpmyadmin`
   - Buat database baru dengan nama: `nextstep`
   - Import file SQL dari `php/databes.db`
   - Atau copy-paste isi file `php/databes.db` ke SQL tab

   **Opsi 2: Via SQL Command**
   ```sql
   CREATE DATABASE nextstep CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   USE nextstep;
   -- Copy paste isi dari php/databes.db
   ```

4. **Konfigurasi Database**
   
   Edit file `php/config.php` jika diperlukan:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'nextstep');
   ```

5. **Akses Website**
   ```
   http://localhost/PFB Lec/
   ```
   Atau dengan encoding URL:
   ```
   http://localhost/PFB%20Lec/
   ```

## 👤 Default Accounts

Setelah database setup, Anda perlu membuat akun melalui halaman register:
- **Register:** `http://localhost/PFB Lec/Html/register.php`
- **Login:** `http://localhost/PFB Lec/Html/login.php`

## 📖 Cara Penggunaan

### Untuk Student (Mahasiswa)

1. **Register & Login**
   - Daftar akun baru di halaman Register
   - Login dengan email dan password

2. **Dashboard**
   - Lihat progress belajar
   - Akses course yang sedang berjalan
   - Lihat rekomendasi skill

3. **My Courses**
   - Pilih course yang ingin dipelajari
   - Ikuti modul pembelajaran
   - Track progress per course

4. **Assessments**
   - Ikuti quiz dan assessment
   - Submit mini project
   - Dapatkan score dan feedback

5. **Certificates**
   - Lihat sertifikat yang sudah didapat
   - Download sertifikat dalam format PDF

6. **Community**
   - Buat posting di forum
   - Berdiskusi dengan sesama mahasiswa
   - Minta feedback project

7. **Job Board**
   - Browse lowongan kerja
   - Filter berdasarkan skill
   - Apply langsung ke perusahaan

8. **Mentorship**
   - Booking sesi dengan mentor
   - Konsultasi karier
   - Review portofolio

### Untuk Mentor

1. Login dengan akun mentor
2. Kelola session mentoring
3. Berikan feedback kepada student
4. Manage profile mentor

### Untuk Admin

1. Login dengan akun admin
2. Kelola user, course, dan content
3. Manage job postings
4. Monitor platform activity

## 🔧 Konfigurasi

### Database Configuration

File konfigurasi database ada di `php/config.php`:

```php
define('DB_HOST', 'localhost');  // Database host
define('DB_USER', 'root');       // Database username
define('DB_PASS', '');           // Database password
define('DB_NAME', 'nextstep');   // Database name
```

### Session Configuration

Session dikelola secara otomatis melalui helper functions di `php/config.php`:
- `startSession()` - Memulai session
- `isLoggedIn()` - Cek status login
- `getCurrentUser()` - Get user yang sedang login
- `requireLogin()` - Redirect jika belum login

## 📝 Database Schema

Database `nextstep` terdiri dari beberapa tabel utama:

- **users** - Data user (student, mentor, admin)
- **courses** - Data course/kursus
- **modules** - Modul pembelajaran per course
- **enrollments** - Enrollment student ke course
- **assessments** - Data assessment/quiz
- **assessment_results** - Hasil assessment student
- **certificates** - Sertifikat yang sudah diterbitkan
- **forums** - Forum/kategori diskusi
- **forum_posts** - Posting di forum
- **jobs** - Lowongan kerja
- **job_applications** - Aplikasi student ke job
- **mentor_sessions** - Sesi mentoring

Untuk detail lengkap, lihat file `php/databes.db`.

## 🎨 Styling & Assets

- **CSS Files:** Semua file CSS berada di folder `Style/`
- **Assets:** Logo, images, icons ada di folder `Asset/`
- **Bootstrap:** Menggunakan Bootstrap 5.0.2 untuk responsive design
- **Custom CSS:** Styling khusus untuk setiap halaman

## 🔒 Security Features

- Password hashing menggunakan `password_hash()`
- Session management untuk authentication
- SQL prepared statements untuk prevent SQL injection
- Input validation dan sanitization
- XSS protection dengan `htmlspecialchars()`

## 📱 Responsive Design

Platform ini responsive dan dapat diakses melalui:
- Desktop
- Tablet
- Mobile devices

## 🌐 URL Structure

```
http://localhost/PFB Lec/
├── Html/
│   ├── home.php          # Homepage
│   ├── about.php         # About page
│   ├── login.php         # Login page
│   └── register.php      # Register page
└── Html User/
    ├── dashborad_mahasigma.php  # User dashboard
    ├── mycourse.php             # My courses
    ├── assestment.php           # Assessments
    ├── certi.php                # Certificates
    ├── mentor.php               # Mentorship
    ├── getAJOBBB.php            # Job board
    └── komuniti.php             # Community forum
```

## 🐛 Troubleshooting

### Database Connection Error

Jika muncul error "Unknown database 'nextstep'":
1. Pastikan database sudah dibuat di phpMyAdmin
2. Cek konfigurasi di `php/config.php`
3. Pastikan MySQL service running di XAMPP

### Assets Not Loading

Jika CSS/JS/Images tidak ter-load:
1. Cek path relatif di file PHP
2. Pastikan struktur folder sudah benar
3. Clear browser cache

### Session Issues

Jika ada masalah dengan session:
1. Pastikan PHP session enabled
2. Check file permissions
3. Clear browser cookies

### 404 Not Found

Jika halaman tidak ditemukan:
1. Pastikan file PHP ada di folder yang benar
2. Cek URL path (perhatikan spasi di "PFB Lec")
3. Gunakan `http://localhost/PFB%20Lec/` untuk encoding URL

## 🤝 Contributing

Untuk kontribusi ke project ini:

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

Project ini dibuat untuk keperluan pembelajaran dan portfolio.

## 👨‍💻 Developer

Dikembangkan dengan ❤️ untuk membantu mahasiswa membangun skill dan karier yang lebih baik.

## 📞 Contact & Support

- **Instagram:** [@kvieruu](https://www.instagram.com/kvieruu/)
- **Email:** (Tambahkan email jika ada)

## 🎯 Roadmap

Fitur yang akan datang:
- [ ] Email notification system
- [ ] Real-time chat untuk mentoring
- [ ] Video streaming untuk course
- [ ] Mobile app version
- [ ] Payment integration
- [ ] Advanced analytics dashboard

## 🙏 Acknowledgments

- Bootstrap untuk responsive framework
- XAMPP untuk development environment
- Semua contributor dan tester

---

**Happy Learning! 🚀**

*Last Updated: 2025*
