<?php
// Force PHP to display errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include config first (which has session settings)
require_once __DIR__ . '/../config/config.php';

// Start session AFTER config
session_start();

// DEBUG: Log session info (remove in production)
error_log("INDEX.PHP - Session ID: " . session_id() . ", User ID: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'none') . ", Is Admin: " . (isset($_SESSION['is_admin']) ? ($_SESSION['is_admin'] ? 'true' : 'false') : 'none'));

// Load the routes using an absolute path
$routes = require_once __DIR__ . '/../routes.php';

// --- SIMPLE ROUTING ---
$request_uri = strtok($_SERVER['REQUEST_URI'], '?');
$request_uri = substr($request_uri, strlen(BASE_PATH)); // Remove the base path
if (empty($request_uri)) {
    $request_uri = '/'; // Default to root
}

$method = $_SERVER['REQUEST_METHOD'];

// Serve static files (CSS, JS)
if (preg_match('/^\/(css|js)\//', $request_uri)) {
    return false;
}

// Route matching logic
if (array_key_exists($request_uri, $routes) && array_key_exists($method, $routes[$request_uri])) {
    $callback = $routes[$request_uri][$method];
    if (function_exists($callback)) {
         call_user_func($callback);
    } else {
        // This case should ideally not happen if routes are defined correctly
        http_response_code(500);
        echo "<h1>500 Internal Server Error</h1>";
        echo "<p>Error: Controller function '<strong>" . htmlspecialchars($callback) . "</strong>' not found.</p>";
    }
} else {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    echo "<p>The page you requested could not be found.</p>";
    echo '<a href="' . base_url() . '">Go to Homepage</a>';
}
?>
