<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Ngành học</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .major-card { 
            background: white; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            padding: 1.5rem; 
            margin: 1rem 0; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .major-card:hover { box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .major-code { 
            background: #007bff; 
            color: white; 
            padding: 0.3rem 0.8rem; 
            border-radius: 4px; 
            font-weight: bold; 
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .major-name { color: #333; margin: 0.5rem 0; }
        .major-description { color: #666; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center; padding: 2rem 0;">
            <h1>📖 Thông tin Ngành học</h1>
            <p>Danh sách các ngành đào tạo tại trường</p>
        </div>

        <?php if (empty($majors)): ?>
            <div style="text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
                <h3>📋 Chưa có ngành học nào</h3>
                <p>Hiện tại chưa có thông tin về các ngành đào tạo.</p>
            </div>
        <?php else: ?>
            <div style="display: grid; gap: 1rem;">
                <?php foreach ($majors as $major): ?>
                    <div class="major-card">
                        <div class="major-code"><?php echo htmlspecialchars($major['code']); ?></div>
                        <h3 class="major-name"><?php echo htmlspecialchars($major['name']); ?></h3>
                        <div class="major-description">
                            <?php echo nl2br(htmlspecialchars($major['description'] ?: 'Chưa có mô tả chi tiết.')); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div style="text-align: center; padding: 2rem 0;">
            <a href="<?php echo base_url('dashboard'); ?>" style="display: inline-block; padding: 0.75rem 2rem; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 0.5rem;">🏠 Về Dashboard</a>
            <a href="<?php echo base_url('applications/create'); ?>" style="display: inline-block; padding: 0.75rem 2rem; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin: 0.5rem;">📝 Nộp hồ sơ</a>
        </div>
    </div>
</body>
</html> 