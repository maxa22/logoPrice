<!-- login user out, unseting session and redirecting user to index -->
<?php
    session_start();
    session_unset();
    unset($_SESSION['fullName']);
    unset($_SESSION['id']);
    header('Location: ../index');
    exit();
?>