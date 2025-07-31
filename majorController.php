<?php
function majors_index() {
    global $conn;
    error_log("MAJORS_INDEX - Session ID: " . session_id() . ", User ID: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'none') . ", Is Admin: " . (isset($_SESSION['is_admin']) ? ($_SESSION['is_admin'] ? 'true' : 'false') : 'none'));
    if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
        error_log("MAJORS_INDEX - Access denied, redirecting to login");
        header('Location: ' . base_url('login'));
        exit();
    }
    $query = "SELECT * FROM majors ORDER BY code";
    $result = mysqli_query($conn, $query);
    if ($result === false) {
        die("<p style='color:red'>SQL Query Failed: " . mysqli_error($conn) . "</p>");
    }
    $majors = mysqli_fetch_all($result, MYSQLI_ASSOC);
    include ROOT_PATH . '/public/majors_views/index.php';
}
function majors_create_form() {
    global $conn;
    if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
        header('Location: ' . base_url('login'));
        exit();
    }
    include ROOT_PATH . '/public/majors_views/create.php';
}
function majors_store() {
    global $conn;
    if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $code = $_POST['code'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $query = "INSERT INTO majors (code, name, description) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $code, $name, $description);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: ' . base_url('majors'));
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
function majors_edit_form() {
    global $conn;
    if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $id = $_GET['id'];
    $query = "SELECT * FROM majors WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $major = mysqli_fetch_assoc($result);
    include ROOT_PATH . '/public/majors_views/edit.php';
}
function majors_update() {
    global $conn;
    if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $id = $_POST['id'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $query = "UPDATE majors SET code = ?, name = ?, description = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $code, $name, $description, $id);
    mysqli_stmt_execute($stmt);
    header('Location: ' . base_url('majors'));
    exit();
}
function majors_delete() {
    global $conn;
    if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $id = $_GET['id'];
    $query = "DELETE FROM majors WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    header('Location: ' . base_url('majors'));
    exit();
} 