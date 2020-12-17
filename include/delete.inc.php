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
            $query = "SELECT * FROM calculator WHERE id = ?";
            $calculator = selectOne($conn, $id, $query);
            if($calculator['user_id'] == $_SESSION['id']) {
                $query = "SELECT * FROM step WHERE calculator_id = ?";
                $step = select($conn, $calculator['id'], $query);
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
                $query = "DELETE FROM step WHERE calculator_id = ?";
                delete($conn, $calculator['id'], $query);
                $query = "DELETE FROM calculator WHERE id = ?";
                $error = delete($conn, $id, $query);
                header('Location: ../calculators');
                exit();
            }
        } else {
            header('Location: ../index');
        }
    } else {
        header('Location: ../index');
    }