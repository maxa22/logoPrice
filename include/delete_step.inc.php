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

                //deleting the step and options
                $query = "SELECT * FROM step WHERE id = ?";
                $step = select($conn, $id, $query);
                if($step->num_rows > 0) {
                    while($row = $step->fetch_assoc()) {
                        $query = "SELECT * FROM options WHERE step_id = ?";
                        $result = select($conn, $row['id'], $query);
                        if($result->num_rows > 0) {
                            while($optionRow = $result->fetch_assoc()) {
                                if($optionRow['optionImage']) {
                                    unlink('../images/' . $optionRow['optionImage']);
                                }
                            }
                        }
                        $query = "DELETE FROM options WHERE step_id = ?";
                        delete($conn, $row['id'], $query);
                    }
                }
                $query = "DELETE FROM step WHERE id = ?";
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