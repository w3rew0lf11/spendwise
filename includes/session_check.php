<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    // Redirect to login page
    header("Location: index.php?message=Please login first");
    exit();
}

// Check if session has expired due to inactivity
if (isset($_SESSION['last_activity'])) {
    $inactive_time = time() - $_SESSION['last_activity'];
    if ($inactive_time > $_SESSION['expire_time']) {
        // Session expired
        session_unset();
        session_destroy();
        header("Location: index.php?message=Session expired. Please login again");
        exit();
    }
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>