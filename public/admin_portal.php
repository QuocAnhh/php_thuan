<?php
session_start();
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION['user_id']) && isset($_GET['auto_admin'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['user_name'] = 'Test Admin User';
    $_SESSION['user_email'] = 'admin@example.com';
    $_SESSION['is_admin'] = true;
    header('Location: ' . base_url('admin_portal.php'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .admin-section { margin: 2rem 0; padding: 1.5rem; border: 2px solid #007bff; border-radius: 8px; background: #f8f9ff; }
        .function-link { display: inline-block; margin: 0.5rem; padding: 1rem 1.5rem; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .function-link:hover { background: #0056b3; color: white; }
        .status-good { color: #28a745; font-weight: bold; }
        .status-bad { color: #dc3545; font-weight: bold; }
        .direct-link { background: #28a745; }
        .route-link { background: #17a2b8; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛡️ Admin Portal</h1>
        <div class="admin-section">
            <h2>📊 Session Status</h2>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['is_admin']): ?>
                <p class="status-good">✅ Logged in as: <?php echo htmlspecialchars($_SESSION['user_name']); ?> (Admin)</p>
                <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
            <?php else: ?>
                <p class="status-bad">❌ Not logged in as admin</p>
                <p><a href="<?php echo base_url('admin_portal.php?auto_admin=1'); ?>" class="function-link">🔓 Auto-Login Admin (For Testing)</a></p>
                <p><a href="<?php echo base_url('login'); ?>" class="function-link">🔐 Manual Login</a></p>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['is_admin']): ?>
        <div class="admin-section">
            <h2>👨‍💼 Admin Functions</h2>
            <h3>🛣️ Via Routing (May not work due to session issues):</h3>
            <p>
                <a href="<?php echo base_url('majors'); ?>" class="function-link route-link" target="_blank">📚 Manage Majors</a>
                <a href="<?php echo base_url('admin/applications'); ?>" class="function-link route-link" target="_blank">📄 Manage Applications</a>
                <a href="<?php echo base_url('dashboard'); ?>" class="function-link route-link" target="_blank">📋 Dashboard</a>
            </p>
            <h3>🎯 Direct Access (Should always work):</h3>
            <p>
                <a href="<?php echo base_url('majors_direct.php'); ?>" class="function-link direct-link" target="_blank">📚 Majors Direct</a>
                <a href="<?php echo base_url('admin_apps_direct.php'); ?>" class="function-link direct-link" target="_blank">📄 Applications Direct</a>
            </p>
        </div>
        <div class="admin-section">
            <h2>🔧 Admin Tools</h2>
            <p>
                <a href="<?php echo base_url('majors/create'); ?>" class="function-link" target="_blank">➕ Create Major</a>
                <a href="<?php echo base_url('majors/edit?id=1'); ?>" class="function-link" target="_blank">✏️ Edit Major</a>
                <a href="<?php echo base_url('admin/applications/show?id=1'); ?>" class="function-link" target="_blank">👀 View Application</a>
            </p>
        </div>
        <div class="admin-section">
            <h2>🐛 Debug Tools</h2>
            <p>
                <a href="<?php echo base_url('debug_admin.php'); ?>" class="function-link" target="_blank">🔍 Debug Admin Functions</a>
                <a href="<?php echo base_url('debug_routing.php'); ?>" class="function-link" target="_blank">🛣️ Debug Routing</a>
                <a href="<?php echo base_url('test.php'); ?>" class="function-link" target="_blank">🧪 System Test</a>
            </p>
        </div>
        <?php endif; ?>
        <div class="admin-section">
            <h2>🔗 Navigation</h2>
            <p>
                <a href="<?php echo base_url(''); ?>" class="function-link">🏠 Homepage</a>
                <a href="<?php echo base_url('logout'); ?>" class="function-link">🚪 Logout</a>
            </p>
        </div>
        <hr>
        <p><small>💡 <strong>Tip:</strong> Nếu "Via Routing" links không hoạt động, hãy dùng "Direct Access" links.</small></p>
    </div>
</body>
</html> 