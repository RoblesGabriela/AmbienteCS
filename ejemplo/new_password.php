<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

$csrf_token = generateCSRFToken();

$email = isset($_GET['email']) ? filter_var($_GET['email'], FILTER_SANITIZE_EMAIL) : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($email) || empty($token) || !verifyPasswordResetToken($email, $token)) {
    die('Invalid or expired password reset link');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        die('Invalid CSRF token');
    }

    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (!isPasswordStrong($new_password)) {
        $error = "Password does not meet the strength requirements";
    } elseif (resetPassword($email, $new_password)) {
        $success = "Your password has been reset successfully. You can now <a href='login.php'>login</a> with your new password.";
    } else {
        $error = "An error occurred. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
</head>
<body>
    <h2>Set New Password</h2>
    <?php if (isset($success)): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php elseif (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if (!isset($success)): ?>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <br>
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <p>Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.</p>
            <button type="submit">Set New Password</button>
        </form>
    <?php endif; ?>
</body>
</html>
