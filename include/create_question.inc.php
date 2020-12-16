<?php 
    //Checking if the input is empty and consists of letters, numbers and spaces
    foreach($_POST as $k => $v) {
        if(strpos($k,'question') || strpos($k, 'name')) {
            $errorMessage = validateCalculator($v);
            if($errorMessage) {
                break;
            } else {
                continue;
            }
        }
        if(strpos($k, 'price')) {
            $errorMessage = validateNumber($v);
            if($errorMessage) {
                break;
            } else {
                continue;
            }
        }
    }
    
    if(!$errorMessage) {
        $i = 1;
        while(isset($_POST[$i . 'url'])) {
            $errorMessage = validateFileUpload($i . 'url');
            if($errorMessage) {
                break;
            }
            if(file_exists('images/' . $_FILES[$i . 'url']['name'])) {
                $errorMessage = 'File already exists';
                break;
            }
            $i++;
        }
        if(!$errorMessage) {

            //Adding a question sing on the end of the question
            $question = trim($_POST['question']);
            $question = $question[strlen($question) - 1] == '?' ? $question : $question . '?';
            
            //inserting data into step table
            if($error = createStep($conn, $question, $_SESSION['calculator_id'])) {
                echo $error;
            }
            $i = 1;
            //performing while loop to insert data into options table
            while(isset($_POST[$i . 'name'])) {
                $name = trim($_POST[$i . 'name']);
                $price = trim($_POST[$i .'price']);
                $tempName = $_FILES[$i . 'url']['tmp_name'];
                $fileName = $_FILES[$i . 'url']['name'];
                $error = $_FILES[$i . 'url']['error'];
                $directory = 'images';
                if(move_uploaded_file($tempName, $directory . '/' . $fileName) || $error == 4) {
                    $url = $error == 4 ? '' : $directory . '/' . $fileName;
                    $row = selectStep($conn, $question, $_SESSION['calculator_id']);
                    //inserting data to options table
                    createOptions($conn, $name, $price, $url, $row['id']);
                }
                $i++;
            } 
            $successMessage = 'Question successfully added to calculator';
        }
    }
?>