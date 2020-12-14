<?php
    require_once('db_connection.php');
    require_once('functions.inc.php');

    if(isset($_POST['submit'])) {
        
        $fullName = trim($_POST['fullName']);
        $email = trim($_POST['email']);
        $password = trim( $_POST['password']);
        $confirmPassword = trim( $_POST['confirmPassword']);

        if(isEmpty($fullName, $email, $password, $confirmPassword)) {
            header('Location: ../register.php?error=emptyFields');
            exit();
        }
        if(notMatchingPassword($password, $confirmPassword)) {
            header('Location: ../index.php?error=passwordMustMatch');
            exit();
        }
        if(userExists($conn, $fullName)) {
            header('Location: ../index.php?error=userExists');
            exit();
        }
        createUser($conn, $fullName, $password);
        header('Location: ../index.php?error=none');

    }
?>