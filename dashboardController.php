<?php
function show_dashboard() {
    header_remove("Access-Control-Allow-Origin");
    header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
    header("Access-Control-Allow-Credentials: true");

    global $conn;
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $query = "SELECT id FROM applications WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $application = mysqli_fetch_assoc($result);
    include ROOT_PATH . '/public/dashboard.php';
} 