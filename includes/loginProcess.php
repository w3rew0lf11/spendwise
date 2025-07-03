<?php 
session_start();
include("database.php");

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $check_query = mysqli_prepare($connection, "SELECT id, username, password FROM auth WHERE username = ?");
    mysqli_stmt_bind_param($check_query, "s", $username);
    mysqli_stmt_execute($check_query);
    mysqli_stmt_store_result($check_query);

    if (mysqli_stmt_num_rows($check_query) === 1) {
        mysqli_stmt_bind_result($check_query, $user_id, $db_username, $hashed_password);
        mysqli_stmt_fetch($check_query);

        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time(); // Update last activity time
            
            // Set session to expire after 30 minutes of inactivity
            $_SESSION['expire_time'] = 30 * 60; // 30 minutes in seconds
            
            header("Location: ../dashboard.php");
            exit();
        } else {
            header("Location: ../index.php?message=Incorrect password");
            exit();
        }
    } else {
        header("Location: ../index.php?message=User doesn't exist");
        exit();
    }
}
?>