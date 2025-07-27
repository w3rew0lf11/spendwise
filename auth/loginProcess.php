<?php

session_start();
require '../config/database.php';

if (isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $db = new DB();

    $user = $db->select("SELECT * FROM auth WHERE username = ?", [$username]);

    if ($user) {
        $user = $user[0]; 
        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['logged_in'] = true;
            $_SESSION['last_activity'] = time();
            $_SESSION['expire_time'] = 30 * 60; // 30 minutes

            header("Location: ../pages/dashboard.php?message=Login Succesfull");
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
