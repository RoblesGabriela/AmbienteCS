<?php
session_start();
require_once 'functions.php';

header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        $response['message'] = 'Invalid CSRF token';
        echo json_encode($response);
        exit();
    }

    $action = isset($_POST['action']) ? sanitizeInput($_POST['action']) : '';

    switch ($action) {
        case 'register':
            $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
            $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

            if ($password !== $confirm_password) {
                $response['message'] = 'Passwords do not match';
            } elseif (!isPasswordStrong($password)) {
                $response['message'] = 'Password does not meet the strength requirements';
            } elseif (registerUser($name, $email, $password)) {
                $response['success'] = true;
                $response['message'] = 'User registered successfully. Please check your email to verify your account.';
            } else {
                $response['message'] = 'Registration failed';
            }
            break;

        case 'login':
            $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            if (isLoginAttemptExceeded($email)) {
                $response['message'] = 'Too many failed login attempts. Please try again later.';
            } else {
                $login_result = loginUser($email, $password);
                if ($login_result === true) {
                    $response['success'] = true;
                    $response['message'] = 'Login successful';
                    $response['name'] = $_SESSION['name'];
                } elseif ($login_result === 'unverified') {
                    $response['message'] = 'Please verify your email address before logging in.';
                } else {
                    $response['message'] = 'Invalid email or password';
                }
            }
            break;

        case 'update_profile':
            if (isLoggedIn()) {
                $id = $_SESSION['id'];
                $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
                $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
                $new_password = isset($_POST['new_password']) && !empty($_POST['new_password']) ? $_POST['new_password'] : null;

                if ($new_password && !isPasswordStrong($new_password)) {
                    $response['message'] = 'New password does not meet the strength requirements';
                } elseif (updateProfile($id, $name, $email, $new_password)) {
                    $response['success'] = true;
                    $response['message'] = 'Profile updated successfully';
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                } else {
                    $response['message'] = 'Profile update failed';
                }
            } else {
                $response['message'] = 'User not logged in';
            }
            break;

        case 'send_message':
            if (isLoggedIn()) {
                $user_id = $_SESSION['id'];
                $message = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';

                if (saveMessage($user_id, $message)) {
                    $response['success'] = true;
                    $response['message'] = 'Message sent successfully';
                } else {
                    $response['message'] = 'Failed to send message';
                }
            } else {
                $response['message'] = 'User not logged in';
            }
            break;

        default:
            $response['message'] = 'Invalid action';
            break;
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
