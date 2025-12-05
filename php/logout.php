<?php
/**
 * Logout Process
 * File ini menangani proses logout user
 */

require_once 'config.php';
startSession();

// Hapus semua session
session_unset();
session_destroy();

// Redirect ke halaman login
header("Location: ../Html/login.php");
exit();
?>

