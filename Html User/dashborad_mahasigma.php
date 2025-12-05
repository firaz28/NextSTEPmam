<?php
/**
 * Dashboard Page
 * Halaman dashboard user yang terhubung ke database
 */

require_once '../php/config.php';
requireLogin();

// Ambil data user yang sedang login
$user = getCurrentUser($conn);
if (!$user) {
    header("Location: ../php/logout.php");
    exit();
}

// Ambil statistik user
$user_id = $user['user_id'];

// Hitung courses enrolled
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM enrollments WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$courses_enrolled = $result->fetch_assoc()['total'];

// Hitung certificates earned
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM certificates WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$certificates_earned = $result->fetch_assoc()['total'];

// Hitung average progress
$stmt = $conn->prepare("SELECT AVG(progress) as avg_progress FROM enrollments WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$avg_progress = $result->fetch_assoc()['avg_progress'] ?? 0;
$progress_percent = round($avg_progress);

// Ambil courses yang sedang di-enroll (ongoing)
$stmt = $conn->prepare("
    SELECT e.*, c.title, c.category, c.level 
    FROM enrollments e 
    JOIN courses c ON e.course_id = c.course_id 
    WHERE e.user_id = ? AND e.status = 'ongoing' 
    ORDER BY e.enrolled_at DESC 
    LIMIT 5
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$ongoing_courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Ambil recommended courses (belum di-enroll)
$stmt = $conn->prepare("
    SELECT c.* 
    FROM courses c 
    WHERE c.course_id NOT IN (SELECT course_id FROM enrollments WHERE user_id = ?) 
    ORDER BY c.created_at DESC 
    LIMIT 3
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$recommended_courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - NextStep</title>
    <link rel="icon" href="../Asset/Logo.png">
    <link rel="stylesheet" href="../Style/header.css">
    <link rel="stylesheet" href="../Style/futer-after-log.css">
    <link rel="stylesheet" href="../Style/main.css">
    <link rel="stylesheet" href="../Style/mahasigma.css">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>
    <!-- sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <a href="dashborad_mahasigma.php"><img src="../Asset/Next Step logo 2.png" alt="Logo"></a>
        </div>
        <ul class="menu">
            <li class="active"><a href="dashborad_mahasigma.php">Dashboard</a></li>
            <li><a href="mycourse.php">My Courses</a></li>
            <li><a href="certi.php">Certificates</a></li>
            <li><a href="assestment.php">Assessments</a></li>
            <li><a href="mentor.php">Mentorship</a></li>
            <li><a href="getAJOBBB.php">Job Board</a></li>
            <li><a href="komuniti.php">Community</a></li>
            <li><a href="userset.php">Settings</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="../php/logout.php" class="sidebar-futer">Logout</a>
        </div>
    </aside>
    <main class="main">
        <!-- topbar -->
        <header class="topbar">
            <input type="text" placeholder="Search courses, skills..." class="search-box">
            <div class="topbar-right">
                <img src="../Asset/download.jpg" class="profile-img" alt="Profile">
            </div>
        </header>
        <!-- main -->
        <section class="welcome-section">
            <h1>Welcome back, <span id="username"><?php echo htmlspecialchars($user['name']); ?></span></h1>
            <p>Ready to continue your learning journey?</p>
        </section>
        <section class="stats-container">
            <div class="stat-card">
                <h3>Courses Enrolled</h3>
                <p><?php echo $courses_enrolled; ?></p>
            </div>
            <div class="stat-card">
                <h3>Certificates Earned</h3>
                <p><?php echo $certificates_earned; ?></p>
            </div>
            <div class="stat-card">
                <h3>Progress</h3>
                <p><?php echo $progress_percent; ?>%</p>
            </div>
        </section>
        <!-- continue learning section -->
        <section class="continue-section">
            <h2>Continue Learning</h2>
            <div class="course-cards-wrapper">
                <?php if (empty($ongoing_courses)): ?>
                    <p class="text-muted">Belum ada course yang di-enroll. Mulai belajar sekarang!</p>
                <?php else: ?>
                    <?php foreach ($ongoing_courses as $course): ?>
                        <div class="course-card">
                            <div class="course-info">
                                <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                                <progress value="<?php echo $course['progress']; ?>" max="100"></progress>
                            </div>
                            <button class="btn">Continue</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
        <section class="recommend-section">
            <h2>Recommended For You</h2>
            <div class="recommend-grid">
                <?php if (empty($recommended_courses)): ?>
                    <p class="text-muted">Tidak ada course yang direkomendasikan saat ini.</p>
                <?php else: ?>
                    <?php foreach ($recommended_courses as $course): ?>
                        <div class="rec-card">
                            <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=400&h=250&fit=crop" alt="<?php echo htmlspecialchars($course['title']); ?>" class="rec-card-img">
                            <div class="rec-card-content">
                                <h4><?php echo htmlspecialchars($course['title']); ?></h4>
                                <p><?php echo ucfirst($course['level']); ?> Course</p>
                                <button class="btn-small">Start</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <!-- footer -->
    <footer class="futer-">
        <p class="futer-txt">Copyright 2025 NextStep. All rights reserved.</p>
        <div class="div-futer-sosmed">
            <a href="#" class="futer-sosmed">
                <img src="../Asset/tiktok.png" alt="TikTok">
            </a>
            <a href="https://www.instagram.com/kvieruu/" class="futer-social-link">
                <img src="../Asset/instagram.png" alt="Instagram">
            </a>
        </div>
    </footer>
</body>
</html>

