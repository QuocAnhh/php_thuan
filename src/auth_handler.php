<?php
session_start();

// Include the database connection
require_once __DIR__ . '/../config/config.php';


function handle_registration($conn) {
    // 1. Get data from $_POST
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 2. Basic Validation
    if (empty($name) || empty($email) || empty($password)) {
        die("Please fill all fields.");
    }

    // 3. Check if user already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        die("Email already exists.");
    }

    // 4. Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 5. Insert user into database
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
    // 1. Get data from $_POST
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 2. Basic Validation
    if (empty($email) || empty($password)) {
        die("Please fill all fields.");
    }

    // 3. Find user by email
    $stmt = $conn->prepare("SELECT id, name, password, is_admin FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // 4. Verify password
        if (password_verify($password, $user['password'])) {
            // 5. Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            header("Location: /dashboard"); // We will create dashboard soon
            exit();
        } else {
            die("Invalid password.");
        }
    } else {
        die("User not found.");
    }
}

// Route the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_uri = strtok($_SERVER['REQUEST_URI'], '?');
    if ($request_uri === '/register') {
        handle_registration($conn);
    } elseif ($request_uri === '/login') {
        handle_login($conn);
    }
} 