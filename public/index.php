<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../config/config.php';
session_start();
error_log("Session ID: " . session_id() . ", User ID: " . ($_SESSION['user_id'] ?? 'none'));

$routes = require_once __DIR__ . '/../routes.php';

$request_uri = strtok($_SERVER['REQUEST_URI'], '?');
$request_uri = substr($request_uri, strlen(BASE_PATH));
if (empty($request_uri)) {
    $request_uri = '/';
}

$method = $_SERVER['REQUEST_METHOD'];

// Corrected preg_match for static files
if (preg_match('/^\/(css|js)\//', $request_uri)) {
    return false;
}

if (array_key_exists($request_uri, $routes) && array_key_exists($method, $routes[$request_uri])) {
    $callback = $routes[$request_uri][$method];
    if (function_exists($callback)) {
        call_user_func($callback);
    } else {
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
