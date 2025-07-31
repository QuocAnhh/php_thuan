<?php
session_start();
require_once __DIR__ . '/../config/config.php';
function handle_registration($conn) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (empty($name) || empty($email) || empty($password)) {
        die("Please fill all fields.");
    }
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        die("Email already exists.");
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    if ($stmt->execute()) {
        header("Location: /login?registration=success");
        exit();
    } else {
        die("Registration failed: " . $stmt->error);
    }
}
function handle_login($conn) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (empty($email) || empty($password)) {
        die("Please fill all fields.");
    }
    $stmt = $conn->prepare("SELECT id, name, password, is_admin FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
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
        die("User not found.");
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_uri = strtok($_SERVER['REQUEST_URI'], '?');
    if ($request_uri === '/register') {
        handle_registration($conn);
    } elseif ($request_uri === '/login') {
        handle_login($conn);
    }
} 