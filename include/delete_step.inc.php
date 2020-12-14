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
                $query = "SELECT * FROM step WHERE id = ?";
                $step = select($conn, $id, $query);
                if($step->num_rows > 0) {
                    while($row = $step->fetch_assoc()) {
                        $query = "DELETE FROM options WHERE step_id = ?";
                        delete($conn, $row['id'], $query);
                    }
                }
                $query = "DELETE FROM step WHERE id = ?";
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