<?php
session_start();
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quick Test - Admin & Student</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .test-section { background: #f8f9fa; padding: 1rem; margin: 1rem 0; border-radius: 5px; }
        .admin-section { border-left: 4px solid #dc3545; }
        .student-section { border-left: 4px solid #28a745; }
        .quick-login { display: inline-block; margin: 0.5rem; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚡ Quick Test - Admin & Student</h1>
        
        <!-- Current Status -->
        <div class="test-section">
            <h3>📊 Trạng thái hiện tại:</h3>
            <?php if (isset($_SESSION['user_id'])): ?>
                <p style="color: green;">✅ <strong>Đã đăng nhập:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?> (<?php echo $_SESSION['is_admin'] ? 'Admin' : 'Student'; ?>)</p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
            <?php else: ?>
                <p style="color: red;">❌ <strong>Chưa đăng nhập</strong></p>
            <?php endif; ?>
            <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
        </div>

        <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- LOGIN OPTIONS -->
        <div class="test-section">
            <h3>🔐 Login Options:</h3>
            
            <!-- Admin Login -->
            <div class="admin-section" style="margin: 1rem 0; padding: 1rem;">
                <h4>👨‍💼 Admin Login</h4>
                <form method="POST" action="<?php echo base_url('login'); ?>" class="quick-login">
                    <input type="hidden" name="email" value="admin@example.com">
                    <input type="hidden" name="password" value="password">
                    <button type="submit" style="padding: 0.5rem 1rem; background: #dc3545; color: white; border: none; border-radius: 3px;">🔓 Login as Admin</button>
                </form>
                <p><small>Email: admin@example.com | Password: password</small></p>
            </div>
            
            <!-- Student Login -->
            <div class="student-section" style="margin: 1rem 0; padding: 1rem;">
                <h4>👨‍🎓 Student Login</h4>
                <form method="POST" action="<?php echo base_url('login'); ?>" class="quick-login">
                    <input type="hidden" name="email" value="student@example.com">
                    <input type="hidden" name="password" value="password">
                    <button type="submit" style="padding: 0.5rem 1rem; background: #28a745; color: white; border: none; border-radius: 3px;">🔓 Login as Student</button>
                </form>
                <p><small>Email: student@example.com | Password: password</small></p>
            </div>
        </div>
        <?php else: ?>

        <!-- LOGGED IN - TEST FUNCTIONS -->
        <div class="test-section">
            <h3>🚀 Test Chức năng:</h3>
            
            <?php if ($_SESSION['is_admin']): ?>
            <!-- ADMIN FUNCTIONS -->
            <div class="admin-section" style="margin: 1rem 0; padding: 1rem;">
                <h4>👨‍💼 Admin Functions</h4>
                <p><strong>🛣️ Via Main Routes:</strong></p>
                <p>
                    <a href="<?php echo base_url('majors'); ?>" target="_blank" style="display: inline-block; margin: 0.2rem; padding: 0.5rem; background: #dc3545; color: white; text-decoration: none; border-radius: 3px;">📚 Manage Majors</a>
                    <a href="<?php echo base_url('admin/applications'); ?>" target="_blank" style="display: inline-block; margin: 0.2rem; padding: 0.5rem; background: #dc3545; color: white; text-decoration: none; border-radius: 3px;">📄 Manage Applications</a>
                    <a href="<?php echo base_url('dashboard'); ?>" target="_blank" style="display: inline-block; margin: 0.2rem; padding: 0.5rem; background: #dc3545; color: white; text-decoration: none; border-radius: 3px;">📋 Dashboard</a>
                </p>
            </div>
            <?php endif; ?>
            
            <!-- STUDENT FUNCTIONS -->
            <div class="student-section" style="margin: 1rem 0; padding: 1rem;">
                <h4>👨‍🎓 Student Functions</h4>
                <p><strong>🛣️ Via Main Routes:</strong></p>
                <p>
                    <a href="<?php echo base_url('my-application'); ?>" target="_blank" style="display: inline-block; margin: 0.2rem; padding: 0.5rem; background: #28a745; color: white; text-decoration: none; border-radius: 3px;">📝 My Application</a>
                    <a href="<?php echo base_url('applications/create'); ?>" target="_blank" style="display: inline-block; margin: 0.2rem; padding: 0.5rem; background: #28a745; color: white; text-decoration: none; border-radius: 3px;">➕ Create Application</a>
                    <a href="<?php echo base_url('dashboard'); ?>" target="_blank" style="display: inline-block; margin: 0.2rem; padding: 0.5rem; background: #007bff; color: white; text-decoration: none; border-radius: 3px;">📋 Dashboard</a>
                </p>
            </div>
            
            <hr>
            <a href="<?php echo base_url('logout'); ?>" style="padding: 0.5rem 1rem; background: #6c757d; color: white; text-decoration: none; border-radius: 3px;">🚪 Logout</a>
        </div>
        <?php endif; ?>

        <!-- INSTRUCTIONS -->
        <div class="test-section">
            <h3>📝 Hướng dẫn:</h3>
            <ol>
                <li><strong>Clear browser cache</strong> trước (Ctrl+Shift+R)</li>
                <li><strong>Chọn login Admin hoặc Student</strong></li>
                <li><strong>Test các chức năng</strong> - mở links trong tab mới</li>
                <li><strong>Kiểm tra Dashboard</strong> có hiển thị đúng menu theo role không</li>
            </ol>
            
            <h4>🐛 Debug Tools:</h4>
            <p>
                <a href="<?php echo base_url('debug_login.php'); ?>" style="padding: 0.3rem 0.7rem; background: #17a2b8; color: white; text-decoration: none; border-radius: 3px;">🐛 Debug Login</a>
                <a href="<?php echo base_url('check_users.php'); ?>" style="padding: 0.3rem 0.7rem; background: #6f42c1; color: white; text-decoration: none; border-radius: 3px;">👥 Check Users</a>
            </p>
        </div>

        <p><a href="<?php echo $_SERVER['PHP_SELF']; ?>">🔄 Refresh Page</a></p>
    </div>
</body>
</html> 