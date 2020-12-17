<?php   
    session_start();
    if(isset($_GET['id'])) {
        require_once('include/db_connection.php');
        require_once('include/functions.inc.php');
        $id = $_GET['id'];
        $errorMessage = '';
        if(!validateCalculator($id)) {
            $query = "SELECT * FROM calculator WHERE id = ?";
            $calculator = selectOne($conn, $id, $query);
            if(!$calculator) {
                header('Location: calculators');
                exit();
            }
        }
    } else {
        header('Location: calculators');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/nav.php'); ?>
    <?php require_once('include/render_calculator.php'); ?>
    <?php
        render_calculator($conn, $calculator['id']);
    ?>
    <script src="<?php base(); ?>js/script.js"></script>
</body>
</html>