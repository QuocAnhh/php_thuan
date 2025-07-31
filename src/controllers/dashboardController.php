<?php
session_start();
function show_dashboard() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }
    require_once '../public/dashboard.php';
} 