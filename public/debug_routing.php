<?php
session_start();
require_once __DIR__ . '/../config/config.php';

echo "<h1>🛣️ Routing Debug</h1>";

echo "<h2>📍 Server Variables:</h2>";
echo "<ul>";
echo "<li><strong>REQUEST_URI:</strong> " . $_SERVER['REQUEST_URI'] . "</li>";
echo "<li><strong>SCRIPT_NAME:</strong> " . $_SERVER['SCRIPT_NAME'] . "</li>";
echo "<li><strong>BASE_PATH:</strong> " . BASE_PATH . "</li>";
echo "</ul>";

echo "<h2>🛤️ Route Processing:</h2>";
$request_uri = strtok($_SERVER['REQUEST_URI'], '?');
$request_uri = substr($request_uri, strlen(BASE_PATH));
if (empty($request_uri)) {
    $request_uri = '/';
}

echo "<p><strong>Processed request_uri:</strong> " . htmlspecialchars($request_uri) . "</p>";

// Load routes
$routes = require_once __DIR__ . '/../routes.php';

echo "<h2>📋 Available Routes:</h2>";
echo "<ul>";
foreach ($routes as $route => $methods) {
    foreach ($methods as $method => $callback) {
        echo "<li><strong>$method $route</strong> → $callback</li>";
    }
}
echo "</ul>";

echo "<h2>🎯 Route Match Test:</h2>";
$method = $_SERVER['REQUEST_METHOD'];
echo "<p><strong>Looking for:</strong> $method $request_uri</p>";

if (array_key_exists($request_uri, $routes) && array_key_exists($method, $routes[$request_uri])) {
    $callback = $routes[$request_uri][$method];
    echo "<p>✅ <strong>Route FOUND:</strong> $callback</p>";
    
    if (function_exists($callback)) {
        echo "<p>✅ <strong>Function EXISTS:</strong> $callback</p>";
        
        // Test call the function
        if (isset($_SESSION['user_id']) && $_SESSION['is_admin']) {
            echo "<p>🧪 <strong>Testing function call...</strong></p>";
            try {
                ob_start();
                call_user_func($callback);
                $output = ob_get_clean();
                
                if (strlen($output) > 100) {
                    echo "<p>✅ <strong>Function returned content:</strong> " . strlen($output) . " chars</p>";
                } else {
                    echo "<p>❌ <strong>Function returned short content:</strong> " . htmlspecialchars($output) . "</p>";
                }
            } catch (Exception $e) {
                echo "<p>❌ <strong>Function error:</strong> " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>⚠️ <strong>Not logged in as admin - cannot test function</strong></p>";
        }
    } else {
        echo "<p>❌ <strong>Function NOT FOUND:</strong> $callback</p>";
    }
} else {
    echo "<p>❌ <strong>Route NOT FOUND</strong></p>";
    echo "<p>Available routes for $method:</p><ul>";
    foreach ($routes as $route => $methods) {
        if (isset($methods[$method])) {
            echo "<li>$route</li>";
        }
    }
    echo "</ul>";
}

echo "<hr>";
echo "<p><a href='" . base_url('test.php') . "'>← Back to Test Page</a></p>";
?> 