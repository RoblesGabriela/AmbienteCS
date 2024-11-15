<?php
session_start();
require_once 'functions.php';

if (isLoggedIn() && checkSessionTimeout()) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Application</title>
</head>
<body>
    <h1>Welcome to Our Application</h1>
    <p>Please choose an option:</p>
    <ul>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
    </ul>
</body>
</html>
