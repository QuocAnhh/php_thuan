<?php

function admin_applications_index() {
    global $conn;
    
    // DEBUG: Log session info
    error_log("ADMIN_APPS_INDEX - Session ID: " . session_id() . ", User ID: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'none') . ", Is Admin: " . (isset($_SESSION['is_admin']) ? ($_SESSION['is_admin'] ? 'true' : 'false') : 'none'));
    
    if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
        error_log("ADMIN_APPS_INDEX - Access denied, redirecting to login");
        header('Location: ' . base_url('login'));
        exit();
    }

    $query = "SELECT a.*, u.email as user_email, u.name as user_name FROM applications a JOIN users u ON a.user_id = u.id ORDER BY a.created_at DESC";
    $result = mysqli_query($conn, $query);
    $applications = mysqli_fetch_all($result, MYSQLI_ASSOC);

    include ROOT_PATH . '/public/admin_views/applications/index.php';
}

function admin_applications_show() {
    global $conn;
    if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
        header('Location: ' . base_url('login'));
        exit();
    }

    $id = $_GET['id'];
    // Fetch application details
    $query_app = "SELECT a.*, u.email as user_email, u.name as user_name FROM applications a JOIN users u ON a.user_id = u.id WHERE a.id = ?";
    $stmt_app = mysqli_prepare($conn, $query_app);
    mysqli_stmt_bind_param($stmt_app, "i", $id);
    mysqli_stmt_execute($stmt_app);
    $application = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_app));
    
    // Fetch aspirations
    $query_asp = "SELECT m.code as major_code, m.name as major_name, a.priority FROM aspirations a JOIN majors m ON a.major_id = m.id WHERE a.application_id = ? ORDER BY a.priority";
    $stmt_asp = mysqli_prepare($conn, $query_asp);
    mysqli_stmt_bind_param($stmt_asp, "i", $id);
    mysqli_stmt_execute($stmt_asp);
    $aspirations = mysqli_fetch_all(mysqli_stmt_get_result($stmt_asp), MYSQLI_ASSOC);

    // Fetch documents
    $query_doc = "SELECT * FROM application_documents WHERE application_id = ?";
    $stmt_doc = mysqli_prepare($conn, $query_doc);
    mysqli_stmt_bind_param($stmt_doc, "i", $id);
    mysqli_stmt_execute($stmt_doc);
    $documents = mysqli_fetch_all(mysqli_stmt_get_result($stmt_doc), MYSQLI_ASSOC);

    include ROOT_PATH . '/public/admin_views/applications/show.php';
}


function admin_applications_update_status() {
    global $conn;
    if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
        header('Location: ' . base_url('login'));
        exit();
    }
    
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = "UPDATE applications SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    mysqli_stmt_execute($stmt);

    header('Location: ' . base_url('admin/applications/show?id=' . $id));
    exit();
} 