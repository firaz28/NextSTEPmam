<?php
require_once '../php/config.php';
requireLogin();

$user = getCurrentUser($conn);
$user_id = $user['user_id'];

$stmt = $conn->prepare("
    SELECT cert.*, c.title as course_title, c.category 
    FROM certificates cert
    JOIN courses c ON cert.course_id = c.course_id
    WHERE cert.user_id = ?
    ORDER BY cert.issue_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$certificates = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates - NextStep</title>
    <link rel="stylesheet" href="../Style/certi.css">
    <link rel="stylesheet" href="../Style/futer-after-log.css">
    <link rel="stylesheet" href="../Style/mahasigma.css">
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="icon" href="../Asset/Logo.png">
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo">
            <a href="dashborad_mahasigma.php"><img src="../Asset/Next Step logo 2.png" alt="Logo"></a>
        </div>
        <ul class="menu">
            <li><a href="dashborad_mahasigma.php">Dashboard</a></li>
            <li><a href="mycourse.php">My Courses</a></li>
            <li class="active"><a href="certi.php">Certificates</a></li>
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
        <header class="topbar">
            <h1>My Certificates</h1>
        </header>

        <section class="cert-container">
            <?php if (empty($certificates)): ?>
                <p class="text-muted">Belum ada certificate yang diperoleh. Selesaikan course untuk mendapatkan certificate!</p>
            <?php else: ?>
                <?php foreach ($certificates as $cert): ?>
                    <div class="cert-card">
                        <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=400&h=300&fit=crop" class="cert-thumb" alt="Certificate">
                        <div class="cert-info">
                            <h3><?php echo htmlspecialchars($cert['course_title']); ?></h3>
                            <p>Completed on: <?php echo date('d F Y', strtotime($cert['issue_date'])); ?></p>
                            <p>Certificate ID: <?php echo htmlspecialchars($cert['cert_code']); ?></p>
                        </div>
                        <div class="cert-actions">
                            <?php if ($cert['cert_url']): ?>
                                <a href="<?php echo htmlspecialchars($cert['cert_url']); ?>" class="btn-outline" download>Download</a>
                            <?php else: ?>
                                <button class="btn-outline">View Certificate</button>
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
</body>
</html>

