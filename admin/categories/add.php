<?php

/* -------------------------------
   Database Connection
--------------------------------*/
include("../../config/database.php");

/* -------------------------------
   Start User Session
--------------------------------*/
session_start();

/* -------------------------------
   Check Admin Login
   If user is not admin, redirect
--------------------------------*/
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../../auth/login.php");
    exit();
}

/* Variable to store error message */
$message = "";

/* -----------------------------------------
   Add Category
   Execute when Save button is clicked
------------------------------------------*/
if (isset($_POST['save'])) {

    /* Get form data */
    $category_name = trim($_POST['category_name']);
    $description   = trim($_POST['description']);
    $status        = $_POST['status'];

    /* Check category name is empty or not */
    if (!empty($category_name)) {

        /* Check duplicate category */
        $check = mysqli_query($conn,
            "SELECT * FROM categories
             WHERE category_name='$category_name'");

        if (mysqli_num_rows($check) > 0) {

            $message = "Category already exists!";

        } else {

            /* Insert category into database */
            $sql = "INSERT INTO categories
                    (category_name, description, status)
                    VALUES
                    ('$category_name','$description','$status')";

            if (mysqli_query($conn, $sql)) {

                /* Redirect to category list */
                header("Location: index.php");
                exit();

            } else {

                $message = "Database Error!";

            }
        }

    } else {

        $message = "Category name is required.";

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>

    <!-- Categories CSS -->
    <link rel="stylesheet" href="../../assets/css/categories.css">
</head>
<body>

<div class="container">

    <h2>Add New Category</h2>

    <!-- Display Error Message -->
    <?php if($message != "") { ?>
        <p class="error"><?php echo $message; ?></p>
    <?php } ?>

    <!-- Category Form -->
    <form method="POST">

        <label>Category Name</label>
        <input type="text" name="category_name" required>

        <label>Description</label>
        <textarea name="description" rows="3"></textarea>

        <label>Status</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <br><br>

        <!-- Save Button -->
        <button type="submit" name="save" class="btn-save">
            Save
        </button>

        <!-- Cancel Button -->
        <a href="index.php" class="btn-cancel">
            Cancel
        </a>

    </form>

</div>

</body>
</html>