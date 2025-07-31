<?php
session_start();
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Test</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .test-box { margin: 1rem 0; padding: 1rem; border: 1px solid #ddd; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        .info { background-color: #d1ecf1; color: #0c5460; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Session Test</h1>
        <div class="test-box info">
            <h3>📊 Current Session Status:</h3>
            <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
            <p><strong>Session Data:</strong></p>
            <pre><?php print_r($_SESSION); ?></pre>
        </div>
        <div class="test-box">
            <h3>🔐 Login Test:</h3>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="success">
                    <p>✅ <strong>Logged In:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                    <p><strong>Role:</strong> <?php echo $_SESSION['is_admin'] ? 'Admin' : 'Student'; ?></p>
                </div>
                <h4>🧪 Test Admin Routes:</h4>
                <p><a href="<?php echo base_url('majors'); ?>" target="_blank">📚 Test Majors Route</a></p>
                <p><a href="<?php echo base_url('admin/applications'); ?>" target="_blank">📄 Test Admin Applications Route</a></p>
                <p><a href="<?php echo base_url('dashboard'); ?>" target="_blank">📋 Test Dashboard Route</a></p>
                <hr>
                <p><a href="<?php echo base_url('logout'); ?>">🚪 Logout</a></p>
            <?php else: ?>
                <div class="error">
                    <p>❌ <strong>Not Logged In</strong></p>
                </div>
                <h4>🔐 Quick Login:</h4>
                <form method="POST" action="<?php echo base_url('login'); ?>">
                    <p>
                        <input type="hidden" name="email" value="admin@example.com">
                        <input type="hidden" name="password" value="password">
                        <button type="submit">🔓 Login as Admin</button>
                    </p>
                </form>
                <p><small>Auto-fill: admin@example.com / password</small></p>
            <?php endif; ?>
        </div>
        <div class="test-box">
            <h3>🔄 Actions:</h3>
            <p><a href="<?php echo $_SERVER['PHP_SELF']; ?>">🔄 Refresh This Page</a></p>
            <p><a href="<?php echo base_url('admin_portal.php'); ?>">🛡️ Admin Portal</a></p>
            <p><a href="<?php echo base_url('test.php'); ?>">🧪 System Test</a></p>
        </div>
        <div class="test-box info">
            <h3>📝 Instructions:</h3>
            <ol>
                <li><strong>Clear browser cache</strong> (Ctrl+Shift+R hoặc Ctrl+F5)</li>
                <li><strong>Login</strong> bằng form trên hoặc manual login</li>
                <li><strong>Test routes</strong> - click các links "Test ... Route"</li>
                <li><strong>Check logs</strong> - xem error log nếu cần debug</li>
            </ol>
        </div>
    </div>
</body>
</html> 