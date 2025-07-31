<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .password-form {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 2rem;
            margin: 1rem 0;
            max-width: 500px;
            margin: 1rem auto;
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
        .security-tips {
            background: #e7f3ff;
            border: 1px solid #b8daff;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center; padding: 2rem 0;">
            <h1>🔒 Đổi mật khẩu</h1>
            <p>Cập nhật mật khẩu để bảo vệ tài khoản của bạn</p>
        </div>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                ✅ Mật khẩu đã được thay đổi thành công!
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php
                $error_messages = [
                    'mismatch' => '❌ Mật khẩu mới và xác nhận mật khẩu không khớp.',
                    'current' => '❌ Mật khẩu hiện tại không đúng.',
                    'update' => '❌ Có lỗi xảy ra khi cập nhật mật khẩu. Vui lòng thử lại.'
                ];
                echo $error_messages[$_GET['error']] ?? '❌ Có lỗi xảy ra.';
                ?>
            </div>
        <?php endif; ?>
        <div class="password-form">
            <form method="POST" action="<?php echo base_url('change-password'); ?>" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="current_password">Mật khẩu hiện tại:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới:</label>
                    <input type="password" id="new_password" name="new_password" required minlength="6">
                    <small style="color: #666;">Tối thiểu 6 ký tự</small>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu mới:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                </div>
                <div class="form-group" style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">🔑 Đổi mật khẩu</button>
                    <a href="<?php echo base_url('profile'); ?>" class="btn btn-secondary">🔙 Quay lại</a>
                </div>
            </form>
        </div>
        <div class="security-tips">
            <h3>💡 Mẹo bảo mật</h3>
            <ul>
                <li>Sử dụng mật khẩu dài ít nhất 8 ký tự</li>
                <li>Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                <li>Không sử dụng thông tin cá nhân dễ đoán</li>
                <li>Thay đổi mật khẩu định kỳ</li>
                <li>Không chia sẻ mật khẩu với người khác</li>
            </ul>
        </div>
        <div style="text-align: center; padding: 2rem 0;">
            <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-secondary">🏠 Về Dashboard</a>
        </div>
    </div>
    <script>
        function validateForm() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            if (newPassword !== confirmPassword) {
                alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
                return false;
            }
            if (newPassword.length < 6) {
                alert('Mật khẩu mới phải có ít nhất 6 ký tự!');
                return false;
            }
            return true;
        }
    </script>
</body>
</html> 