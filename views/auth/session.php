<?php
session_start();

// Session timeout and activity check
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    session_unset();
    session_destroy();
    echo '<div id="login-message">Session expired. Redirecting to login...</div>';
    echo '<script>
            setTimeout(function() {
                window.location.href = "/iQamaty_10/views/auth/auth.php";
            }, 3000); // Delay 3 seconds
          </script>';
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

// Validate session data
if (!isset($_SESSION['IP'], $_SESSION['UA'])) {
    session_unset();
    session_destroy();
    echo '<div id="login-message">Invalid session. Redirecting to login...</div>';
    echo '<script>
            setTimeout(function() {
                window.location.href = "/iQamaty_10/views/auth/auth.php";
            }, 3000); // Delay 3 seconds
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
            }, 3000); // Delay 3 seconds
          </script>';
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<div id="login-message">You must be logged in to access this page. Redirecting...</div>';
    echo '<script>
            setTimeout(function() {
                window.location.href = "/iQamaty_10/views/auth/auth.php";
            }, 3000); // Delay 3 seconds
          </script>';
    exit();
}
?>