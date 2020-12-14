<header>
    <nav class="navigation">
        <a href="index.php" class="navigation__link logo">LOGOTIP</a>
        <ul class="navigation__menu">
            <?php if(isset($_SESSION['fullName'])) { ?>
                <li><a href="admin.php" class="navigation__link">Admin</a></li>
                <li><a href="include/logout.inc.php" class="navigation__link">Logout</a></li>
            <?php } else { ?>
                <li><a href="login.php" class="navigation__link">Login</a></li>
                <li><a href="register.php" class="navigation__link">Register</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>