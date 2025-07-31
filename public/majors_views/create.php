<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    die('Unauthorized access.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Major</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
</head>
<body>
    <div class="container">
        <h2>Create New Major</h2>
        <form action="<?php echo base_url('majors/create'); ?>" method="POST">
            <label for="name">Major Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="code">Major Code:</label>
            <input type="text" id="code" name="code" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"></textarea>
            <button type="submit">Create Major</button>
        </form>
        <br>
        <a href="<?php echo base_url('majors'); ?>">Back to List</a>
    </div>
</body>
</html> 