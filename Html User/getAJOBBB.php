<?php
/**
 * Job Board Page
 * Halaman untuk menampilkan job opportunities
 */

require_once '../php/config.php';
requireLogin();

$user = getCurrentUser($conn);
$user_id = $user['user_id'];

// Ambil semua jobs
$stmt = $conn->prepare("
    SELECT j.*, u.name as posted_by_name,
           (SELECT COUNT(*) FROM job_applications WHERE job_id = j.job_id AND user_id = ?) as has_applied
    FROM jobs j
    LEFT JOIN users u ON j.posted_by = u.user_id
    ORDER BY j.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$jobs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get A Job - NextStep</title>
    <link rel="stylesheet" href="../Style/getAJOBBB.css">
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
            <li><a href="assestment.php">Assessments</a></li>
            <li><a href="mentor.php">Mentorship</a></li>
            <li class="active"><a href="getAJOBBB.php">Job Board</a></li>
            <li><a href="komuniti.php">Community</a></li>
            <li><a href="userset.php">Settings</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="../php/logout.php" class="sidebar-futer">Logout</a>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <h1>Job & Internship Opportunities</h1>
        </header>

        <section class="filter-section">
            <select class="filter">
                <option>All Locations</option>
                <option>Remote</option>
                <option>Jakarta</option>
                <option>Bandung</option>
                <option>Surabaya</option>
            </select>
            <select class="filter">
                <option>Job Type</option>
                <option>Internship</option>
                <option>Full-time</option>
                <option>Part-time</option>
                <option>Freelance</option>
            </select>
            <select class="filter">
                <option>Category</option>
                <option>Design & Creative</option>
                <option>Programming & Development</option>
                <option>Marketing & Sales</option>
                <option>Business Analytics</option>
            </select>
            <button class="btn">Search</button>
        </section>

        <section class="job-container">
            <?php if (empty($jobs)): ?>
                <p class="text-muted">Belum ada job yang tersedia saat ini.</p>
            <?php else: ?>
                <?php foreach ($jobs as $job): ?>
                    <div class="job-card">
                        <div class="job-left">
                            <h3><?php echo htmlspecialchars($job['position']); ?></h3>
                            <p class="company"><?php echo htmlspecialchars($job['company_name']); ?></p>
                            <p><?php echo htmlspecialchars($job['description']); ?></p>
                            <?php if ($job['requirements']): ?>
                                <p><strong>Requirements:</strong> <?php echo htmlspecialchars($job['requirements']); ?></p>
                            <?php endif; ?>
                            <?php if ($job['posted_by_name']): ?>
                                <p><strong>Posted by:</strong> <?php echo htmlspecialchars($job['posted_by_name']); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="job-right">
                            <?php if ($job['has_applied']): ?>
                                <button class="btn-small" disabled>Applied</button>
                            <?php else: ?>
                                <button class="btn-small">Apply Now</button>
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

