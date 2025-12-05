<?php
/**
 * Database Installation Script
 * Script ini digunakan untuk membuat database dan tabel secara otomatis
 * 
 * Cara menggunakan:
 * 1. Pastikan MySQL/XAMPP sudah running
 * 2. Buka browser dan akses: http://localhost/PFB%20Lec/php/install.php
 * 3. Script akan membuat database dan semua tabel secara otomatis
 * 4. Setelah selesai, hapus file ini untuk keamanan
 */

// Konfigurasi database (sesuaikan jika perlu)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'nextstep';

// Koneksi ke MySQL tanpa memilih database dulu
$conn = new mysqli($db_host, $db_user, $db_pass);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi ke MySQL gagal: " . $conn->connect_error);
}

echo "<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Install Database - NextStep</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #1d4ed8;
            border-bottom: 3px solid #1d4ed8;
            padding-bottom: 10px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #dc3545;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #17a2b8;
        }
        pre {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #1d4ed8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #1e40af;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 Install Database NextStep</h1>";

// Fungsi untuk menjalankan query dengan error handling
function runQuery($conn, $sql, $description) {
    global $errors;
    if ($conn->query($sql)) {
        echo "<div class='success'>✓ $description</div>";
        return true;
    } else {
        echo "<div class='error'>✗ $description: " . $conn->error . "</div>";
        return false;
    }
}

$errors = [];

// 1. Buat database jika belum ada
echo "<h2>1. Membuat Database...</h2>";
$sql = "CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
runQuery($conn, $sql, "Database '$db_name'");

// Pilih database
$conn->select_db($db_name);
$conn->set_charset("utf8mb4");

// 2. Buat tabel users
echo "<h2>2. Membuat Tabel...</h2>";
$sql = "CREATE TABLE IF NOT EXISTS users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(200) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('student','mentor','admin') NOT NULL DEFAULT 'student',
  major VARCHAR(120),
  skills TEXT,
  linked_in VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'users'");

// 3. Buat tabel courses
$sql = "CREATE TABLE IF NOT EXISTS courses (
  course_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  category VARCHAR(100),
  level ENUM('beginner','intermediate','advanced') DEFAULT 'beginner',
  description TEXT,
  instructor_id INT,
  price DECIMAL(10,2) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_courses_instructor FOREIGN KEY (instructor_id) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'courses'");

// 4. Buat index untuk courses
runQuery($conn, "CREATE INDEX IF NOT EXISTS idx_courses_title ON courses(title)", "Index idx_courses_title");
runQuery($conn, "CREATE INDEX IF NOT EXISTS idx_courses_category ON courses(category)", "Index idx_courses_category");

// 5. Buat tabel modules
$sql = "CREATE TABLE IF NOT EXISTS modules (
  module_id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT NOT NULL,
  title VARCHAR(200),
  content TEXT,
  video_url VARCHAR(255),
  position INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_modules_course FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'modules'");

// 6. Buat tabel enrollments
$sql = "CREATE TABLE IF NOT EXISTS enrollments (
  enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  course_id INT NOT NULL,
  progress DECIMAL(5,2) DEFAULT 0,
  status ENUM('ongoing','completed') DEFAULT 'ongoing',
  enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_enroll_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_enroll_course FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY uk_user_course (user_id, course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'enrollments'");

// 7. Buat tabel assessments
$sql = "CREATE TABLE IF NOT EXISTS assessments (
  assessment_id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT NOT NULL,
  title VARCHAR(200),
  type ENUM('quiz','project') DEFAULT 'quiz',
  total_score INT DEFAULT 100,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_asses_course FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'assessments'");

// 8. Buat tabel assessment_results
$sql = "CREATE TABLE IF NOT EXISTS assessment_results (
  result_id INT AUTO_INCREMENT PRIMARY KEY,
  assessment_id INT NOT NULL,
  user_id INT NOT NULL,
  score INT,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_result_assessment FOREIGN KEY (assessment_id) REFERENCES assessments(assessment_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_result_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'assessment_results'");

// 9. Buat tabel certificates
$sql = "CREATE TABLE IF NOT EXISTS certificates (
  cert_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  course_id INT NOT NULL,
  issue_date DATE,
  cert_code VARCHAR(120) NOT NULL UNIQUE,
  cert_url VARCHAR(255),
  CONSTRAINT fk_cert_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_cert_course FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'certificates'");

// 10. Buat tabel forums
$sql = "CREATE TABLE IF NOT EXISTS forums (
  forum_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  description TEXT,
  created_by INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_forums_user FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'forums'");

// 11. Buat tabel forum_posts
$sql = "CREATE TABLE IF NOT EXISTS forum_posts (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  forum_id INT NOT NULL,
  user_id INT NOT NULL,
  content TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_post_forum FOREIGN KEY (forum_id) REFERENCES forums(forum_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_post_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'forum_posts'");

// 12. Buat tabel jobs
$sql = "CREATE TABLE IF NOT EXISTS jobs (
  job_id INT AUTO_INCREMENT PRIMARY KEY,
  company_name VARCHAR(200),
  position VARCHAR(200),
  description TEXT,
  requirements TEXT,
  posted_by INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_job_postedby FOREIGN KEY (posted_by) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'jobs'");

// 13. Buat tabel job_applications
$sql = "CREATE TABLE IF NOT EXISTS job_applications (
  app_id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  user_id INT NOT NULL,
  status ENUM('pending','accepted','rejected') DEFAULT 'pending',
  applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_app_job FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_app_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY uk_user_job (job_id, user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'job_applications'");

// 14. Buat tabel mentor_sessions
$sql = "CREATE TABLE IF NOT EXISTS mentor_sessions (
  session_id INT AUTO_INCREMENT PRIMARY KEY,
  mentor_id INT,
  student_id INT,
  topic VARCHAR(200),
  schedule DATETIME,
  status ENUM('pending','completed','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_session_mentor FOREIGN KEY (mentor_id) REFERENCES users(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_session_student FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
runQuery($conn, $sql, "Tabel 'mentor_sessions'");

// 15. Buat index tambahan
echo "<h2>3. Membuat Index...</h2>";
runQuery($conn, "CREATE INDEX IF NOT EXISTS idx_jobs_position ON jobs(position)", "Index idx_jobs_position");
runQuery($conn, "CREATE INDEX IF NOT EXISTS idx_forum_title ON forums(title)", "Index idx_forum_title");
runQuery($conn, "CREATE INDEX IF NOT EXISTS idx_users_email ON users(email)", "Index idx_users_email");

// Cek apakah install berhasil
$result = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

echo "<h2>4. Ringkasan</h2>";
echo "<div class='info'>";
echo "<strong>Database:</strong> $db_name<br>";
echo "<strong>Jumlah Tabel:</strong> " . count($tables) . "<br>";
echo "<strong>Tabel yang dibuat:</strong> " . implode(", ", $tables) . "<br>";
echo "</div>";

if (count($tables) >= 12) {
    echo "<div class='success'>";
    echo "<h3>✅ Instalasi Berhasil!</h3>";
    echo "<p>Database dan semua tabel berhasil dibuat. Sekarang Anda bisa:</p>";
    echo "<ul>";
    echo "<li>Mengakses halaman login: <a href='../Html/login.php'>Login</a></li>";
    echo "<li>Mendaftar user baru: <a href='../Html/register.php'>Register</a></li>";
    echo "</ul>";
    echo "<p><strong>⚠️ PENTING:</strong> Hapus file <code>install.php</code> ini untuk keamanan!</p>";
    echo "</div>";
} else {
    echo "<div class='error'>";
    echo "<h3>⚠️ Instalasi Tidak Lengkap</h3>";
    echo "<p>Beberapa tabel mungkin gagal dibuat. Silakan cek error di atas.</p>";
    echo "</div>";
}

$conn->close();

echo "<br><a href='../Html/login.php' class='btn'>→ Lanjut ke Login</a>";
echo "    </div>
</body>
</html>";
?>

