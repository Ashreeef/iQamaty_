<?php
require_once '../../database/db.php';

// Function to handle user login
function loginUser($pdo, $email, $password) {
    // Sanitize inputs
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = trim($password);

    // Query the database for the user
    $stmt = $pdo->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify the password and set the session
    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['user_email'] = $user['Email'];
        $_SESSION['user_role'] = $user['Role'];  // Save the role in the session

        // Save user IP and User-Agent for session validation later
        $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['UA'] = $_SERVER['HTTP_USER_AGENT'];

        // Redirect based on role
        if ($user['Role'] == 'super_admin' || $user['Role'] == 'staff') {
            header("Location: ../admin/controllers/index.php");  // Admin/Staff Dashboard
        } else {
            header("Location: ../user/feed.php");  // Student Dashboard
        }
        exit();
    }
    return false; // Invalid login credentials
}

// Function to check if the user is logged in
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to handle session timeout and security checks
function checkSessionTimeout() {
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        session_unset();
        session_destroy();
        echo '<div id="login-message">Session expired. Redirecting to login...</div>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "/iQamaty_10/views/auth/auth.php";
                }, 3000);
              </script>';
        exit();
    }
    $_SESSION['LAST_ACTIVITY'] = time();
}

// Function to validate session integrity (IP & UA check)
function validateSession() {
    if (!isset($_SESSION['IP'], $_SESSION['UA'])) {
        session_unset();
        session_destroy();
        echo '<div id="login-message">Invalid session. Redirecting to login...</div>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "/iQamaty_10/views/auth/auth.php";
                }, 3000);
              </script>';
        exit();
    }
    if ($_SESSION['IP'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['UA'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_unset();
        session_destroy();
        echo '<div id="login-message">Session mismatch. Redirecting to login...</div>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "/iQamaty_10/views/auth/auth.php";
                }, 3000);
              </script>';
        exit();
    }
}

// Function to handle logout and clear cookies
function logoutUser() {
    session_unset();
    session_destroy();
    setcookie('user_session', '', time() - 3600, '/', '', true, true); // Expire the custom session cookie
    header("Location: /iQamaty_10/views/auth/auth.php");
    exit();
}
?>
