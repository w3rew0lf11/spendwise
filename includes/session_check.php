<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: index.php?message=Please login first");
    exit();
}

if (isset($_SESSION['last_activity'])) {
    $inactive_time = time() - $_SESSION['last_activity'];
    if ($inactive_time > $_SESSION['expire_time']) {
        session_unset();
        session_destroy();
        header("Location: index.php?message=Session expired. Please login again");
        exit();
    }
}

$_SESSION['last_activity'] = time();
?>