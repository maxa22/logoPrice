<!-- 
    - updating and adding steps and options for a specific calculator
    - check the POST array for saveOptions, submit or saveQuestion keys
    ### saveOption ###
    - updating options table with updated data
    ### submit ###
    - adding new option to options table
    ### saveQuestion ###
    - updating question table with updated data
 -->
<?php 
    session_start();
    if(!isset($_SESSION['fullName'])) {
        session_unset();
        header('Location: index');
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
                $optionName = htmlspecialchars($v);
                $id = explode('-', $k)[1];
                $calc_id = explode('-', $k)[0];
            }
            if(strpos($k, 'optionPrice')) {
                $errorMessage = validateNumber($v);
                if($errorMessage) {
                    break;
                }
                $optionPrice = htmlspecialchars($v);
            }
        }

        if(array_key_exists($id . '-optionImage', $_FILES) && $_FILES[$id . '-optionImage']['error'] != 4) {
            $errorMessage = validateFileUpload($id . '-optionImage');
            $tempName = $_FILES[$id . '-optionImage']['tmp_name'];
            $fileName = $_FILES[$id . '-optionImage']['name'];
            $directory = 'images';
            $path = file_exists('../images/' . $fileName) ? 'images/' . mt_rand(100, 999) . $fileName : 'images/' . $fileName;
            $error = $_FILES[$id . '-optionImage']['error'];
            $optionImage = $error == 4 ? '' : explode('/', $path)[1];
            if(!$errorMessage) {
                if($optionImage) {
                    move_uploaded_file($tempName, '../' . $path);
                }
                $query = "SELECT * FROM options WHERE id = ?";
                $row = selectOne($conn, $id, $query);
                if($row['optionImage']) {
                    unlink('../images/' . $row['optionImage']);
                }
                $query = "UPDATE options SET optionName=?, optionPrice=?, optionImage=? WHERE id = ?";
                $stmt = $conn->stmt_init();
                if(!$stmt -> prepare($query)) {
                    header('Location: ../edit/' . $calc_id . '&error=stmtError');
                    exit();
                } else {
                    $stmt->bind_param('ssss', $optionName, $optionPrice, $optionImage, $id);
                    $stmt->execute();
                    $stmt->close();
                    header('Location: ../edit/' . $calc_id);
                }

        } else {
            header('Location: ../edit/id' . $calc_id);
        }
    } else {
        if(!$errorMessage) {

            $query = "UPDATE options SET optionName=?, optionPrice=? WHERE id = ?";
            $stmt = $conn->stmt_init();
            if(!$stmt -> prepare($query)) {
                header('Location: ../edit/' . $calc_id . '&error=stmtError');
                exit();
            } else {
                $stmt->bind_param('sss', $optionName, $optionPrice, $id);
                $stmt->execute();
                $stmt->close();
                header('Location: ../edit/' . $calc_id);
            }
        }
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
            $directory = 'images';
            $path = file_exists('../' . $directory . '/' . $fileName) ? $directory . '/' . mt_rand(100,999) . $fileName : $directory . '/' . $fileName;
            $error = $_FILES[$calc_id . '-' . $step_id . '-url']['error'];
            $optionImage = $error == 4 ? '' : explode('/', $path)[1];
        }
        if(!$errorMessage) {
            if($optionImage) {
                move_uploaded_file($tempName, '../' . $path);
            }
            $query = "SELECT * FROM step WHERE id = ?";
            $step = selectOne($conn, $step_id, $query);
            createOptions($conn, $optionName, $optionPrice, $optionImage, $step['id']);
            header('Location: ../edit/' . $calc_id);
            exit();
        }
        else {
            header('Location: ../edit/' . $calc_id);
            exit();
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
            header('Location: ../edit/' . $calc_id . '&error=stmtError');
            exit();
        } else {
            $stmt->bind_param('ss', $question, $id);
            $stmt->execute();
            $stmt->close();
            header('Location: ../edit/' . $calc_id);
        }
    }
?>