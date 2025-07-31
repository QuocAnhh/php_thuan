<?php
session_start();
require_once __DIR__ . '/../config/config.php';
function list_majors() {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM majors");
    $majors = mysqli_fetch_all($result, MYSQLI_ASSOC);
    require_once '../public/majors/index.php';
}
function show_create_major_form() {
    require_once '../public/majors/create.php';
}
function handle_create_major() {
}
function show_edit_major_form() {
}
function handle_update_major() {
}
function handle_delete_major() {
} 