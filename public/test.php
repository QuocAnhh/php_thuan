<?php
session_start();
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Test Page</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .test-section { margin: 2rem 0; padding: 1rem; border: 1px solid #ddd; border-radius: 5px; }
        .credentials { background-color: #f8f9fa; padding: 1rem; margin: 1rem 0; }
        .status { padding: 0.5rem; margin: 0.5rem 0; border-radius: 3px; }
        .logged-in { background-color: #d4edda; color: #155724; }
        .not-logged-in { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 System Test Page</h1>
        
        <!-- Current Session Status -->
        <div class="test-section">
            <h2>📊 Current Session Status</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="status logged-in">
                    ✅ <strong>Logged In:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?> 
                    (<?php echo $_SESSION['is_admin'] ? 'Admin' : 'Student'; ?>)
                </div>
            <?php else: ?>
                <div class="status not-logged-in">
                    ❌ <strong>Not Logged In</strong> - Please login first
                </div>
            <?php endif; ?>
        </div>

        <!-- Login Section -->
        <div class="test-section">
            <h2>🔐 Quick Login</h2>
            <div class="credentials">
                <strong>Admin Account:</strong><br>
                Email: admin@example.com<br>
                Password: password
            </div>
            
            <p><a href="<?php echo base_url('login'); ?>" target="_blank">🔗 Go to Login Page</a></p>
        </div>

        <!-- Admin Functions Test -->
        <div class="test-section">
            <h2>👨‍💼 Admin Functions</h2>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                <p>✅ You are logged in as Admin. Test these functions:</p>
                <ul>
                    <li><a href="<?php echo base_url('dashboard'); ?>" target="_blank">📋 Dashboard</a></li>
                    <li><a href="<?php echo base_url('majors'); ?>" target="_blank">📚 Manage Majors</a></li>
                    <li><a href="<?php echo base_url('admin/applications'); ?>" target="_blank">📄 Manage Applications</a></li>
                    <li><a href="<?php echo base_url('majors/create'); ?>" target="_blank">➕ Create New Major</a></li>
                </ul>
            <?php else: ?>
                <p>❌ You need to login as Admin to test these functions</p>
            <?php endif; ?>
        </div>

        <!-- Student Functions Test -->
        <div class="test-section">
            <h2>👨‍🎓 Student Functions</h2>
            <div class="credentials">
                <strong>Student Account:</strong><br>
                Email: student@example.com<br>
                Password: (register new account or use existing)
            </div>
            
            <ul>
                <li><a href="<?php echo base_url('register'); ?>" target="_blank">📝 Register New Student</a></li>
                <li><a href="<?php echo base_url('application/create'); ?>" target="_blank">📋 Create Application</a></li>
                <li><a href="<?php echo base_url('my-application'); ?>" target="_blank">👀 View My Application</a></li>
            </ul>
        </div>

        <!-- Database Info -->
        <div class="test-section">
            <h2>🗄️ Database Info</h2>
            <?php
            $tables = ['users', 'majors', 'applications'];
            echo "<ul>";
            foreach ($tables as $table) {
                $query = "SELECT COUNT(*) as count FROM $table";
                $result = mysqli_query($conn, $query);
                $count = mysqli_fetch_assoc($result)['count'];
                echo "<li><strong>$table:</strong> $count records</li>";
            }
            echo "</ul>";
            ?>
        </div>

        <!-- Navigation -->
        <div class="test-section">
            <h2>🔗 Quick Navigation</h2>
            <p><a href="<?php echo base_url(''); ?>">🏠 Homepage</a></p>
            <p><a href="<?php echo base_url('logout'); ?>">🚪 Logout</a></p>
        </div>

        <hr>
        <p><small>💡 <strong>Tip:</strong> Open links in new tabs to keep this test page open for reference.</small></p>
    </div>
</body>
</html> 