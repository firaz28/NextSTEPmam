<?php
/**
 * Index/Helper File
 * File ini membantu menemukan path yang benar untuk project
 */

// Redirect ke halaman yang tepat berdasarkan yang tersedia
$base_url = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$base_url = $base_url ?: '/';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextStep - Project Setup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #1d4ed8;
            margin-bottom: 10px;
            font-size: 2em;
        }
        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }
        .info-box {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #1d4ed8;
        }
        .info-box h3 {
            color: #1d4ed8;
            margin-bottom: 10px;
        }
        .url-list {
            list-style: none;
            padding: 0;
        }
        .url-list li {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .url-list a {
            color: #1d4ed8;
            text-decoration: none;
            font-weight: 600;
            display: block;
            word-break: break-all;
        }
        .url-list a:hover {
            text-decoration: underline;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #1d4ed8;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px 5px 0 0;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #1e40af;
        }
        .btn-secondary {
            background: #6b7280;
        }
        .btn-secondary:hover {
            background: #4b5563;
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .alert-warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            color: #92400e;
        }
        .alert-info {
            background: #dbeafe;
            border-left: 4px solid #3b82f6;
            color: #1e40af;
        }
        code {
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }
        .path-info {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-family: monospace;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 NextStep Project</h1>
        <p class="subtitle">Welcome! Pilih halaman yang ingin Anda akses:</p>

        <div class="info-box">
            <h3>📍 Informasi Path</h3>
            <div class="path-info">
                <strong>Base URL:</strong> <?php echo htmlspecialchars($base_url); ?><br>
                <strong>Document Root:</strong> <?php echo htmlspecialchars($_SERVER['DOCUMENT_ROOT']); ?><br>
                <strong>Script Path:</strong> <?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>
            </div>
        </div>

        <div class="info-box">
            <h3>🔗 Link Penting</h3>
            <ul class="url-list">
                <li>
                    <strong>📦 Install Database</strong><br>
                    <a href="<?php echo $base_url; ?>/php/install.php" target="_blank">
                        <?php echo $base_url; ?>/php/install.php
                    </a>
                </li>
                <li>
                    <strong>🏠 Home Page</strong><br>
                    <a href="<?php echo $base_url; ?>/Html/home.html" target="_blank">
                        <?php echo $base_url; ?>/Html/home.html
                    </a>
                </li>
                <li>
                    <strong>🔐 Login Page</strong><br>
                    <a href="<?php echo $base_url; ?>/Html/login.php" target="_blank">
                        <?php echo $base_url; ?>/Html/login.php
                    </a>
                </li>
                <li>
                    <strong>📝 Register Page</strong><br>
                    <a href="<?php echo $base_url; ?>/Html/register.php" target="_blank">
                        <?php echo $base_url; ?>/Html/register.php
                    </a>
                </li>
            </ul>
        </div>

        <div class="alert alert-warning">
            <strong>⚠️ Penting!</strong> Jika link di atas tidak bekerja, coba URL berikut:
            <ul style="margin: 10px 0 0 20px;">
                <li><code>http://localhost/PFB%20Lec/php/install.php</code></li>
                <li><code>http://localhost/PFB Lec/php/install.php</code> (dengan spasi)</li>
            </ul>
        </div>

        <div class="alert alert-info">
            <strong>ℹ️ Catatan:</strong> Jika folder project Anda memiliki nama berbeda, 
            ganti <code>PFB Lec</code> dengan nama folder Anda di <code>htdocs</code>.
        </div>

        <div style="margin-top: 30px;">
            <a href="<?php echo $base_url; ?>/php/install.php" class="btn">🚀 Install Database</a>
            <a href="<?php echo $base_url; ?>/Html/home.html" class="btn btn-secondary">🏠 Home Page</a>
        </div>
    </div>
</body>
</html>

