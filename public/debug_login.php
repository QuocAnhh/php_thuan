<?php
// Simple login debug
require_once __DIR__ . '/../config/config.php';
session_start();

echo "<h1>🐛 Login Debug</h1>";

if ($_POST) {
    echo "<h2>📨 POST Data Received:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    echo "<h2>🔍 Database Check:</h2>";
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        echo "<p>✅ User found: " . htmlspecialchars($user['name']) . "</p>";
        echo "<p>Password verify: " . (password_verify($password, $user['password']) ? "✅ TRUE" : "❌ FALSE") . "</p>";
        
        if (password_verify($password, $user['password'])) {
            echo "<h2>🎯 Setting Session:</h2>";
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['is_admin'] = (bool)$user['is_admin'];
            
            echo "<p>✅ Session set successfully!</p>";
            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";
            
            echo "<p><a href='" . base_url('dashboard') . "'>🔗 Go to Dashboard</a></p>";
        } else {
            echo "<p>❌ Password verification failed</p>";
        }
    } else {
        echo "<p>❌ User not found</p>";
    }
} else {
    ?>
    <h2>🔐 Test Login:</h2>
    <form method="POST">
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" value="admin@example.com" required>
        </p>
        <p>
            <label>Password:</label><br>
            <input type="password" name="password" value="password" required>
        </p>
        <p>
            <button type="submit">🚀 Test Login</button>
        </p>
    </form>
    
    <h2>📊 Current Session:</h2>
    <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
    <pre><?php print_r($_SESSION); ?></pre>
    <?php
}
?> 