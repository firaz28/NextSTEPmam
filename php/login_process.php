<?php
/**
 * Login Process
 * File ini menangani proses login user
 */

require_once 'config.php';
startSession();

// Cek apakah form sudah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validasi input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Email dan password harus diisi!';
        header("Location: ../Html/login.php");
        exit();
    }
    
    // Cari user berdasarkan email
    $user = getUserByEmail($conn, $email);
    
    // Cek apakah user ada dan password benar
    if ($user && password_verify($password, $user['password'])) {
        // Set session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'] ?? 'user';
        
        // Redirect ke dashboard
        header("Location: ../Html User/dashborad_mahasigma.php");
        exit();
    } else {
        $_SESSION['error'] = 'Email atau password salah!';
        header("Location: ../Html/login.php");
        exit();
    }
} else {
    // Jika bukan POST, redirect ke login
    header("Location: ../Html/login.php");
    exit();
}
?>

