<?php
function applications_create_form() {
    global $conn;
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $query = "SELECT id, code, name FROM majors ORDER BY code";
    $result = mysqli_query($conn, $query);
    $majors = mysqli_fetch_all($result, MYSQLI_ASSOC);
    include ROOT_PATH . '/public/applications/create.php';
}
function applications_store() {
    global $conn;
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    mysqli_begin_transaction($conn);
    try {
        $user_id = $_SESSION['user_id'];
        $app_query = "INSERT INTO applications (user_id, status) VALUES (?, 'pending')";
        $stmt_app = mysqli_prepare($conn, $app_query);
        mysqli_stmt_bind_param($stmt_app, "i", $user_id);
        mysqli_stmt_execute($stmt_app);
        $application_id = mysqli_insert_id($conn);
        $aspirations = $_POST['aspirations'];
        $aspiration_query = "INSERT INTO aspirations (application_id, major_id, priority) VALUES (?, ?, ?)";
        $stmt_asp = mysqli_prepare($conn, $aspiration_query);
        foreach ($aspirations as $asp) {
            mysqli_stmt_bind_param($stmt_asp, "iii", $application_id, $asp['major_id'], $asp['priority']);
            mysqli_stmt_execute($stmt_asp);
        }
        $upload_dir = ROOT_PATH . '/public/uploads/applications/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $doc_query = "INSERT INTO application_documents (application_id, document_type, file_path) VALUES (?, ?, ?)";
        $stmt_doc = mysqli_prepare($conn, $doc_query);
        foreach ($_FILES['documents']['name'] as $type => $name) {
            if ($_FILES['documents']['error'][$type] == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['documents']['tmp_name'][$type];
                $file_extension = pathinfo($name, PATHINFO_EXTENSION);
                $new_filename = $application_id . '_' . $type . '_' . time() . '.' . $file_extension;
                $file_path = $upload_dir . $new_filename;
                move_uploaded_file($tmp_name, $file_path);
                $relative_path = 'uploads/applications/' . $new_filename;
                mysqli_stmt_bind_param($stmt_doc, "iss", $application_id, $type, $relative_path);
                mysqli_stmt_execute($stmt_doc);
            }
        }
        mysqli_commit($conn);
        header('Location: ' . base_url('dashboard'));
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Failed to submit application: " . $e->getMessage();
    }
}
function applications_show() {
    global $conn;
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $application_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $query = "SELECT a.*, u.name as user_name, u.email as user_email FROM applications a JOIN users u ON a.user_id = u.id WHERE a.id = ? AND (a.user_id = ? OR ?)";
    $stmt = mysqli_prepare($conn, $query);
    $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
    mysqli_stmt_bind_param($stmt, "iii", $application_id, $user_id, $is_admin);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $application = mysqli_fetch_assoc($result);
    if (!$application) {
        die("Application not found or you don't have permission to view it.");
    }
    $asp_query = "SELECT a.priority, m.name as major_name, m.code as major_code FROM aspirations a JOIN majors m ON a.major_id = m.id WHERE a.application_id = ? ORDER BY a.priority";
    $stmt_asp = mysqli_prepare($conn, $asp_query);
    mysqli_stmt_bind_param($stmt_asp, "i", $application_id);
    mysqli_stmt_execute($stmt_asp);
    $aspirations = mysqli_fetch_all(mysqli_stmt_get_result($stmt_asp), MYSQLI_ASSOC);
    $doc_query = "SELECT * FROM application_documents WHERE application_id = ?";
    $stmt_doc = mysqli_prepare($conn, $doc_query);
    mysqli_stmt_bind_param($stmt_doc, "i", $application_id);
    mysqli_stmt_execute($stmt_doc);
    $documents = mysqli_fetch_all(mysqli_stmt_get_result($stmt_doc), MYSQLI_ASSOC);
    include ROOT_PATH . '/public/applications/show.php';
}
function handle_my_application() {
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
    if ($application = mysqli_fetch_assoc($result)) {
        header('Location: ' . base_url('application/show?id=' . $application['id']));
        exit();
    } else {
        header('Location: ' . base_url('application/create'));
        exit();
    }
} 
function majors_info() {
    global $conn;
    $query = "SELECT code, name, description FROM majors ORDER BY code";
    $result = mysqli_query($conn, $query);
    $majors = mysqli_fetch_all($result, MYSQLI_ASSOC);
    include ROOT_PATH . '/public/student_views/majors_info.php';
}
function admission_results() {
    global $conn;
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $query = "SELECT a.*, u.name as user_name FROM applications a 
              JOIN users u ON a.user_id = u.id 
              WHERE a.user_id = ? ORDER BY a.created_at DESC";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $applications = mysqli_fetch_all($result, MYSQLI_ASSOC);
    include ROOT_PATH . '/public/student_views/admission_results.php';
}
function show_profile() {
    global $conn;
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    include ROOT_PATH . '/public/student_views/profile.php';
}
function update_profile() {
    global $conn;
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        header('Location: ' . base_url('profile?success=1'));
    } else {
        header('Location: ' . base_url('profile?error=1'));
    }
    exit();
}
function show_change_password() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    include ROOT_PATH . '/public/student_views/change_password.php';
}
function handle_change_password() {
    global $conn;
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login'));
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    if ($new_password !== $confirm_password) {
        header('Location: ' . base_url('change-password?error=mismatch'));
        exit();
    }
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    if (!password_verify($current_password, $user['password'])) {
        header('Location: ' . base_url('change-password?error=current'));
        exit();
    }
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_query = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "si", $hashed_password, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: ' . base_url('change-password?success=1'));
    } else {
        header('Location: ' . base_url('change-password?error=update'));
    }
    exit();
} 