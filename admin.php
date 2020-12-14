<?php
    session_start();
    if(!isset($_SESSION['fullName'])) {
        session_unset();
        header('Location: index.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/admin/admin_nav.php'); ?>
    <?php require_once('include/admin/admin_sidebar.php'); ?>
    <main>
        
    </main>
    <script src="js/sidebar.js"></script>
</body>
</html>