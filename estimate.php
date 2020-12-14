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

    //updating all the stepStatus field of the used steps
    $query = "UPDATE step SET stepStatus = '1' WHERE id = ?";
    $stmt = $conn->stmt_init();
    if(!$stmt -> prepare($query)) {
        header('Location: ../edit.php?id=' . $calc_id . '&error=stmtError');
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
        header('Location: ../edit.php?id=' . $calc_id . '&error=stmtError');
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
    setcookie('price', $price, time() + (86400 * 30));
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/nav.php'); ?>
    <div class="intro form">
        <h1 class="intro__heading">your logo estimate <span><?php echo $_COOKIE['price']; ?>BAM</span></h1>
    </div>

</body>
</html>