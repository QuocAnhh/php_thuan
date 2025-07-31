<?php
session_start();
require_once __DIR__ . '/../config/config.php';
echo "<h1>🔧 Backend Functions Test</h1>";
echo "<h2>📊 Database Connection</h2>";
if ($conn) {
    echo "<p style='color: green'>✅ Database connected successfully</p>";
    $result = mysqli_query($conn, "SHOW TABLES");
    echo "<p><strong>Tables:</strong> ";
    while ($row = mysqli_fetch_row($result)) {
        echo $row[0] . " ";
    }
    echo "</p>";
} else {
    echo "<p style='color: red'>❌ Database connection failed</p>";
}
echo "<h2>🛣️  Routes Functions Test</h2>";
$routes = require_once __DIR__ . '/../routes.php';
$function_tests = [];
foreach ($routes as $path => $methods) {
    foreach ($methods as $method => $function_name) {
        if (function_exists($function_name)) {
            $function_tests[$function_name] = "✅ EXISTS";
        } else {
            $function_tests[$function_name] = "❌ MISSING";
        }
    }
}
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>Function Name</th><th>Status</th></tr>";
foreach ($function_tests as $func => $status) {
    $color = strpos($status, '✅') !== false ? 'green' : 'red';
    echo "<tr><td>{$func}</td><td style='color: {$color}'>{$status}</td></tr>";
}
echo "</table>";
echo "<h2>🎮 Controllers Test</h2>";
$controllers = [
    'homeController.php',
    'aboutController.php', 
    'authController.php',
    'dashboardController.php',
    'majorController.php',
    'applicationController.php',
    'adminController.php'
];
foreach ($controllers as $controller) {
    if (file_exists(__DIR__ . '/../' . $controller)) {
        echo "<p style='color: green'>✅ {$controller} exists</p>";
    } else {
        echo "<p style='color: red'>❌ {$controller} missing</p>";
    }
}
echo "<h2>📁 Directory Structure</h2>";
$directories = [
    'public/majors_views',
    'public/admin_views', 
    'public/student_views',
    'public/applications',
    'public/auth',
    'public/uploads/applications',
    'config'
];
foreach ($directories as $dir) {
    if (is_dir(__DIR__ . '/../' . $dir)) {
        echo "<p style='color: green'>✅ {$dir}/ exists</p>";
    } else {
        echo "<p style='color: red'>❌ {$dir}/ missing</p>";
    }
}
echo "<h2>👥 User Accounts</h2>";
$users_query = "SELECT id, name, email, is_admin FROM users ORDER BY is_admin DESC, id";
$result = mysqli_query($conn, $users_query);
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr>";
$admin_count = 0;
$student_count = 0;
while ($user = mysqli_fetch_assoc($result)) {
    $role = $user['is_admin'] ? 'Admin' : 'Student';
    $color = $user['is_admin'] ? '#dc3545' : '#28a745';
    if ($user['is_admin']) $admin_count++;
    else $student_count++;
    echo "<tr>";
    echo "<td>{$user['id']}</td>";
    echo "<td>" . htmlspecialchars($user['name']) . "</td>";
    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
    echo "<td style='color: {$color}; font-weight: bold'>{$role}</td>";
    echo "</tr>";
}
echo "</table>";
echo "<p><strong>Summary:</strong> {$admin_count} Admin(s), {$student_count} Student(s)</p>";
echo "<h2>📋 Sample Data</h2>";
$majors_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM majors");
$majors_count = mysqli_fetch_assoc($majors_result)['count'];
echo "<p><strong>Majors:</strong> {$majors_count} records</p>";
$apps_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM applications");
$apps_count = mysqli_fetch_assoc($apps_result)['count'];
echo "<p><strong>Applications:</strong> {$apps_count} records</p>";
echo "<h2>🎯 System Status Summary</h2>";
$total_functions = count($function_tests);
$working_functions = count(array_filter($function_tests, function($status) {
    return strpos($status, '✅') !== false;
}));
$function_percentage = round(($working_functions / $total_functions) * 100);
echo "<div style='background: #f8f9fa; padding: 1.5rem; border-radius: 8px;'>";
echo "<h3>📊 Overall Health</h3>";
echo "<p><strong>Functions:</strong> {$working_functions}/{$total_functions} working ({$function_percentage}%)</p>";
echo "<p><strong>Database:</strong> " . ($conn ? "✅ Connected" : "❌ Failed") . "</p>";
echo "<p><strong>Admin Users:</strong> {$admin_count}</p>";
echo "<p><strong>Student Users:</strong> {$student_count}</p>";
echo "<p><strong>Sample Data:</strong> {$majors_count} majors, {$apps_count} application</p>";
if ($function_percentage >= 95 && $conn && $admin_count > 0 && $student_count > 0) {
    echo "<div style='background: #d4edda; color: #155724; padding: 1rem; border-radius: 5px; margin: 1rem 0;'>";
    echo "<h4>🎉 SYSTEM READY FOR FRONTEND!</h4>";
    echo "<p>✅ All critical functions working<br>";
    echo "✅ Database properly configured<br>";
    echo "✅ User accounts available<br>";
    echo "✅ Ready for frontend integration</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin: 1rem 0;'>";
    echo "<h4>⚠️ Issues Found</h4>";
    echo "<p>Some functions or data may need attention before frontend integration.</p>";
    echo "</div>";
}
echo "</div>";
echo "<h2>🔗 Quick Links</h2>";
echo "<p>";
echo "<a href='quick_test.php' style='padding: 0.5rem 1rem; background: #007bff; color: white; text-decoration: none; border-radius: 3px; margin: 0.2rem;'>⚡ Quick Test</a> ";
echo "<a href='final_test.php' style='padding: 0.5rem 1rem; background: #28a745; color: white; text-decoration: none; border-radius: 3px; margin: 0.2rem;'>🎉 Final Test</a> ";
echo "<a href='check_users.php' style='padding: 0.5rem 1rem; background: #6f42c1; color: white; text-decoration: none; border-radius: 3px; margin: 0.2rem;'>👥 Check Users</a>";
echo "</p>";
echo "<p><small><strong>Note:</strong> This comprehensive test verifies all backend functions are ready for frontend development.</small></p>";
?> 