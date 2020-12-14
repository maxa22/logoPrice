<?php 
    //Checking if the input is empty and consists of letters, numbers and spaces
    foreach($_POST as $k => $v) {
        if(validateCalculator($v) && $k !== 'submit') {
            if(strpos($k, 'price')) {
                $errorMessage = validateNumber($v);
                if($errorMessage) {
                    break;
                } else {
                    continue;
                }
            } 
            $errorMessage = validateCalculator($v);
            break;
        }
    } 

    if(!$errorMessage) {
        //Adding a question sing on the end of the question
        $question = trim($_POST['question']);
        $question = $question[strlen($question) - 1] == '?' ? $question : $question . '?';

        //inserting data into step table
        if($error = createStep($conn, $question, $_SESSION['calculator_id'])) {
            echo $error;
        }

        //performing while loop to insert data into options table
        $i = 1;
        while(isset($_POST['name' . $i])) {
            $name = trim($_POST['name' . $i]);
            $price = trim($_POST[$i .'price']);
            $url = trim($_POST['url' . $i]);
            $row = selectStep($conn, $question, $_SESSION['calculator_id']);
            //inserting data to options table
            createOptions($conn, $name, $price, $url, $row['id']);
            $i++;
        }
    } else {
        $_POST = array();
        echo $errorMessage;
    } 
?>