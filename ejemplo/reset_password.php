<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

$csrf_token = generateCSRFToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $reset_token = bin2hex(random_bytes(32));
    $reset_token_expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    if (setPasswordResetToken($email, $reset_token, $reset_token_expiry)) {
        sendPasswordResetEmail($email, $reset_token);
        $message = "If an account with that email exists, a password reset link has been sent.";
    } else {
        $message = "An error occurred. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <?php if (isset($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php else: ?>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Reset Password</button>
        </form>
    <?php endif; ?>
    <p><a href="login.php">Back to Login</a></p>
</body>
</html>
