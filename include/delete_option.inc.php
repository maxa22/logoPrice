<?php
    session_start();
    if(!$_SESSION['fullName']) {
        header('Location: ../login');
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
                //finding the options row to remove the images from images folder
                $query = "SELECT * FROM options WHERE id = ?";
                $row = selectOne($conn, $id, $query);
                if($row['optionImage']) {
                    unlink('../images/' . $row['optionImage']);
                }
                //deleting the step and options
                $query = "DELETE FROM options WHERE id = ?";
                delete($conn, $id, $query);
                header('Location: ../edit/' . $_GET['calc_id']);
                exit();
            }
        } else {
            header('Location: ../index');
        }
    } else {
        header('Location: ../index');
    }

?>