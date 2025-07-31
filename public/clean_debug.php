<?php
echo "<h1>🧹 Cleanup Debug Files</h1>";
$debug_files = [
    'admin_portal.php',
    'debug_admin.php', 
    'debug_routing.php',
    'test_session.php',
    'majors_direct.php',
    'admin_apps_direct.php'
];
$cleaned = 0;
$kept = [];
foreach ($debug_files as $file) {
    $file_path = __DIR__ . '/' . $file;
    if (file_exists($file_path)) {
        if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
            unlink($file_path);
            echo "<p style='color: green;'>✅ Deleted: {$file}</p>";
            $cleaned++;
        } else {
            $kept[] = $file;
            echo "<p style='color: orange;'>🔍 Found: {$file}</p>";
        }
    }
}
if (!isset($_GET['confirm'])) {
    echo "<div style='background: #fff3cd; padding: 1rem; border-radius: 5px; margin: 1rem 0;'>";
    echo "<h3>⚠️ Cleanup Preview</h3>";
    echo "<p>Found " . count($kept) . " debug files that can be cleaned up.</p>";
    echo "<p><strong>Files to be removed:</strong></p>";
    echo "<ul>";
    foreach ($kept as $file) {
        echo "<li>{$file}</li>";
    }
    echo "</ul>";
    echo "<p><a href='?confirm=yes' style='padding: 0.7rem 1.5rem; background: #dc3545; color: white; text-decoration: none; border-radius: 5px;'>🗑️ Confirm Cleanup</a>";
    echo " <a href='backend_test.php' style='padding: 0.7rem 1.5rem; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;'>🔙 Back to Test</a></p>";
    echo "</div>";
    echo "<div style='background: #d1ecf1; padding: 1rem; border-radius: 5px; margin: 1rem 0;'>";
    echo "<h3>📋 Files to Keep</h3>";
    echo "<p>These files are important for production and will be kept:</p>";
    echo "<ul>";
    $keep_files = [
        'index.php - Main router',
        'dashboard.php - User dashboard', 
        'backend_test.php - System testing',
        'final_test.php - Final system test',
        'quick_test.php - Quick functionality test',
        'check_users.php - User management'
    ];
    foreach ($keep_files as $file) {
        echo "<li>{$file}</li>";
    }
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div style='background: #d4edda; padding: 1rem; border-radius: 5px; margin: 1rem 0;'>";
    echo "<h3>🎉 Cleanup Complete!</h3>";
    echo "<p>Successfully cleaned up {$cleaned} debug files.</p>";
    echo "<p>The system is now clean and ready for frontend development.</p>";
    echo "<p><a href='final_test.php' style='padding: 0.7rem 1.5rem; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'>🎉 Run Final Test</a></p>";
    echo "</div>";
}
?> 