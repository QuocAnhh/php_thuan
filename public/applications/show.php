<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . base_url('login'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Application</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
</head>
<body>
    <div class="container">
        <h2>My Application Details</h2>
        
        <p><strong>Status:</strong> <span style="font-weight: bold; text-transform: uppercase;"><?php echo htmlspecialchars($application['status']); ?></span></p>
        <p><strong>Submitted On:</strong> <?php echo date('F j, Y, g:i a', strtotime($application['created_at'])); ?></p>
        
        <h3 style="margin-top: 2rem;">My Aspirations</h3>
        <ul>
            <?php foreach ($aspirations as $asp): ?>
                <li>
                    <strong>Priority <?php echo htmlspecialchars($asp['priority']); ?>:</strong>
                    <?php echo htmlspecialchars($asp['major_name']); ?> (<?php echo htmlspecialchars($asp['major_code']); ?>)
                </li>
            <?php endforeach; ?>
        </ul>

        <h3 style="margin-top: 2rem;">My Documents</h3>
        <ul>
            <?php foreach ($documents as $doc): ?>
                <li>
                    <strong><?php echo htmlspecialchars(ucfirst($doc['document_type'])); ?>:</strong>
                    <a href="<?php echo base_url($doc['file_path']); ?>" target="_blank">View Document</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <hr style="margin: 2rem 0;">
        <a href="<?php echo base_url('dashboard'); ?>">Back to Dashboard</a>
    </div>
</body>
</html> 