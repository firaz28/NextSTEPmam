<?php
/**
 * Assessments Page
 * Halaman untuk menampilkan assessments user
 */

require_once '../php/config.php';
requireLogin();

$user = getCurrentUser($conn);
$user_id = $user['user_id'];

$stmt = $conn->prepare("
    SELECT a.*, c.title as course_title, c.category,
           ar.score, ar.submitted_at,
           e.progress
    FROM assessments a
    JOIN courses c ON a.course_id = c.course_id
    JOIN enrollments e ON e.course_id = c.course_id AND e.user_id = ?
    LEFT JOIN assessment_results ar ON ar.assessment_id = a.assessment_id AND ar.user_id = ?
    ORDER BY a.created_at DESC
");
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$assessments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessments - NextStep</title>
    <link rel="stylesheet" href="../Style/assesmen.css">
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
            <li><a href="certi.php">Certificates</a></li>
            <li class="active"><a href="assestment.php">Assessments</a></li>
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
            <h1>Assessments</h1>
        </header>
        <section class="assessment-container">
            <?php if (empty($assessments)): ?>
                <p class="text-muted">Belum ada assessment yang tersedia. Enroll course untuk mendapatkan assessment!</p>
            <?php else: ?>
                <?php foreach ($assessments as $assessment): 
                    $is_completed = !empty($assessment['score']);
                    $is_locked = $assessment['progress'] < 70;
                    $status_class = $is_completed ? 'completed' : ($is_locked ? 'locked' : 'available');
                    $status_text = $is_completed ? 'Completed' : ($is_locked ? 'Locked' : 'Available');
                ?>
                    <div class="assessment-card">
                        <div class="assessment-left">
                            <h3><?php echo htmlspecialchars($assessment['title']); ?></h3>
                            <p>Course: <?php echo htmlspecialchars($assessment['course_title']); ?></p>
                            <?php if ($is_completed): ?>
                                <p class="due">Score: <?php echo $assessment['score']; ?>/<?php echo $assessment['total_score']; ?></p>
                            <?php elseif ($is_locked): ?>
                                <p class="due">Unlock at 70% progress (Current: <?php echo round($assessment['progress']); ?>%)</p>
                            <?php else: ?>
                                <p class="due">Due: <?php echo date('d F Y', strtotime($assessment['created_at'] . ' +7 days')); ?></p>
                            <?php endif; ?>
                            <span class="status <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                        </div>
                        <div class="assessment-right">
                            <?php if ($is_completed): ?>
                                <button class="btn-small">View Result</button>
                            <?php elseif ($is_locked): ?>
                                <button class="btn-disabled" disabled>Locked</button>
                            <?php else: ?>
                                <button class="btn">Start <?php echo ucfirst($assessment['type']); ?></button>
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

