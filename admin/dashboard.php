<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION["role"] !== "admin") {
    header("Location: ../user/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Inventory Management System</title>

    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

<?php include "../includes/header.php"; ?>

<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">

   <aside class="sidebar">

    <h3>Admin Menu</h3>

    <a href="dashboard.php">Dashboard</a>
    <a href="product/index.php">Products</a>
    <a href="categories/index.php">Categories</a>
    <a href="#">Suppliers</a>
    <a href="#">Purchases</a>
    <a href="#">Sales</a>
    <a href="#">Users</a>
    <a href="#">Reports</a>

</aside>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <h1>Admin Dashboard</h1>

        <div class="cards">

            <div class="card">
                <h3>Total Products</h3>
                <p>0</p>
            </div>

            <a href="categories/index.php" class="card">
                <h3>Total Categories</h3>
                <p>Manage Categories</p>
            </a>

            <div class="card">
                <h3>Total Suppliers</h3>
                <p>0</p>
            </div>

            <div class="card">
                <h3>Total Sales</h3>
                <p>0</p>
            </div>

        </div>

        <div class="welcome-box">

            <h2>Welcome to Inventory Management System</h2>

            <p>You are logged in as an Administrator.</p>

            <p>
                From this dashboard, you can manage Products, Categories,
                Suppliers, Purchases, Sales, Users, and Reports.
            </p>

        </div>

    </main>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>