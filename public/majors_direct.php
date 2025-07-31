<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../majorController.php';
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    die('<h1>❌ Access Denied</h1><p>Please <a href="' . base_url('login') . '">login as admin</a> first.</p>');
}
majors_index();
?> 