<?php
/* Start session */
session_start();

/* Check login */
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../auth/login.php");
    exit();
}

/* Only admin can access */
if ($_SESSION["role"] != "admin") {
    header("Location: ../../user/dashboard.php");
    exit();
}

/* Connect database */
include "../../config/database.php";

/* Get all products with category name */
$sql = "SELECT products.*, categories.category_name
        FROM products
        INNER JOIN categories
        ON products.category_id = categories.id
        ORDER BY products.id DESC";

$result = mysqli_query($conn, $sql);

/* Show SQL error if query fails */
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Products</title>

<!-- Dashboard CSS -->
<link rel="stylesheet" href="../../assets/css/dashboard.css">

<!-- Product CSS -->
<link rel="stylesheet" href="../../assets/css/product.css">

</head>
<body>

<!-- Header -->
<?php include "../../includes/header.php"; ?>

<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">

        <h3>Admin Menu</h3>

        <a href="../dashboard.php">Dashboard</a>
        <a href="index.php">Products</a>
        <a href="../categories/index.php">Categories</a>
        <a href="#">Suppliers</a>
        <a href="#">Purchases</a>
        <a href="#">Sales</a>
        <a href="#">Users</a>
        <a href="#">Reports</a>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

        <div class="container">

            <h1>Products</h1>

            <!-- Add Product Button -->
            <a href="add.php" class="add-btn">+ Add Product</a>

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                /* Check if product exists */
                if (mysqli_num_rows($result) > 0) {

                    /* Display all products */
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>

                    <tr>

                        <td><?php echo $row["id"]; ?></td>

                        <td><?php echo htmlspecialchars($row["product_name"]); ?></td>

                        <td><?php echo htmlspecialchars($row["category_name"]); ?></td>

                        <td><?php echo $row["quantity"]; ?></td>

                        <td>Rs. <?php echo number_format($row["price"], 2); ?></td>

                        <td><?php echo htmlspecialchars($row["description"]); ?></td>

                        <td>

                            <?php if ($row["status"] == "active") { ?>

                                <span class="active">Active</span>

                            <?php } else { ?>

                                <span class="inactive">Inactive</span>

                            <?php } ?>

                        </td>

                        <td>

                            <!-- Edit Button -->
                            <a class="edit"
                               href="edit.php?id=<?php echo $row['id']; ?>">
                               Edit
                            </a>

                            <!-- Delete Button -->
                            <a class="delete"
                               href="delete.php?id=<?php echo $row['id']; ?>"
                               onclick="return confirm('Delete this product?')">
                               Delete
                            </a>

                        </td>

                    </tr>

                <?php
                    }

                } else {
                ?>

                    <!-- No product found -->
                    <tr>

                        <td colspan="8" class="no-data">
                            No products found.
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </main>

</div>

<!-- Footer -->
<?php include "../../includes/footer.php"; ?>

</body>
</html>