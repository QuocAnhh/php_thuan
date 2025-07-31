<?php
// session_start() removed from here, as it's called in index.php

function show_dashboard() {
    global $conn;
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    
    // Check if user has an application
    $user_id = $_SESSION['user_id'];
    $query = "SELECT id FROM applications WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $application = mysqli_fetch_assoc($result);

    include ROOT_PATH . '/public/dashboard.php';
} 