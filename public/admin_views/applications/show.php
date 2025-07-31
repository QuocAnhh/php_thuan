<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) die('Unauthorized');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Details</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
</head>
<body>
    <div class="container">
        <h2>Application Details for <?php echo htmlspecialchars($application['user_name']); ?></h2>
        <p><strong>Applicant:</strong> <?php echo htmlspecialchars($application['user_name']); ?> (<?php echo htmlspecialchars($application['user_email']); ?>)</p>
        <p><strong>Status:</strong> <strong style="text-transform: uppercase;"><?php echo htmlspecialchars($application['status']); ?></strong></p>
        <p><strong>Submitted On:</strong> <?php echo date('F j, Y, g:i a', strtotime($application['created_at'])); ?></p>
        <hr>
        <h4>Aspirations</h4>
        <ul>
            <?php foreach ($aspirations as $asp): ?>
                <li><strong>Priority <?php echo htmlspecialchars($asp['priority']); ?>:</strong> <?php echo htmlspecialchars($asp['major_name']); ?></li>
            <?php endforeach; ?>
        </ul>
        <h4>Documents</h4>
        <ul>
            <?php foreach ($documents as $doc): ?>
                <li><strong><?php echo htmlspecialchars(ucfirst($doc['document_type'])); ?>:</strong> <a href="<?php echo base_url($doc['file_path']); ?>" target="_blank">View</a></li>
            <?php endforeach; ?>
        </ul>
        <hr>
        <h4>Update Status</h4>
        <form action="<?php echo base_url('admin/applications/update-status'); ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $application['id']; ?>">
            <select name="status">
                <option value="pending" <?php if ($application['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                <option value="approved" <?php if ($application['status'] == 'approved') echo 'selected'; ?>>Approve</option>
                <option value="rejected" <?php if ($application['status'] == 'rejected') echo 'selected'; ?>>Reject</option>
            </select>
            <button type="submit">Update Status</button>
        </form>
        <br>
        <a href="<?php echo base_url('admin/applications'); ?>">Back to Applications List</a>
    </div>
</body>
</html> 