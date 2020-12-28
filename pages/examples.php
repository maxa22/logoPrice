<!--  rendering user calculators -->
<?php
    session_start();
    require_once('include/db_connection.php');
    require_once('include/functions.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/nav.php'); ?>
    <main>
    <div class="main__heading">
        <h1>Examples</h1>
    </div>
    <?php 
        $default = '1';
        $query = "SELECT * FROM calculator WHERE defaultCalculators = ?";
        $stmt = $conn->stmt_init();
        if(!$stmt->prepare($query)) {
            die($stmt->error);
        }
        $stmt->bind_param('s', $default);
        $stmt->execute();
        $calculators = $stmt->get_result();
        $stmt->close();
        $conn->close();
        if($calculators->num_rows > 0) { ?>
            <div class="calculator__wrapper">
            <?php while($row = $calculators->fetch_assoc()) { ?>
                <div class="calculator">
                    <img src="images/calculator.svg" alt="calculator" class="calculator__image">
                    <h3><?php echo $row['calculatorName']; ?></h3>
                    <p class="intro__paragraph"><?php echo $row['calculatorText']; ?></p>
                    <a class="intro__button" href="calculator_redirect/<?php echo $row['id']; ?>">Check it out</a>
                </div>
        <?php } ?>
            </div>
        <?php } else { ?>
            <p>No default calculators selected by admin...</p>
        <?php } ?>
        
    </div>
    </main>
</body>
</html>