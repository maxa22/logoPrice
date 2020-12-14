<?php

    session_start();
    if(!isset($_SESSION['fullName'])) {
        header('Location: login.php');
        exit();
    }
    $errorMessage = '';
    require_once('include/db_connection.php');
    require_once('include/functions.inc.php');
    if(isset($_POST['finish'])) {
        header('Location: users_calculator.php');
        exit();
    }
    if(isset($_POST['submit'])) {
       require_once('include/create_question.inc.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/admin/admin_nav.php'); ?>
    <?php require_once('include/admin/admin_sidebar.php'); ?>
    <main>
    <div class="main__heading">
        <h1>Add questions</h1>
    </div>
    <form action="" method="POST" class="registration-form form">
        <?php require_once('include/question_form.php'); ?>
        <button name="submit">add question</button>
        <button name="finish">done</a>
    </form>
</main>
<script src="js/script2.js"></script>
<script src="js/sidebar.js"></script>
</body>
</html>