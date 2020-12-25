<!--  getting the id of the calculator to render the steps and options  -->
<?php

    session_start();
    if(!isset($_SESSION['fullName'])) {
        header('Location: login');
        exit();
    }
    if(isset($_GET['id'])){
        require_once('include/db_connection.php');
        require_once('include/functions.inc.php');
        $id = $_GET['id'];
        $query = "SELECT * FROM calculator WHERE id = ?";
        $calculator = selectOne($conn, $id, $query);
        if($calculator['user_id'] !== $_SESSION['id']) {
            header('Location: index');
            exit();
        }
        $_SESSION['calculator_id'] = $calculator['id'];
    } else {
        header('Location: calculators');
    }
?>

<!DOCTYPE html>
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/admin/admin_nav.php'); ?>
    <?php require_once('include/admin/admin_sidebar.php'); ?>
    <main>
    <div class="main__heading"><h1><?php echo $calculator['calculatorName']; ?></h1></div>
    <?php
    $query = "SELECT * FROM step WHERE calculator_id = ?";
    $stepResult = select($conn, $id, $query);
    if($stepResult->num_rows > 0) { 
    ?>
    <form action="<?php base(); ?>include/edit.inc.php" enctype="multipart/form-data" method="POST">
        <?php
            while($stepRow = $stepResult->fetch_assoc()) { ?>
            <div class="form" data-id="<?php echo $calculator['id'] . '-' . $stepRow['id']; ?>">
                <div class="edit-form__question-container" >
                    <h3>Question</h3>
                    <input type="text" name="<?php echo $calculator['id'] . '-' . $stepRow['id'] . '-question'; ?>" disabled value="<?php echo $stepRow['stepName']; ?>">
                    <div class="edit-form__icons">  
                        <span class="edit-icon">
                            <i class="fas fa-edit"></i>
                        </span>
                        <a href="../include/delete_step.inc.php?calc_id=<?php echo $calculator['id'] . '&id=' . $stepRow['id']; ?>"" class="delete-icon">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                    <button name="saveQuestion" class="save">Save</button>
                    <button class="cancel">Cancel</button>
                </div>
                <div class="calculator-option">
                    <?php
                        $i = 0;  
                        $query = "SELECT * FROM options WHERE step_id = ?";
                        $optionResult = select($conn, $stepRow['id'], $query);
                        while($optionRow = $optionResult->fetch_assoc()) { ?>
                        <div class="edit-form__option">
                            <h3>Option <?php echo ++$i; ?></h3>
                            <div>
                                <label for="<?php echo $optionRow['id'] . '-optionName'; ?>">Name</label>
                                <input type="text" disabled name="<?php echo $calculator['id'] . '-' . $optionRow['id'] . '-optionName'; ?>" id="<?php echo $optionRow['id'] . '-optionName'; ?>" value="<?php echo $optionRow['optionName']; ?>">
                            </div>
                            <div>
                                <label for="<?php echo $optionRow['id'] . '-' . $optionRow['optionPrice']; ?>">Price</label>
                                <input type="text" disabled name="<?php echo $optionRow['id'] . '-optionPrice'; ?>" id="<?php echo $optionRow['id'] . '-optionPrice'; ?>" value="<?php echo $optionRow['optionPrice']; ?>">
                            </div>
                            <div>
                                <label for="<?php echo $optionRow['id'] . '-optionImage'; ?>" class="file__label">Upload Image</label>
                                <input type="file" disabled name="<?php echo $optionRow['id'] . '-optionImage'; ?>" id="<?php echo $optionRow['id'] . '-optionImage'; ?>" value="<?php echo $optionRow['optionImage']; ?>">
                                <span class="file__name"></span>
                            </div>
                            <div class="edit-form__icons">
                                <span class="edit-icon">
                                    <i class="fas fa-edit"></i>
                                </span>
                                <a href="../include/delete_option.inc.php?calc_id=<?php echo $calculator['id'] . '&id=' . $optionRow['id']; ?>" class="delete-icon">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                            <div class="edit-buttons">
                                <button class="save" name="saveOptions">Save</button>
                                <button class="cancel">Cancel</button>    
                            </div>
                        </div>
                        <?php } ?>
                </div>
                <button class="add-option">Add option</button>
            </div>
            <?php } ?>
    </form>
    <?php } else { ?>
    <div>
        <p>Sorry, you don't have any questions in your calculator.</p>
    </div>
    <?php } ?>
    <a href="<?php base(); ?>add_question/<?php echo $id; ?>" id="redirect-link">Add question</a>
    </main>
    <script src="<?php base(); ?>js/sidebar.js"></script>
    <script src="<?php base(); ?>js/edit.js"></script>
</body>
</html>