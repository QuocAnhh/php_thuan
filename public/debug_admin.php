<?php
session_start();
require_once __DIR__ . '/../config/config.php';

echo "<h1>🐛 Debug Admin Functions</h1>";

// Show current session
echo "<h2>📊 Current Session:</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Test routes manually
echo "<h2>🧪 Manual Route Testing:</h2>";

if (isset($_SESSION['user_id']) && $_SESSION['is_admin']) {
    echo "<p>✅ Admin session is valid. Testing routes...</p>";
    
    // Test majors route
    echo "<h3>Testing /majors route:</h3>";
    require_once __DIR__ . '/../majorController.php';
    
    try {
        echo "<p>Calling majors_index() function directly...</p>";
        ob_start();
        majors_index();
        $majors_output = ob_get_clean();
        
        if (strlen($majors_output) > 100) {
            echo "<p>✅ majors_index() returned content (" . strlen($majors_output) . " chars)</p>";
            echo "<details><summary>Show first 500 chars</summary><pre>" . htmlspecialchars(substr($majors_output, 0, 500)) . "...</pre></details>";
        } else {
            echo "<p>❌ majors_index() returned short/no content: " . htmlspecialchars($majors_output) . "</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Error in majors_index(): " . $e->getMessage() . "</p>";
    }
    
    // Test admin applications route
    echo "<h3>Testing /admin/applications route:</h3>";
    require_once __DIR__ . '/../adminController.php';
    
    try {
        echo "<p>Calling admin_applications_index() function directly...</p>";
        ob_start();
        admin_applications_index();
        $admin_output = ob_get_clean();
        
        if (strlen($admin_output) > 100) {
            echo "<p>✅ admin_applications_index() returned content (" . strlen($admin_output) . " chars)</p>";
            echo "<details><summary>Show first 500 chars</summary><pre>" . htmlspecialchars(substr($admin_output, 0, 500)) . "...</pre></details>";
        } else {
            echo "<p>❌ admin_applications_index() returned short/no content: " . htmlspecialchars($admin_output) . "</p>";
        }
    } catch (Exception $e) {
        echo "<p>❌ Error in admin_applications_index(): " . $e->getMessage() . "</p>";
    }
    
} else {
    echo "<p>❌ Not logged in as admin. Please login first.</p>";
    echo "<p><a href='" . base_url('login') . "'>Login as Admin</a></p>";
}

// Test URLs directly
echo "<h2>🔗 Direct URL Tests (click these):</h2>";
echo "<ul>";
echo "<li><a href='" . base_url('majors') . "' target='_blank'>📚 " . base_url('majors') . "</a></li>";
echo "<li><a href='" . base_url('admin/applications') . "' target='_blank'>📄 " . base_url('admin/applications') . "</a></li>";
echo "<li><a href='" . base_url('dashboard') . "' target='_blank'>📋 " . base_url('dashboard') . "</a></li>";
echo "</ul>";

echo "<hr>";
echo "<p><a href='" . base_url('test.php') . "'>← Back to Test Page</a></p>";
?> 