<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
function show_register_form() {
    require_once '../public/auth/register.php';
}
function show_login_form() {
    require_once '../public/auth/login.php';
}
function handle_register() {
    global $conn;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($name) || empty($email) || empty($password)) {
        die("Please fill all required fields.");
    }
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        die("Email already exists.");
    }
    mysqli_stmt_close($stmt);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: /login");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}
function handle_login() {
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($email) || empty($password)) {
        die("Please fill all required fields.");
    }
    $stmt = mysqli_prepare($conn, "SELECT id, name, password, is_admin FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: /dashboard");
            exit();
        } else {
            die("Invalid password.");
        }
    } else {
        die("No user found with that email.");
    }
    mysqli_stmt_close($stmt);
}
function handle_logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: /login');
    exit();
} 