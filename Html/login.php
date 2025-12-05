<?php
require_once '../php/config.php';
startSession();

if (isLoggedIn()) {
    header("Location: ../Html User/dashborad_mahasigma.php");
    exit();
}


$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NextStep</title>
    <link rel="icon" href="../Asset/Logo.png">
    <link rel="stylesheet" href="../Style/header.css">
    <link rel="stylesheet" href="../Style/footer.css">
    <link rel="stylesheet" href="../Style/login.css">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="../Js/Sekerip.js"></script>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav">
            <div class="nav-logo">
                <a href="home.php">
                    <img src="../Asset/Next Step logo 2.png" alt="Next Step Logo">
                </a>
            </div>
            <div class="nav-menu">
                <ul class="nav-menu-list">
                    <li class="nav-menu-item">
                        <a href="home.php" class="nav-menu-link">Home</a>
                    </li>
                    <li class="nav-menu-item">
                        <a href="about.php" class="nav-menu-link">About</a>
                    </li>
                </ul>
                <div class="nav-menu-button">
                    <button class="nav-menu-button-login" onclick="window.location.href='login.php'">Login</button>
                    <button class="nav-menu-button-register" onclick="window.location.href='register.php'">Register</button>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main -->
    <main class="main">
        <div class="bg-reg">
            <img src="../Foto Job/14684408_M-1.jpg" alt="" class="bg-reg">
            <img src="../Foto Job/trader-pemula.jpg" alt="" class="bg-reg">
            <img src="../Foto Job/internship-rendi-photo-backend.png" alt="" class="bg-reg">
            <img src="../Foto Job/bd904a36-17cd-473d-8351-73ecb08f514f.jpg" alt="" class="bg-reg">
            <img src="../Foto Job/Featured-images-adv-tren-pekerjaan-min.jpg" alt="" class="bg-reg">
        </div>
        <section class="main-log">
            <h1 class="log-title">Login</h1>
            <div class="log-intro">
                <p class="log-intro-txt">
                    Access personalized dashboards, bookmarked roles, and progress analytics tailored to your learning path.
                </p>
                <ul class="log-benefits">
                    <li>Track completed modules</li>
                    <li>Save job opportunities</li>
                    <li>Sync mentorship schedule</li>
                </ul>
            </div>
            <?php if ($error): ?>
                <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ef5350;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form class="porm" method="POST" action="../php/login_process.php">
                <div class="porm-grup">
                    <label for="email" class="porm-lebel">Email</label>
                    <input type="email" id="email" name="email" class="porm-input" placeholder="Enter your email" required>
                </div>
                <div class="porm-grup">
                    <label for="pw" class="porm-lebel">Password</label>
                    <input type="password" id="pw" name="password" class="porm-input" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="porm-button">Login</button>
            </form>
            <p class="porm-txt">Don't have an account? <a href="register.php" class="porm-link">Register</a></p>
            <p class="porm-txt">Forgot your password? <a href="forgot-password.html" class="porm-link">Forgot Password</a></p>
        </section>
    </main>
    <!-- footer -->
    <footer class="footer">
        <p class="footer-txt">Copyright 2025 NextStep. All rights reserved.</p>
        <div class="div-footer-sosmed">
            <a href="#" class="footer-sosmed">
                <img src="../Asset/tiktok.png" alt="tiktok">
            </a>
            <a href="https://www.instagram.com/kvieruu/" class="footer-social-link">
                <img src="../Asset/instagram.png" alt="Instagram">
            </a>
        </div>
    </footer>
</body>
</html>

