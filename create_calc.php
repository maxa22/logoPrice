<?php

    session_start();
    if(!isset($_SESSION['fullName'])) {
        session_unset();
        header('Location: login.php');
        exit();
    }
    $errorMessage = '';
    require_once('include/db_connection.php');
    require_once('include/functions.inc.php');
    if(isset($_POST['calculatorName'])) {
        $calculatorName = trim($_POST['calculatorName']);
        
        //performing check of user input and storing the calculator name in SESSION
        if(!validateCalculator($calculatorName)) {
            if( $id = createCalculator($conn, $calculatorName, $_SESSION['id'])) {
                $_SESSION['calculator_id'] = $id;
                header('Location: questions.php');
                exit();
            }
        } else {
            $errorMessage = validateCalculator($calculatorName);
             echo $errorMessage;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/admin/admin_nav.php'); ?>
    <?php require_once('include/admin/admin_sidebar.php'); ?>
    <main>
        <form action="" method="POST" class="registration-form form login">
        <div class="main__heading">
            <h1>Create Caltulator</h1>
        </div>
        <div>
            <label for="calculator-name">Calculator Name:</label><br>
            <input type="text" name="calculatorName" id="calculator-name">
        </div>
        <button type="submit" type="submit">Submit</button>
    </form>
</main>
<script src="js/sidebar.js"></script>
</body>
</html>

