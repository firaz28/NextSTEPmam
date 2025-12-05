<?php
/**
 * Register Process
 * File ini menangani proses registrasi user baru
 */

require_once 'config.php';
startSession();

// Cek apakah form sudah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validasi input
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Nama lengkap harus diisi!';
    }
    
    if (empty($email)) {
        $errors[] = 'Email harus diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid!';
    }
    
    if (empty($password)) {
        $errors[] = 'Password harus diisi!';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter!';
    }
    
    if ($password !== $confirm_password) {
        $errors[] = 'Password dan konfirmasi password tidak sama!';
    }
    
    // Cek apakah email sudah terdaftar
    if (empty($errors)) {
        $existingUser = getUserByEmail($conn, $email);
        if ($existingUser) {
            $errors[] = 'Email sudah terdaftar!';
        }
    }
    
    // Jika ada error, simpan ke session dan redirect
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: ../Html/register.php");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user ke database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'student')");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        // Set session untuk auto login
        $user_id = $conn->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'student';
        $_SESSION['success'] = 'Registrasi berhasil! Selamat datang!';
        
        // Redirect ke dashboard
        header("Location: ../Html User/dashborad_mahasigma.php");
        exit();
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan saat registrasi. Silakan coba lagi!';
        header("Location: ../Html/register.php");
        exit();
    }
} else {
    // Jika bukan POST, redirect ke register
    header("Location: ../Html/register.php");
    exit();
}
?>

