<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Hệ thống xét tuyển</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
</head>
<body>
    <div class="container">
        <h1>Chào mừng đến với Hệ thống xét tuyển</h1>
        <p>Hệ thống quản lý hồ sơ xét tuyển đại học online</p>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <h3>Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h3>
            <p><a href="<?php echo base_url('dashboard'); ?>">Vào Dashboard</a></p>
        <?php else: ?>
            <div style="margin-top: 2rem;">
                <h3>Đăng nhập / Đăng ký</h3>
                <p>
                    <a href="<?php echo base_url('login'); ?>">Đăng nhập</a> | 
                    <a href="<?php echo base_url('register'); ?>">Đăng ký</a>
                </p>
            </div>
        <?php endif; ?>
        
        <hr style="margin: 2rem 0;">
        <p><a href="<?php echo base_url('about'); ?>">Về chúng tôi</a></p>
    </div>
</body>
</html> 