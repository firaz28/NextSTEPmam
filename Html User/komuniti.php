<?php
require_once '../php/config.php';
requireLogin();

$user = getCurrentUser($conn);
$user_id = $user['user_id'];

$stmt = $conn->prepare("
    SELECT f.*, u.name as created_by_name,
           (SELECT COUNT(*) FROM forum_posts WHERE forum_id = f.forum_id) as reply_count
    FROM forums f
    LEFT JOIN users u ON f.created_by = u.user_id
    ORDER BY f.created_at DESC
    LIMIT 20
");
$stmt->execute();
$forums = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - NextStep</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Style/komuniti.css">
    <link rel="stylesheet" href="../Style/futer-after-log.css">
    <link rel="stylesheet" href="../Style/mahasigma.css">
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
            <li><a href="getAJOBBB.php">Job Board</a></li>
            <li class="active"><a href="komuniti.php">Community</a></li>
            <li><a href="userset.php">Settings</a></li>
        </ul>
        <div class="sidebar-footer">
            <a href="../php/logout.php" class="sidebar-futer">Logout</a>
        </div>
    </aside>
    <!-- MAIN -->
    <main class="main">
        <!-- Header Section -->
        <header class="topbar mb-4">
            <div class="d-flex flex-column">
                <h1 class="mb-2">Community</h1>
                <p class="text-muted mb-0">Join discussions, ask questions, share projects, and find study partners.</p>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <input id="searchThread" type="text" class="form-control search-box" style="width: 300px;" placeholder="Search threads or topics..." />
                <button class="btn" id="btnCreatePost">Create Post</button>
            </div>
        </header>

        <!-- Community Grid -->
        <section class="row g-4">
            <!-- LEFT: Forum list & threads -->
            <div class="col-lg-7 col-md-12">
                <!-- Forum categories (tabs) -->
                <div class="forum-tabs mb-4">
                    <button class="tab active" data-target="all">All</button>
                    <button class="tab" data-target="design">UI/UX</button>
                    <button class="tab" data-target="dev">Programming</button>
                    <button class="tab" data-target="career">Career</button>
                    <button class="tab" data-target="project">Projects</button>
                </div>

                <!-- Thread list -->
                <div id="threadList" class="thread-list">
                    <?php if (empty($forums)): ?>
                        <p class="text-muted">Belum ada thread. Buat thread pertama sekarang!</p>
                    <?php else: ?>
                        <?php foreach ($forums as $forum): ?>
                            <article class="thread-card" data-category="all">
                                <div class="thread-left">
                                    <h3 class="thread-title">
                                        <a href="#" onclick="openThread(event, <?php echo $forum['forum_id']; ?>)">
                                            <?php echo htmlspecialchars($forum['title']); ?>
                                        </a>
                                    </h3>
                                    <p class="text-muted mb-2">
                                        <?php echo htmlspecialchars($forum['description'] ?? ''); ?> 
                                        — <strong><?php echo htmlspecialchars($forum['created_by_name'] ?? 'Anonymous'); ?></strong>
                                    </p>
                                    <div class="thread-meta">
                                        <span class="badge">General</span>
                                        <span class="text-muted">• <?php echo $forum['reply_count']; ?> replies</span>
                                        <span class="text-muted">• <?php echo date('d M Y', strtotime($forum['created_at'])); ?></span>
                                    </div>
                                </div>
                                <div class="thread-right">
                                    <button class="btn-small" onclick="openThread(event, <?php echo $forum['forum_id']; ?>)">View</button>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- RIGHT: Thread detail pane -->
            <div class="col-lg-5 col-md-12">
                <div class="thread-detail empty" id="threadPane">
                    <p class="text-muted text-center">Select a thread to view details or click <strong>Create Post</strong> to start a discussion.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- CREATE POST MODAL -->
    <div id="modalCreate" class="modal">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Create Post</h3>
                <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
            </div>
            <form method="POST" action="../php/forum_create.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input name="title" type="text" class="form-control" placeholder="Write a short, clear title" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="6" placeholder="Describe your question or share your project..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex gap-2 justify-content-end">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn">Post</button>
                </div>
            </form>
        </div>
    </div>
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

