<?php
require_once '../php/config.php';
requireLogin();

$user = getCurrentUser($conn);

$stmt = $conn->prepare("SELECT * FROM users WHERE role = 'mentor' ORDER BY name ASC");
$stmt->execute();
$mentors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (empty($mentors)) {
    $mentors = [
        ['name' => 'EL MANUK - Wall Street', 'major' => 'Quantitative Trading & Investment', 'skills' => 'Algorithmic Trading, Quantitative Investing, AI & ML, Blockchain Development', 'linked_in' => ''],
        ['name' => 'Agung Data Mining - Microsoft', 'major' => 'Data Analyst & Business Intelligence', 'skills' => 'Data Analysis, Business Intelligence, Data Visualization, Data Engineering', 'linked_in' => ''],
        ['name' => 'Prof. Dr. Depun - Mayo Clinic', 'major' => 'Neurologist & Biomedical Engineer', 'skills' => 'Neurology, Biomedical Engineering, Signal Processing, Biomedical Imaging', 'linked_in' => ''],
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentorship - NextStep</title>
    <link rel="stylesheet" href="../Style/mentor.css">
    <link rel="stylesheet" href="../Style/futer-after-log.css">
    <link rel="stylesheet" href="../Style/mahasigma.css">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="icon" href="../Asset/Logo.png">
</head>
<body>
    <!-- sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <a href="dashborad_mahasigma.php"><img src="../Asset/Next Step logo 2.png" alt="Logo"></a>
        </div>
        <ul class="menu">
            <li><a href="dashborad_mahasigma.php">Dashboard</a></li>
            <li><a href="mycourse.php">My Courses</a></li>
            <li><a href="certi.php">Certificates</a></li>
            <li><a href="assestment.php">Assessments</a></li>
            <li class="active"><a href="mentor.php">Mentorship</a></li>
            <li><a href="getAJOBBB.php">Job Board</a></li>
            <li><a href="komuniti.php">Community</a></li>
            <li><a href="userset.php">Settings</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="../php/logout.php" class="sidebar-futer">Logout</a>
        </div>
    </aside>
    <!-- main -->
    <main class="main">
        <header class="topbar">
            <h1>Mentorship Program</h1>
            <p>Get 1-on-1 guidance from professionals to grow your skills and career.</p>
        </header>

        <!-- MENTOR LIST -->
        <section class="mentor-container">
            <?php if (empty($mentors)): ?>
                <p class="text-muted">Belum ada mentor yang tersedia saat ini.</p>
            <?php else: ?>
                <?php foreach ($mentors as $mentor): 
                    $skills = !empty($mentor['skills']) ? explode(',', $mentor['skills']) : [];
                ?>
                    <div class="mentor-card">
                        <img src="https://i.pinimg.com/736x/1c/0a/1c/1c0a1cce415f1ea727639d12c3cba391.jpg" class="mentor-photo" alt="<?php echo htmlspecialchars($mentor['name']); ?>">
                        <div class="mentor-info">
                            <h3><?php echo htmlspecialchars($mentor['name']); ?></h3>
                            <p class="mentor-role"><?php echo htmlspecialchars($mentor['major'] ?? 'Professional Mentor'); ?></p>
                            <?php if (!empty($skills)): ?>
                                <div class="mentor-tags">
                                    <?php foreach ($skills as $skill): ?>
                                        <span class="tag-skill"><?php echo htmlspecialchars(trim($skill)); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($mentor['linked_in'])): ?>
                                <p class="mentor-exp">LinkedIn: <a href="<?php echo htmlspecialchars($mentor['linked_in']); ?>" target="_blank">View Profile</a></p>
                            <?php endif; ?>
                        </div>
                        <div class="mentor-action">
                            <button class="btn">Book Session</button>
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
</body>
</html>

