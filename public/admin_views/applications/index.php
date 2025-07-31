<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Check if accessed directly (not from controller)
if (!isset($applications)) {
    // This means the view was accessed directly, redirect through routing
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '/public/admin') !== false) {
        // Direct access, redirect to proper route
        header('Location: ' . base_url('admin/applications'));
        exit();
    }
    // If not direct access but still no $applications, show error
    die('Error: This page must be accessed through the proper route.');
}
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) die('Unauthorized');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Applications</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-pending { color: #ffc107; }
        .status-approved { color: #28a745; }
        .status-rejected { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage All Applications</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Applicant Name</th>
                    <th>Applicant Email</th>
                    <th>Submitted At</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $app): ?>
                <tr>
                    <td><?php echo htmlspecialchars($app['id']); ?></td>
                    <td><?php echo htmlspecialchars($app['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($app['user_email']); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($app['created_at'])); ?></td>
                    <td>
                        <strong class="status-<?php echo strtolower(htmlspecialchars($app['status'])); ?>">
                            <?php echo strtoupper(htmlspecialchars($app['status'])); ?>
                        </strong>
                    </td>
                    <td>
                        <a href="<?php echo base_url('admin/applications/show?id=' . $app['id']); ?>">View Details</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <a href="<?php echo base_url('dashboard'); ?>">Back to Dashboard</a>
    </div>
</body>
</html> 