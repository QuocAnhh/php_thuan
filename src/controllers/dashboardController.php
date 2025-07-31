<?php
session_start();

function show_dashboard() {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }

    require_once '../public/dashboard.php';
} 