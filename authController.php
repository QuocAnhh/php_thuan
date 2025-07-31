<?php
require_once __DIR__ . '/config/config.php';

function show_login_form() {
    include ROOT_PATH . '/public/auth/login.php';
}

function handle_login() {
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['is_admin'] = (bool)$user['is_admin'];
            
            // DEBUG: Log successful login
            error_log("LOGIN SUCCESS - User: " . $user['name'] . ", Session ID: " . session_id() . ", Is Admin: " . ($_SESSION['is_admin'] ? 'true' : 'false'));
            
            header('Location: ' . base_url('dashboard'));
            exit();
        }
    }
    
    header('Location: ' . base_url('login?error=1'));
    exit();
}

function show_register_form() {
    include ROOT_PATH . '/public/auth/register.php';
}

function handle_register() {
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    // Using email as name for simplicity, as per original structure
    mysqli_stmt_bind_param($stmt, "sss", $email, $email, $password_hash);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: ' . base_url('login'));
        exit();
    } else {
        header('Location: ' . base_url('register?error=1'));
        exit();
    }
}

function handle_logout() {
    session_destroy();
    header('Location: ' . base_url('login'));
    exit();
} 