<?php
require_once '../php/config.php';
requireLogin();

$user = getCurrentUser($conn);
$user_id = $user['user_id'];

$stmt = $conn->prepare("
    SELECT e.*, c.title, c.category, c.level, c.description 
    FROM enrollments e 
    JOIN courses c ON e.course_id = c.course_id 
    WHERE e.user_id = ? AND e.status = 'ongoing' 
    ORDER BY e.enrolled_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$ongoing_courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("
    SELECT e.*, c.title, c.category, c.level, c.description, cert.cert_id, cert.cert_url
    FROM enrollments e 
    JOIN courses c ON e.course_id = c.course_id 
    LEFT JOIN certificates cert ON cert.user_id = e.user_id AND cert.course_id = e.course_id
    WHERE e.user_id = ? AND e.status = 'completed' 
    ORDER BY e.enrolled_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$completed_courses = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Course - NextStep</title>
    <link rel="icon" href="../Asset/Logo.png">
    <link rel="stylesheet" href="../Style/header.css">
    <link rel="stylesheet" href="../Style/futer-after-log.css">
    <link rel="stylesheet" href="../Style/main.css">
    <link rel="stylesheet" href="../Style/mahasigma.css">
    <link rel="stylesheet" href="../Style/course.css">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>
    <!-- sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <a href="dashborad_mahasigma.php"><img src="../Asset/Next Step logo 2.png" alt="Logo"></a>
        </div>
        <ul class="menu">
            <li><a href="dashborad_mahasigma.php">Dashboard</a></li>
            <li class="active"><a href="mycourse.php">My Courses</a></li>
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
        <!-- page header -->
        <section class="page-header">
            <h1>My Courses</h1>
        </section>
        <div class="course-tabs">
            <button class="tab active" onclick="openTab('ongoing', this)">Ongoing</button>
            <button class="tab" onclick="openTab('completed', this)">Completed</button>
        </div>
        <section id="ongoing" class="course-ongoing active-section">
            <?php if (empty($ongoing_courses)): ?>
                <p class="text-muted">Belum ada course yang sedang diikuti. Mulai belajar sekarang!</p>
            <?php else: ?>
                <?php foreach ($ongoing_courses as $course): ?>
                    <div class="course-card">
                        <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=400&h=300&fit=crop" class="course-thumb" alt="<?php echo htmlspecialchars($course['title']); ?>">
                        <div class="course-info">
                            <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                            <p>Level: <?php echo ucfirst($course['level']); ?> • Category: <?php echo htmlspecialchars($course['category']); ?></p>
                            <progress value="<?php echo $course['progress']; ?>" max="100"></progress>
                            <p class="progress-text"><?php echo round($course['progress']); ?>% Complete</p>
                            <button class="btn">Continue</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        <section id="completed" class="course-completed">
            <?php if (empty($completed_courses)): ?>
                <p class="text-muted">Belum ada course yang selesai.</p>
            <?php else: ?>
                <?php foreach ($completed_courses as $course): ?>
                    <div class="course-card">
                        <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=400&h=300&fit=crop" class="course-thumb" alt="<?php echo htmlspecialchars($course['title']); ?>">
                        <div class="course-info">
                            <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                            <p>Completed • <?php echo $course['cert_id'] ? 'Earned Certificate' : 'No Certificate'; ?></p>
                            <?php if ($course['cert_id']): ?>
                                <button class="btn-small">Download Certificate</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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
    <script src="../Js/Sekerip.js"></script>
</body>
</html>

