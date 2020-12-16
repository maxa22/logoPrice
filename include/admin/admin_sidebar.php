
<aside class="sidebar">
    <div class="sidebar__user">
        <img src="images/avatar.png" alt="">
        <h4><?php echo $_SESSION['fullName']; ?></h4>
    </div>
    <ul class="sidebar__menu">
        <li>
            <a href="admin.php" class="sidebar__menu-link">
                <span>
                    <span class="sidebar__menu-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </span>
                </span>
                <span  class="sidebar__menu-text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="create_calc.php" class="sidebar__menu-link">
                <span>
                    <span class="sidebar__menu-icon">
                        <i class="fas fa-plus-circle"></i>
                    </span>
                </span>
                <span class="sidebar__menu-text">Create Calculator</span>
            </a>
        </li>
    </ul>
</aside>
<div class="sidebar-overlay"></div>