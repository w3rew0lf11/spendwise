<?php

include("database.php");


if (isset($_POST["register"])) {

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (strlen($password) < 8) {
        header("Location: ../index.php?message=Password must be at least 8 characters long");
        
    }

    if ($password != $confirm_password) {
        header("Location: ../index.php?message=Both passwords must be same");

    } else {

        $check_query = mysqli_prepare($connection, "SELECT id FROM auth WHERE username = ?");
        mysqli_stmt_bind_param($check_query, "s", $username);
        mysqli_stmt_execute($check_query);
        mysqli_stmt_store_result($check_query);

        if (mysqli_stmt_num_rows($check_query) > 0) {
            header("Location: ../index.php?message=username already taken");
            exit();
        } else {

            $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

            $query = mysqli_prepare($connection, "INSERT INTO auth (firstname, lastname, username, password) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($query, "ssss", $firstname, $lastname, $username, $hashed_password);


            if (!mysqli_stmt_execute($query)) {
                die("Querry failed" . mysqli_error($connection));
            } else {
                header("Location: ../index.php?success=Registration successful");
                exit();
            }
        }


    }

}
?>