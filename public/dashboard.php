<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . base_url('login'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo $_SESSION['is_admin'] ? 'Admin' : 'Student'; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .menu-section { 
            background: #f8f9fa; 
            padding: 1.5rem; 
            margin: 1rem 0; 
            border-radius: 8px; 
            border-left: 4px solid #007bff;
        }
        .admin-section { border-left-color: #dc3545; }
        .student-section { border-left-color: #28a745; }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .menu-item {
            display: block;
            padding: 1rem;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #495057;
            transition: all 0.3s;
            text-align: center;
        }
        .menu-item:hover {
            background: #007bff;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .menu-item.admin:hover { background: #dc3545; }
        .menu-item.student:hover { background: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center; padding: 2rem 0;">
            <h1>🏛️ Hệ thống Tuyển sinh</h1>
            <h2>Chào mừng, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
            <p><strong>Vai trò:</strong> <span style="color: <?php echo $_SESSION['is_admin'] ? '#dc3545' : '#28a745'; ?>;"><?php echo $_SESSION['is_admin'] ? '👨‍💼 Quản trị viên' : '👨‍🎓 Sinh viên'; ?></span></p>
        </div>
        
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
        <!-- ADMIN MENU -->
        <div class="menu-section admin-section">
            <h3>👨‍💼 Chức năng Quản trị</h3>
            <div class="menu-grid">
                <a href="<?php echo base_url('majors'); ?>" class="menu-item admin">
                    <h4>📚 Quản lý Ngành học</h4>
                    <p>Thêm, sửa, xóa các ngành đào tạo</p>
                </a>
                <a href="<?php echo base_url('admin/applications'); ?>" class="menu-item admin">
                    <h4>📄 Quản lý Hồ sơ</h4>
                    <p>Xem và duyệt hồ sơ tuyển sinh</p>
                </a>
                <a href="<?php echo base_url('users'); ?>" class="menu-item admin">
                    <h4>👥 Quản lý Users</h4>
                    <p>Quản lý tài khoản người dùng</p>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- STUDENT MENU -->
        <div class="menu-section student-section">
            <h3>👨‍🎓 Chức năng Sinh viên</h3>
            <div class="menu-grid">
                <a href="<?php echo base_url('my-application'); ?>" class="menu-item student">
                    <h4>📝 Hồ sơ của tôi</h4>
                    <p>Xem trạng thái và nộp hồ sơ tuyển sinh</p>
                </a>
                <a href="<?php echo base_url('applications/create'); ?>" class="menu-item student">
                    <h4>➕ Nộp hồ sơ mới</h4>
                    <p>Tạo hồ sơ tuyển sinh mới</p>
                </a>
                <a href="<?php echo base_url('majors-info'); ?>" class="menu-item student">
                    <h4>📖 Thông tin Ngành</h4>
                    <p>Xem danh sách và thông tin các ngành</p>
                </a>
                <a href="<?php echo base_url('admission-results'); ?>" class="menu-item student">
                    <h4>🎯 Kết quả Tuyển sinh</h4>
                    <p>Tra cứu kết quả tuyển sinh</p>
                </a>
            </div>
        </div>

        <!-- COMMON SECTION -->
        <div class="menu-section">
            <h3>⚙️ Chức năng chung</h3>
            <div class="menu-grid">
                <a href="<?php echo base_url('profile'); ?>" class="menu-item">
                    <h4>👤 Thông tin cá nhân</h4>
                    <p>Cập nhật thông tin tài khoản</p>
                </a>
                <a href="<?php echo base_url('change-password'); ?>" class="menu-item">
                    <h4>🔒 Đổi mật khẩu</h4>
                    <p>Thay đổi mật khẩu đăng nhập</p>
                </a>
            </div>
        </div>
        
        <div style="text-align: center; padding: 2rem 0;">
            <a href="<?php echo base_url('logout'); ?>" style="display: inline-block; padding: 0.75rem 2rem; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">🚪 Đăng xuất</a>
        </div>
    </div>
</body>
</html> 