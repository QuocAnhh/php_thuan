<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả Tuyển sinh</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .result-card { 
            background: white; 
            border: 1px solid #ddd; 
            border-radius: 8px; 
            padding: 1.5rem; 
            margin: 1rem 0; 
        }
        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        .status-pending { background: #ffc107; color: #856404; }
        .status-approved { background: #28a745; color: white; }
        .status-rejected { background: #dc3545; color: white; }
        .status-processing { background: #17a2b8; color: white; }
        .info-row { 
            display: flex; 
            justify-content: space-between; 
            margin: 0.5rem 0; 
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child { border-bottom: none; }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: center; padding: 2rem 0;">
            <h1>🎯 Kết quả Tuyển sinh</h1>
            <p>Trạng thái hồ sơ tuyển sinh của bạn</p>
        </div>
        <?php if (empty($applications)): ?>
            <div style="text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 8px;">
                <h3>📋 Chưa có hồ sơ nào</h3>
                <p>Bạn chưa nộp hồ sơ tuyển sinh nào.</p>
                <a href="<?php echo base_url('applications/create'); ?>" style="display: inline-block; padding: 0.75rem 2rem; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-top: 1rem;">📝 Nộp hồ sơ ngay</a>
            </div>
        <?php else: ?>
            <?php foreach ($applications as $app): ?>
                <div class="result-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3>📄 Hồ sơ #<?php echo $app['id']; ?></h3>
                        <span class="status-badge status-<?php echo $app['status']; ?>">
                            <?php 
                            $status_text = [
                                'pending' => '⏳ Đang chờ',
                                'processing' => '🔄 Đang xử lý', 
                                'approved' => '✅ Được duyệt',
                                'rejected' => '❌ Bị từ chối'
                            ];
                            echo $status_text[$app['status']] ?? $app['status'];
                            ?>
                        </span>
                    </div>
                    <div class="info-row">
                        <strong>Ngày nộp:</strong>
                        <span><?php echo date('d/m/Y H:i', strtotime($app['created_at'])); ?></span>
                    </div>
                    <?php if ($app['updated_at'] && $app['updated_at'] != $app['created_at']): ?>
                    <div class="info-row">
                        <strong>Cập nhật lần cuối:</strong>
                        <span><?php echo date('d/m/Y H:i', strtotime($app['updated_at'])); ?></span>
                    </div>
                    <?php endif; ?>
                    <div style="margin-top: 1rem;">
                        <a href="<?php echo base_url('application/show?id=' . $app['id']); ?>" style="display: inline-block; padding: 0.5rem 1rem; background: #007bff; color: white; text-decoration: none; border-radius: 3px;">👁️ Xem chi tiết</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div style="text-align: center; padding: 2rem 0;">
            <a href="<?php echo base_url('dashboard'); ?>" style="display: inline-block; padding: 0.75rem 2rem; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;">🏠 Về Dashboard</a>
        </div>
    </div>
</body>
</html> 