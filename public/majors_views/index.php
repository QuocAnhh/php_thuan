<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Check if accessed directly (not from controller)
if (!isset($majors)) {
    // This means the view was accessed directly, redirect through routing
    // Check if we're already in a routing context by looking at the URL
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '/public/majors') !== false) {
        // Direct access, redirect to proper route
        header('Location: ' . base_url('majors'));
        exit();
    }
    // If not direct access but still no $majors, show error
    die('Error: This page must be accessed through the proper route.');
}
// Simple admin check
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    die('Unauthorized access.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Majors</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        /* Some specific styles for this page */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.75rem; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        .actions a { margin-right: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Majors</h2>
        <a href="<?php echo base_url('majors/create'); ?>">Add New Major</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($majors as $major): ?>
                <tr>
                    <td><?php echo htmlspecialchars($major['id']); ?></td>
                    <td><?php echo htmlspecialchars($major['name']); ?></td>
                    <td><?php echo htmlspecialchars($major['code']); ?></td>
                    <td class="actions">
                        <a href="<?php echo base_url('majors/edit?id=' . $major['id']); ?>">Edit</a>
                        <a href="<?php echo base_url('majors/delete?id=' . $major['id']); ?>" onclick="return confirm('Are you sure?')">Delete</a>
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