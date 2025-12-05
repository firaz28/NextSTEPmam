<?php
/**
 * Database Configuration
 * File ini digunakan untuk koneksi ke database MySQL
 */

// Konfigurasi database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'nextstep');

// Membuat koneksi ke database
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    
    // Set charset ke utf8mb4
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Error koneksi database: " . $e->getMessage());
}

/**
 * Fungsi untuk mendapatkan data user berdasarkan email
 */
function getUserByEmail($conn, $email) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

/**
 * Fungsi untuk mendapatkan data user berdasarkan ID
 */
function getUserById($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

/**
 * Fungsi untuk memulai session
 */
function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Fungsi untuk cek apakah user sudah login
 */
function isLoggedIn() {
    startSession();
    return isset($_SESSION['user_id']);
}

/**
 * Fungsi untuk mendapatkan user yang sedang login
 */
function getCurrentUser($conn) {
    if (!isLoggedIn()) {
        return null;
    }
    return getUserById($conn, $_SESSION['user_id']);
}

/**
 * Fungsi untuk redirect jika belum login
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../Html/login.php");
        exit();
    }
}

/**
 * Fungsi untuk mendapatkan base URL project
 */
function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $path = dirname(dirname($script));
    return $protocol . $host . $path;
}

/**
 * Fungsi untuk mendapatkan base path relatif ke root project
 * Mengembalikan path relatif berdasarkan folder file yang memanggil
 */
function getBasePath() {
    // Deteksi dari mana file dipanggil
    $backtrace = debug_backtrace();
    $callerFile = $backtrace[0]['file'] ?? __FILE__;
    $callerDir = dirname($callerFile);
    
    // Root project adalah parent dari folder php/
    $configDir = realpath(__DIR__);
    $rootDir = dirname($configDir);
    $callerPath = realpath($callerDir);
    
    // Hitung depth
    $relative = str_replace($rootDir, '', $callerPath);
    $depth = substr_count($relative, DIRECTORY_SEPARATOR);
    
    if ($depth > 0) {
        return str_repeat('../', $depth);
    }
    return './';
}

/**
 * Helper function untuk path CSS/JS/Asset yang konsisten
 */
function assetPath($path) {
    return getBasePath() . ltrim($path, '/');
}
?>

