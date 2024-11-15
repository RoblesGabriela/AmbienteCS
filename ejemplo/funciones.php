<?php
session_start();
require_once 'config.php';

function registerUser($name, $email, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
        
        if(mysqli_stmt_execute($stmt)){
            return true;
        } else{
            return false;
        }
    }
    mysqli_stmt_close($stmt);
}

function loginUser($email, $password) {
    global $conn;
    
    $sql = "SELECT id, name, password FROM users WHERE email = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $email);
        
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $name, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["name"] = $name;
                        $_SESSION["last_activity"] = time();
                        return true;
                    }
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    return false;
}

function updateProfile($id, $name, $email, $new_password = null) {
    global $conn;
    
    $sql = "UPDATE users SET name = ?, email = ?";
    $params = array($name, $email);
    $types = "ss";
    
    if($new_password) {
        $sql .= ", password = ?";
        $params[] = password_hash($new_password, PASSWORD_DEFAULT);
        $types .= "s";
    }
    
    $sql .= " WHERE id = ?";
    $params[] = $id;
    $types .= "i";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        
        if(mysqli_stmt_execute($stmt)){
            return true;
        } else{
            return false;
        }
    }
    mysqli_stmt_close($stmt);
}

function saveMessage($user_id, $message) {
    global $conn;
    
    $sql = "INSERT INTO messages (user_id, message) VALUES (?, ?)";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "is", $user_id, $message);
        
        if(mysqli_stmt_execute($stmt)){
            return true;
        } else{
            return false;
        }
    }
    mysqli_stmt_close($stmt);
}

function isLoggedIn() {
    return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
}

function checkSessionTimeout() {
    $timeout = 1800; // 30 minutes
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        session_unset();
        session_destroy();
        return false;
    }
    $_SESSION['last_activity'] = time();
    return true;
}

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}
