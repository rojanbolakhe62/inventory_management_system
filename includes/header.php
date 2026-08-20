<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<header class="main-header">

    <div class="header-left">

        <h2>Inventory Management System</h2>

    </div>


    <div class="header-right">

        <span>
            Welcome,
            <strong>
                <?php echo htmlspecialchars($_SESSION["full_name"] ?? "User"); ?>
            </strong>
        </span>

        <a href="../auth/logout.php" class="logout-btn">
            Logout
        </a>

    </div>

</header>