<?php
session_start();
require_once __DIR__ . '/../config/config.php';

// Function to get all majors
function list_majors() {
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM majors");
    $majors = mysqli_fetch_all($result, MYSQLI_ASSOC);
    require_once '../public/majors/index.php';
}

// Function to show form to create a new major
function show_create_major_form() {
    require_once '../public/majors/create.php';
}

// Function to handle creation of a new major
function handle_create_major() {
    // Logic to create major
}

// Function to show form to edit a major
function show_edit_major_form() {
    // Logic to show edit form
}

// Function to handle update of a major
function handle_update_major() {
    // Logic to update major
}

// Function to handle deletion of a major
function handle_delete_major() {
    // Logic to delete major
} 