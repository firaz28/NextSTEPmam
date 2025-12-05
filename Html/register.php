<?php
require_once '../php/config.php';
startSession();

// Jika sudah login, redirect ke dashboard
if (isLoggedIn()) {
    header("Location: ../Html User/dashborad_mahasigma.php");
    exit();
}

// Ambil error dan old data jika ada
$errors = $_SESSION['errors'] ?? [];
$old_data = $_SESSION['old_data'] ?? [];
unset($_SESSION['errors']);
unset($_SESSION['old_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NextStep</title>
    <link rel="icon" href="../Asset/Logo.png">
    <link rel="stylesheet" href="../Style/header.css">
    <link rel="stylesheet" href="../Style/footer.css">
    <link rel="stylesheet" href="../Style/register.css">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>
    <!-- header -->
    <header class="header">
        <nav class="nav">
            <div class="nav-logo">
                <a href="home.html">
                    <img src="../Asset/Next Step logo 2.png" alt="Next Step Logo">
                </a>
            </div>
            <div class="nav-menu">
                <ul class="nav-menu-list">
                    <li class="nav-menu-item">
                        <a href="home.html" class="nav-menu-link">Home</a>
                    </li>
                    <li class="nav-menu-item">
                        <a href="about.html" class="nav-menu-link">About</a>
                    </li>
                </ul>
                <div class="nav-menu-button">
                    <button class="nav-menu-button-login" onclick="window.location.href='login.php'">Login</button>
                    <button class="nav-menu-button-register" onclick="window.location.href='register.php'">Register</button>
                </div>
            </div>
        </nav>
    </header>
    <!-- main -->
    <main class="main">
        <div class="bg-reg">
            <img src="../Foto Job/14684408_M-1.jpg" alt="" class="bg-reg">
            <img src="../Foto Job/trader-pemula.jpg" alt="" class="bg-reg">
            <img src="../Foto Job/internship-rendi-photo-backend.png" alt="" class="bg-reg">
            <img src="../Foto Job/bd904a36-17cd-473d-8351-73ecb08f514f.jpg" alt="" class="bg-reg">
            <img src="../Foto Job/Featured-images-adv-tren-pekerjaan-min.jpg" alt="" class="bg-reg">
        </div>
        <section class="main-reg">
            <h1 class="reg-title">Create Your Account</h1>
            <div class="reg-intro">
                <p class="reg-intro-txt">
                    Join thousands of learners leveling up their career with curated courses, community mentors, and hiring partners.
                </p>
                <ul class="reg-benefits">
                    <li>Real project-based learning</li>
                    <li>Career coaching sessions</li>
                    <li>Early access to job boards</li>
                </ul>
            </div>
            <?php if (!empty($errors)): ?>
                <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ef5350;">
                    <ul style="margin: 0; padding-left: 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form class="porm" method="POST" action="../php/register_process.php">
                <div class="porm-grup">
                    <label for="name" class="porm-lebel">Full Name</label>
                    <input type="text" id="name" name="name" class="porm-input" placeholder="Enter your full name" value="<?php echo htmlspecialchars($old_data['name'] ?? ''); ?>" required>
                </div>
                <div class="porm-grup">
                    <label for="email" class="porm-lebel">Email</label>
                    <input type="email" id="email" name="email" class="porm-input" placeholder="Enter your email" value="<?php echo htmlspecialchars($old_data['email'] ?? ''); ?>" required>
                </div>
                <div class="porm-grup">
                    <label for="pw" class="porm-lebel">Password</label>
                    <input type="password" id="pw" name="password" class="porm-input" placeholder="Enter your password" required>
                </div>
                <div class="porm-grup">
                    <label for="c_pw" class="porm-lebel">Confirm Password</label>
                    <input type="password" id="c_pw" name="confirm_password" class="porm-input" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="porm-button">Register</button>
            </form>
            <p class="porm-txt">Already have an account? <a href="login.php" class="porm-link">Login</a></p>
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
    <script src="../Js/Sekerip.js"></script>
</body>
</html>

