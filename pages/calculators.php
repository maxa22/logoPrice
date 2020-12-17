<?php
    session_start();
    if(!isset($_SESSION['fullName'])) {
        session_unset();
        header('Location: login');
        exit();
    }
    require_once('include/db_connection.php');
    require_once('include/functions.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/admin/admin_nav.php'); ?>
    <?php require_once('include/admin/admin_sidebar.php'); ?>
    <main>
    <div class="main__heading">
        <h1>Dashboard</h1>
    </div>
    <?php 
        $query = "SELECT * FROM calculator WHERE user_id = ?";
        $calculators = select($conn, $_SESSION['id'], $query);
        if($calculators->num_rows > 0) { ?>
            <div class="calculator__wrapper">
            <?php while($row = $calculators->fetch_assoc()) { ?>
                <div class="calculator">
                    <img src="images/calculator.svg" alt="calculator" class="calculator__image">
                    <h3 class="calculator__heading">
                        <a href="<?php echo 'calculator_redirect/' .  $row['id']; ?>">
                            <?php echo $row['calculatorName']; ?>
                        </a>
                    </h3>
                    <span class="calculator__date">Created: <?php $time = strtotime($row['date']); echo date('d-m-Y H:i', $time) ; ?></span>
                    <a href="edit/<?php echo $row['id']; ?>" class="calculator__btn edit">Edit</a>
                    <a href="include/delete.inc.php?id=<?php echo $row['id']; ?>" class="calculator__btn delete">Delete</a>
                </div>
        <?php } ?>
            </div>
        <?php } else { ?>
            <p>You haven't created any calculators yet...</p>
        <?php } ?>
        
    </div>
    </main>
    <script src="js/sidebar.js"></script>
</body>
</html>