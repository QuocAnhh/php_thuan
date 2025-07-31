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
    <title>Create Admission Application</title>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <style>
        .aspiration-item { display: flex; align-items: center; margin-bottom: 1rem; }
        .aspiration-item select, .aspiration-item input { margin-right: 10px; }
        .aspiration-item button { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Submit Your Application</h2>
        <form action="<?php echo base_url('application/create'); ?>" method="POST" enctype="multipart/form-data">
            
            <h3>Your Aspirations</h3>
            <div id="aspirations-container">
                <div class="aspiration-item">
                    <input type="number" name="aspirations[0][priority]" placeholder="Priority" min="1" required style="width: 80px;">
                    <select name="aspirations[0][major_id]" required>
                        <option value="">-- Select a Major --</option>
                        <?php foreach ($majors as $major): ?>
                            <option value="<?php echo $major['id']; ?>">
                                <?php echo htmlspecialchars($major['name']) . ' (' . htmlspecialchars($major['code']) . ')'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="button" id="add-aspiration">Add Another Aspiration</button>

            <h3 style="margin-top: 2rem;">Required Documents</h3>
            <label for="doc_transcript">High School Transcript:</label>
            <input type="file" id="doc_transcript" name="documents[transcript]" required>
            
            <label for="doc_certificate">Graduation Certificate:</label>
            <input type="file" id="doc_certificate" name="documents[certificate]" required>

            <hr style="margin: 2rem 0;">
            <button type="submit">Submit Application</button>
        </form>
    </div>

    <script>
        document.getElementById('add-aspiration').addEventListener('click', function() {
            const container = document.getElementById('aspirations-container');
            const index = container.children.length;
            const newItem = document.createElement('div');
            newItem.className = 'aspiration-item';
            newItem.innerHTML = `
                <input type="number" name="aspirations[${index}][priority]" placeholder="Priority" min="1" required style="width: 80px;">
                <select name="aspirations[${index}][major_id]" required>
                    <option value="">-- Select a Major --</option>
                    <?php foreach ($majors as $major): ?>
                        <option value="<?php echo $major['id']; ?>">
                            <?php echo htmlspecialchars($major['name']) . ' (' . htmlspecialchars($major['code']) . ')'; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="button" onclick="this.parentElement.remove()">Remove</button>
            `;
            container.appendChild(newItem);
        });
    </script>
</body>
</html> 