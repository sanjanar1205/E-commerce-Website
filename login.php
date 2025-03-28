<?php
// Always start the session at the very beginning
session_start();

// Database connection
include 'db_connect.php';

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Logging function
function debugLog($message) {
    $logFile = 'login_debug.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "$timestamp - $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back to login with error
        header("Location: login.html?error=Invalid email format");
        exit();
    }

    // Prepare SQL to prevent SQL injection
    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        // Redirect back to login with error
        header("Location: login.html?error=Database error");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Destroy any existing session first
            session_unset();
            session_destroy();
            
            // Start a new session
            session_start();
            
            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            
            // Set session timeout (optional)
            $_SESSION['last_activity'] = time();
            
            // Log successful login
            debugLog("Login successful for email: $email");
            
            // Directly redirect to sample.html
            header("Location: sample.html");
            exit();
        } else {
            // Redirect back to login with error
            header("Location: login.html?error=Invalid email or password");
            exit();
        }
    } else {
        // Redirect back to login with error
        header("Location: login.html?error=Invalid email or password");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>