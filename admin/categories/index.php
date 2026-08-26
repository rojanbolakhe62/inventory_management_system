<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SESSION["role"] != "admin") {
    header("Location: ../../user/dashboard.php");
    exit();
}

require_once "../../config/database.php";

// Fetch categories
$sql = "SELECT * FROM categories ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// Show SQL error if query fails
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Categories</title>

<link rel="stylesheet" href="../../assets/css/dashboard.css">
<link rel="stylesheet" href="../../assets/css/categories.index.css">



</head>
<body>

<?php include "../../includes/header.php"; ?>

<div class="dashboard">
<aside class="sidebar">
    <h3>Admin Menu</h3>

    <a href="../dashboard.php">Dashboard</a>
    <a href="../product/index.php">Products</a>
    <a href="index.php">Categories</a>
    <a href="#">Suppliers</a>
    <a href="#">Purchases</a>
    <a href="#">Sales</a>
    <a href="#">Users</a>
    <a href="#">Reports</a>
</aside>

    <main class="main-content">

        <div class="top-bar">
            <h1>Manage Categories</h1>
            <a href="add.php" class="btn">+ Add Category</a>
        </div>

        <table>

            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php if(mysqli_num_rows($result) > 0){ ?>

                <?php while($row = mysqli_fetch_assoc($result)){ ?>

                <tr>
                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>

                    <td><?php echo htmlspecialchars($row['description']); ?></td>

                    <td>
                        <?php if($row['status']=="active"){ ?>
                            <span class="active">Active</span>
                        <?php }else{ ?>
                            <span class="inactive">Inactive</span>
                        <?php } ?>
                    </td>

                    <td>
                        <a class="edit" href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>

                        <a class="delete"
                           href="delete.php?id=<?php echo $row['id']; ?>"
                           onclick="return confirm('Delete this category?')">
                           Delete
                        </a>
                    </td>
                </tr>

                <?php } ?>

            <?php }else{ ?>

                <tr>
                    <td colspan="5" style="text-align:center;">No Categories Found</td>
                </tr>

            <?php } ?>

        </table>

    </main>

</div>

<?php include "../../includes/footer.php"; ?>

</body>
</html>