<?php

    session_start();
    if(!isset($_SESSION['fullName'])) {
        session_unset();
        header('Location: login');
        exit();
    }
    $errorMessage = '';
    require_once('include/db_connection.php');
    require_once('include/functions.inc.php');
    if(isset($_POST['calculatorName'])) {
        $calculatorName = htmlspecialchars($_POST['calculatorName']);
        $calculatorText = htmlspecialchars($_POST['calculatorText']);
        //performing check of user input and storing the calculator name in SESSION
        if(!validateCalculator($calculatorName) && !validateCalculator($calculatorText)) {
            if( $id = createCalculator($conn, $calculatorName, $calculatorText, $_SESSION['id'])) {
                $_SESSION['calculator_id'] = $id;
                header('Location: questions');
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
        <form action="" method="POST" class="form login">
        <div class="main__heading">
            <h1>Create Caltulator</h1>
        </div>
        <div>
            <label for="calculator-name">Calculator Name:</label><br>
            <input type="text" name="calculatorName" id="calculator-name">
        </div>
        <div>
            <textarea name="calculatorText" id="calculator-text" cols="30" rows="10" placeholder="What text to display the user on price estimate..."></textarea>
        </div>
        <button type="submit" type="submit">Submit</button>
    </form>
</main>
<script src="js/sidebar.js"></script>
</body>
</html>

