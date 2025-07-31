<?php
ini_set('session.cookie_lifetime', 0);
ini_set('session.cookie_path', '/');
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'backend_web_db');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
$base_path = dirname($_SERVER['SCRIPT_NAME']);
$base_path = str_replace('\\', '/', $base_path);
if (basename($base_path) === 'public') {
    $base_path = dirname($base_path);
}
if ($base_path === '/' || $base_path === '.') {
    $base_path = '';
}
define('BASE_PATH', $base_path);
define('ROOT_PATH', dirname(__DIR__));
function base_url($path = '') {
    $path = ltrim($path, '/');
    return BASE_PATH . '/' . $path;
} 