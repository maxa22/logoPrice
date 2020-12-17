<?php
    session_start();
    if(isset($_POST['submit'])) {
    // getting the prices of the selected radio inputs, calculating them and storing in price variable
    require_once('include/db_connection.php');
    require_once('include/functions.inc.php');
    $price = 0;
    foreach($_POST as $k => $v) {
        if(strpos($k, 'answer')) {
            $id = explode('-', $v)[2];
            $stepId = explode('-', $v)[0];
            $query = "SELECT * FROM options WHERE id = ?";
            $option = selectOne($conn, $id, $query);
            $price += $option['optionPrice'];
        }
    }
    if(isset($_COOKIE['price'])) {
        $_COOKIE['price'] = $price;
    } else {
        setcookie('price', $price, time() + (86400 * 30));
    }
    }
    //updating all the stepStatus fields from used steps
    $query = "UPDATE step SET stepStatus = '1' WHERE id = ?";
    $stmt = $conn->stmt_init();
    if(!$stmt -> prepare($query)) {
        header('Location: edit/' . $calc_id . '&error=stmtError');
        exit();
    } else {
        foreach($_POST as $k => $v) {
            if(strpos($k, 'answer')) {
                $stepId = explode('-', $v)[0];
                $stmt->bind_param('s', $stepId);
                $stmt->execute();
            }
        }
        $stmt->close();
    }

    //updating all the options that have been selected by the user
    $query = "UPDATE options SET optionStatus = '1' WHERE id = ?";
    $stmt = $conn->stmt_init();
    if(!$stmt -> prepare($query)) {
        header('Location: edit/' . $calc_id . '&error=stmtError');
        exit();
    } else {
        foreach($_POST as $k => $v) {
            if(strpos($k, 'answer')) {
                $id = explode('-', $v)[2];
                $stmt->bind_param('s', $id);
                $stmt->execute();
            }
        }
        $stmt->close();
    }

    //selecting the calculator text that the user provided
    $query = "SELECT * FROM step WHERE id = ?";
    $step = selectOne($conn, $stepId, $query);
    $query = "SELECT * FROM calculator WHERE id = ?";
    $calculator = selectOne($conn, $step['calculator_id'], $query);
    
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/nav.php'); ?>
    <div class="intro form">
        <h1 class="intro__heading">your  estimate <span><?php echo $_COOKIE['price']; ?>BAM</span></h1>
    </div>
    <div class="intro form">
        <p><?php echo $calculator['calculatorText']; ?></p>
    </div>

</body>
</html>