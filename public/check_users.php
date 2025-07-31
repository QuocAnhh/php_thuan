<?php
require_once __DIR__ . '/../config/config.php';

echo "<h1>👥 Users Check</h1>";

// Check current users
$query = "SELECT id, name, email, is_admin FROM users ORDER BY id";
$result = mysqli_query($conn, $query);

echo "<h2>📋 Current Users:</h2>";
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";

$has_student = false;
while ($user = mysqli_fetch_assoc($result)) {
    $role = $user['is_admin'] ? 'Admin' : 'Student';
    if (!$user['is_admin']) $has_student = true;
    
    echo "<tr>";
    echo "<td>" . $user['id'] . "</td>";
    echo "<td>" . htmlspecialchars($user['name']) . "</td>";
    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
    echo "<td><strong>" . $role . "</strong></td>";
    echo "</tr>";
}
echo "</table>";

// If no student user exists, create one
if (!$has_student) {
    echo "<h2>➕ Creating Student User...</h2>";
    
    $student_name = "Test Student User";
    $student_email = "student@example.com";
    $student_password = password_hash("password", PASSWORD_DEFAULT);
    
    $insert_query = "INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, 0)";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "sss", $student_name, $student_email, $student_password);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<p style='color: green;'>✅ Student user created successfully!</p>";
        echo "<p><strong>Email:</strong> student@example.com</p>";
        echo "<p><strong>Password:</strong> password</p>";
    } else {
        echo "<p style='color: red;'>❌ Error creating student user: " . mysqli_error($conn) . "</p>";
    }
}

echo "<h2>🧪 Quick Tests:</h2>";
echo "<p><a href='quick_test.php'>⚡ Quick Test Page</a></p>";
echo "<p><a href='debug_login.php'>🐛 Debug Login</a></p>";
?> 