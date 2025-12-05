<?php
/**
 * Forum Create Process
 * File ini menangani proses membuat forum post baru
 */

require_once 'config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $user_id = $_SESSION['user_id'];
    
    if (empty($title) || empty($description)) {
        $_SESSION['error'] = 'Title dan description harus diisi!';
        header("Location: ../Html User/komuniti.php");
        exit();
    }
    
    $stmt = $conn->prepare("INSERT INTO forums (title, description, created_by) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Post berhasil dibuat!';
        header("Location: ../Html User/komuniti.php");
        exit();
    } else {
        $_SESSION['error'] = 'Terjadi kesalahan saat membuat post. Silakan coba lagi!';
        header("Location: ../Html User/komuniti.php");
        exit();
    }
} else {
    header("Location: ../Html User/komuniti.php");
    exit();
}
?>

