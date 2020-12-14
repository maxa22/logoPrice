<?php
    require_once('include/db_connection.php');
    require_once('include/functions.inc.php');
    $errorMessage = '';
    if(isset($_POST['submit'])) {
        
        $fullName = trim($_POST['fullName']);
        $email = trim($_POST['email']);
        $password = trim( $_POST['password']);
        $confirmPassword = trim( $_POST['confirmPassword']);

        if(!validateUserInput($conn, $fullName, $email, $password, $confirmPassword)) {
            createUser($conn, $fullName, $email, $password);
            header('Location: index.php?error=none');
        } else {
            $errorMessage = validateUserInput($fullName, $email, $password, $confirmPassword, $conn);
        }

    }
?>

<!DOCTYPE html>
<html>
<?php require_once('include/head.php'); ?>
<body>
    <?php require_once('include/nav.php'); ?>
    <main>
        
            <form action="" method="POST" class="registration-form form login">
            <div class="main__heading">
                <h1>Register</h1>
            </div>
            <div>
                <label for="name">Full Name</label> <br>
                <input type="text" name="fullName" id="fullName">
            </div>
            <div>
                <label for="name">Email Address</label> <br>
                <input type="text" name="email" id="email">
            </div>
            <div>
                <label for="password">Password</label> <br>
                <input type="password" name="password" id="password">
            </div>
            <div>
                <label for="confirm-password">Confirm Password</label> <br>
                <input type="password" name="confirmPassword" id="confirm-password">
            </div>
            <button type="submit" name="submit">Register</button>
        </form>
    <?php echo $errorMessage ?? ''; ?>
</main>
</body>
</html>