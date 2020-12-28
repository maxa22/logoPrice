<!--  getting calculator id and rendering calculator content, including steps and options -->
<?php   
    session_start();
    if(isset($_GET['id'])) {
        require_once('include/db_connection.php');
        require_once('include/functions.inc.php');
        $id = htmlspecialchars($_GET['id']);
        $errorMessage = '';
        if(!validateCalculator($id)) {
            // select calculator with matching id
            $archived = '0';
            $query = "SELECT * FROM calculator WHERE id = ? AND archived = ?";
            $stmt = $conn->stmt_init();
            if(!$stmt->prepare($query)) {
                die($stmt->error);
            }
            $stmt->bind_param('is', $id, $archived);
            $stmt->execute();
            $result = $stmt->get_result();
            $calculator = $result->fetch_assoc();
            if(!$calculator) {
                header('Location: calculators');
                exit();
            }
        }
    } else {
        header('Location: calculators');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('include/head.php'); ?>
<body style="background-color: #<?php echo $calculator['backgroundColor']; ?>; color: #<?php echo $calculator['color']; ?> ">
    <?php require_once('include/nav.php'); ?>
    <main>
        <div class="intro">
            <h1 class="intro__heading"><?php echo $calculator['heading']; ?></h1>
            <p class="intro__paragraph"><?php echo $calculator['calculatorText']; ?></p>
            <button class="intro__button"><?php echo $calculator['button']; ?></button>
            <?php if($calculator['logo']) { ?>
                <div class="intro__logo">
                    <img src="<?php base();?>images/calculator_logo/<?php echo $calculator['logo']?>" alt="calculator logo">
                </div>
            <?php } ?>
        </div>
        
            <?php
                $query = "SELECT * FROM step WHERE calculator_id = ?";
                $stepResult = select($conn, $calculator['id'], $query);
                if($stepResult->num_rows > 0) { ?>
                <form action="<?php base(); ?>estimate" method="POST">
                <?php while($stepRow = $stepResult->fetch_assoc()) { ?>

                    <div class="input-wrapper step-<?php echo $stepRow['id']; ?>">
                        <h2><?php echo $stepRow['stepName']; ?></h2>
                        <div class="input-wrapper__options">
                            <?php  
                                $query = "SELECT * FROM options WHERE step_id = ?";
                                $optionResult = select($conn, $stepRow['id'], $query);
                                while($optionRow = $optionResult->fetch_assoc()) { ?>

                                <div>
                                    <input type="radio" name="<?php echo $stepRow['id'] . '-answer'; ?>" id="<?php echo $optionRow['optionName']  . '-' . $stepRow['id']; ?> " value="<?php echo $stepRow['id'] . '-answer-' . $optionRow['id']; ?> ">
                                    <label for="<?php echo $optionRow['optionName'] . '-' . $stepRow['id']; ?> " class="option__label">
                                        <span class="option__image-container">
                                            <?php if($optionRow['optionImage']) { ?>
                                                <img src="<?php base(); ?>images/<?php echo $optionRow['optionImage'] ?>" alt="<?php echo $optionRow['optionName']; ?>" class="option__image">
                                            <?php } ?>
                                    </span>
                                        <h3><?php echo $optionRow['optionName'] ?></h3>
                                    </label>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="input-wrapper">
                    <button name="submit" class="intro__button">Get your price estimate</button>                     
                </div>
                </form>
                
            <?php } else { ?>
                <div class="input-wrapper">
                    <p>No default calculator or no questions added to current calculator...</p>
                </div>
            <?php } ?>
    </main>
    <script src="<?php base(); ?>js/script.js"></script>
    <script src="<?php base(); ?>js/checkIframe.js"></script>
</body>
</html>