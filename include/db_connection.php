<?php

    $serverName = 'localhost';
    $userName = 'root';
    $password = '';
    $db = 'logotip';

    $conn = new mysqli($serverName, $userName, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        header('Location: index.php?error=' . $conn->connect_error);
        exit();
    }
?>