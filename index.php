<?php
    session_start();
    require('include/db_connection.php'); 
    require_once('include/functions.inc.php');
    $id = 1;
    
?>
<!DOCTYPE html>
<?php require_once('include/head.php'); ?>
<body>
<?php require_once('include/nav.php'); ?>
<main>
    <?php require_once('include/render_calculator.php'); ?>
    <!-- rendering default calculator  -->
    <?php render_calculator($conn, $id); ?>
</main>
<script src="js/script.js"></script>
</body>
</html>