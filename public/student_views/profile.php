<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .profile-form {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 2rem;
            margin: 1rem 0;
        }
        .form-group {
            margin: 1rem 0;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin: 1rem 0;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center; padding: 2rem 0;">
            <h1>👤 Thông tin cá nhân</h1>
            <p>Cập nhật thông tin tài khoản của bạn</p>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                ✅ Thông tin đã được cập nhật thành công!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                ❌ Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại.
            </div>
        <?php endif; ?>

        <div class="profile-form">
            <form method="POST" action="<?php echo base_url('profile'); ?>">
                <div class="form-group">
                    <label for="name">Họ và tên:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group" style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">💾 Lưu thay đổi</button>
                    <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-secondary">🏠 Về Dashboard</a>
                </div>
            </form>
        </div>

        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin: 2rem 0;">
            <h3>🔒 Bảo mật tài khoản</h3>
            <p>Để đảm bảo an toàn cho tài khoản, bạn nên thay đổi mật khẩu định kỳ.</p>
            <a href="<?php echo base_url('change-password'); ?>" class="btn btn-secondary">🔑 Đổi mật khẩu</a>
        </div>

        <div style="background: #e9ecef; padding: 1.5rem; border-radius: 8px; margin: 2rem 0;">
            <h3>📊 Thông tin tài khoản</h3>
            <p><strong>ID tài khoản:</strong> <?php echo $user['id']; ?></p>
            <p><strong>Vai trò:</strong> <?php echo $user['is_admin'] ? 'Quản trị viên' : 'Sinh viên'; ?></p>
            <p><strong>Ngày tạo:</strong> <?php echo isset($user['created_at']) ? date('d/m/Y H:i', strtotime($user['created_at'])) : 'Không có thông tin'; ?></p>
        </div>
    </div>
</body>
</html> 