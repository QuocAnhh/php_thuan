<?php
require_once __DIR__ . '/config/config.php';
function show_login_form() {
    include ROOT_PATH . '/public/auth/login.php';
}
function handle_login() {
    header_remove("Access-Control-Allow-Origin");
    header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    global $conn;

    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    if (empty($email) || empty($password)) {
        http_response_code(400); 
        echo json_encode(['success' => false, 'message' => 'Email và mật khẩu không được để trống']);
        exit();
    }

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['is_admin'] = (bool)$user['is_admin'];

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Đăng nhập thành công',
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'is_admin' => (bool)$user['is_admin']
                ]
            ]);
            exit();
        }
    }

    // Đăng nhập thất bại, trả về response JSON lỗi
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'message' => 'Sai email hoặc mật khẩu']);
    exit();
}
function show_register_form() {
    include ROOT_PATH . '/public/auth/register.php';
}
function handle_register() {
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $email, $email, $password_hash);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: ' . base_url('login'));
        exit();
    } else {
        header('Location: ' . base_url('register?error=1'));
        exit();
    }
}
function handle_logout() {
    session_destroy();
    header('Location: ' . base_url('login'));
    exit();
} 