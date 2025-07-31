<?php
// Simplified session configuration
ini_set('session.cookie_lifetime', 0);
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

// Database configuration
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'backend_web_db');

// Establish database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

// --- Base URL Configuration ---
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$base_path = str_replace('\\', '/', $base_path);
// If the script is in a subdirectory of public, we might need to go up
// This logic assumes index.php is in /public/
if (basename($base_path) === 'public') {
    $base_path = dirname($base_path);
}
if ($base_path === '/' || $base_path === '.') {
    $base_path = '';
}
define('BASE_PATH', $base_path);
define('ROOT_PATH', dirname(__DIR__)); // Defines the absolute path to the project root

/**
 * Generates a full URL relative to the project's base path.
 * @param string $path The path to append to the base URL.
 * @return string The full URL.
 */
function base_url($path = '') {
    // Remove leading/trailing slashes from path to avoid double slashes
    $path = ltrim($path, '/');
    return BASE_PATH . '/' . $path;
} 