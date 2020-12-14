<?php
    session_start();
    if(!$_SESSION['fullName']) {
        header('Location: ../login.php');
        exit();
    }
    if(isset($_GET['id'])) {
        require_once('db_connection.php');
        require_once('functions.inc.php');
        $id = $_GET['id'];
        if(!validateCalculator($id)) {

            // verifying that the step belongs to the current user
            $query = "SELECT * FROM calculator WHERE id = ?";
            $calculator = selectOne($conn, $_GET['calc_id'], $query);
            if($calculator['user_id'] == $_SESSION['id']) {

                //deleting the step and options
                $query = "DELETE FROM options WHERE id = ?";
                delete($conn, $id, $query);
                header('Location: ../edit.php?id=' . $_GET['calc_id']);
                exit();
            }
        } else {
            header('Location: ../index.php');
        }
    } else {
        header('Location: ../index.php');
    }

?>