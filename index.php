<?php
session_start();

$email = $_SESSION['user_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome</h1>
    <?php if ($email !== ''): ?>
        <p><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
</body>
</html>