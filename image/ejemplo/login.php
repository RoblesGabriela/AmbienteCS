<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (loginUser($email, $password)) {
        echo "Login successful. Session data: ";
        print_r($_SESSION);
        exit();
    } else {
        $error = "Invalid email or password";
    }
}

// Rest of the login.php code...
