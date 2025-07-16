<?php

require '../config/database.php';

if (isset($_POST["register"])) {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Basic password validation
    if (strlen($password) < 8) {
        header("Location: ../index.php?message=Password must be at least 8 characters long");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: ../index.php?message=Both passwords must be the same");
        exit();
    }

    // Initialize DB instance
    $db = new DB();

    // Check if username is already taken
    $existingUser = $db->select("SELECT * FROM auth WHERE username = ?", [$username]);

    if ($existingUser) {
        header("Location: ../index.php?message=Username already taken");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    try {
        $db->create("INSERT INTO auth (firstname, lastname, username, password) VALUES (?, ?, ?, ?)", [
            $firstname, $lastname, $username, $hashed_password
        ]);

        header("Location: ../index.php?success=Registration successful");
        exit();
    } catch (Exception $e) {
        header("Location: ../index.php?message=Registration failed: " . urlencode($e->getMessage()));
        exit();
    }
}
?>
