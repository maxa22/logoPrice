<?php 
    session_start();
    if(!isset($_SESSION['fullName'])) {
        session_unset();
        header('Location: index.php');
        exit();
    }

    if(isset($_POST['saveOptions'])) {
        require_once('db_connection.php');
        require_once('functions.inc.php');
        $errorMessage = '';
        foreach($_POST as $k => $v) {
            if (strpos($k, 'optionName')) {
                $errorMessage = validateCalculator($v);
                if($errorMessage) {
                    break;
                }
                $optionName = $v;
                $id = explode('-', $k)[1];
                $calc_id = explode('-', $k)[0];
            }
            if(strpos($k, 'optionPrice')) {
                $errorMessage = validateNumber($v);
                if($errorMessage) {
                    break;
                }
                $optionPrice = $v;
            }
        }
        if(array_key_exists($id . '-optionImage', $_FILES)) {
            $errorMessage = validateFileUpload($id . '-optionImage');
            $tempName = $_FILES[$id . '-optionImage']['tmp_name'];
            $fileName = $_FILES[$id . '-optionImage']['name'];
            $error = $_FILES[$id . '-optionImage']['error'];
            $directory = 'images';
            $optionImage = $error == 4 ? '' : $directory . '/' . $fileName;
        }
        if(!$errorMessage) {
            if($optionImage) {
                move_uploaded_file($tempName, '../' . $directory . '/' . $fileName);
            }
            $query = "UPDATE options SET optionName=?, optionPrice=?, optionImage=? WHERE id = ?";
            $stmt = $conn->stmt_init();
            if(!$stmt -> prepare($query)) {
                header('Location: ../edit.php?id=' . $calc_id . '&error=stmtError');
                exit();
            } else {
                $stmt->bind_param('ssss', $optionName, $optionPrice, $optionImage, $id);
                $stmt->execute();
                $stmt->close();
                header('Location: ../edit.php?id=' . $calc_id);
            }

        } else {
            header('Location: ../edit.php?id=' . $calc_id);
        }
    }
    if(isset($_POST['submit'])) {
        require_once('db_connection.php');
        require_once('functions.inc.php');
        $errorMessage = '';
        foreach($_POST as $k => $v) {
            if (strpos($k, 'name')) {
                $errorMessage = validateCalculator($v);
                if($errorMessage) {
                    break;
                }
                $optionName = $v;
                $step_id = explode('-', $k)[1];
                $calc_id = explode('-', $k)[0];
            }
            if(strpos($k, 'price')) {
                $errorMessage = validateNumber($v);
                if($errorMessage) {
                    break;
                }
                $optionPrice = $v;
            }
        }
        if(array_key_exists($calc_id . '-' . $step_id . '-url', $_FILES)) {

            $errorMessage = validateFileUpload($calc_id . '-' . $step_id . '-url');
            $tempName = $_FILES[$calc_id . '-' . $step_id . '-url']['tmp_name'];
            $fileName = $_FILES[$calc_id . '-' . $step_id . '-url']['name'];
            $error = $_FILES[$calc_id . '-' . $step_id . '-url']['error'];
            $directory = 'images';
            $optionImage = $error == 4 ? '' : $directory . '/' . $fileName;
            echo $errorMessage;
        }
        if(!$errorMessage) {
            if($optionImage) {
                move_uploaded_file($tempName, '../' . $directory . '/' . $fileName);
            }
            $query = "SELECT * FROM step WHERE id = ?";
            $step = selectOne($conn, $step_id, $query);
            createOptions($conn, $optionName, $optionPrice, $optionImage, $step['id']);
            header('Location: ../edit.php?id=' . $calc_id);
            exit();
        }
        else {
            header('Location: ../edit.php?id=' . $calc_id . '&error=' . $errorMessage);
        }
    }

    if(isset($_POST['saveQuestion'])) {
        require_once('db_connection.php');
        require_once('functions.inc.php');
        foreach($_POST as $k => $v) {
            if(strpos($k, 'question')) {
                $question = $v;
                $calc_id = explode('-', $k)[0];
                $id = explode('-', $k)[1];
            }
        }
        $query = "UPDATE step SET stepName = ? WHERE id = ?";
        $stmt = $conn->stmt_init();
        if(!$stmt -> prepare($query)) {
            header('Location: ../edit.php?id=' . $calc_id . '&error=stmtError');
            exit();
        } else {
            $stmt->bind_param('ss', $question, $id);
            $stmt->execute();
            $stmt->close();
            header('Location: ../edit.php?id=' . $calc_id);
        }
    }
?>