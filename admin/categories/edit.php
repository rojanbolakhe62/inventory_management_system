<?php

/* -------------------------------
   Database Connection
--------------------------------*/
include("../../config/database.php");

/* -------------------------------
   Start Session & Check Admin
--------------------------------*/
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../../auth/login.php");
    exit();
}

/* -------------------------------
   Get Category ID
--------------------------------*/
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$message = "";

/* -------------------------------
   Fetch Category Data
--------------------------------*/
$result = mysqli_query($conn, "SELECT * FROM categories WHERE id='$id'");
$category = mysqli_fetch_assoc($result);

/* -------------------------------
   Update Category
--------------------------------*/
if (isset($_POST['update'])) {

    $category_name = trim($_POST['category_name']);
    $description   = trim($_POST['description']);
    $status        = $_POST['status'];

    /* Check duplicate name except current ID */
    $check = mysqli_query($conn,
        "SELECT * FROM categories
         WHERE category_name='$category_name' AND id != '$id'");

    if (mysqli_num_rows($check) > 0) {

        $message = "Category already exists!";

    } else {

        $sql = "UPDATE categories SET
                category_name='$category_name',
                description='$description',
                status='$status'
                WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Update failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
    <link rel="stylesheet" href="../../assets/css/categories.css">
</head>
<body>

<div class="container">

    <h2>Edit Category</h2>

    <?php if($message!=""){ ?>
        <p class="error"><?php echo $message; ?></p>
    <?php } ?>

    <!-- Edit Form -->
    <form method="POST">

        <label>Category Name</label>
        <input type="text" name="category_name"
        value="<?php echo $category['category_name']; ?>" required>

        <label>Description</label>
        <textarea name="description" rows="3"><?php echo $category['description']; ?></textarea>

        <label>Status</label>
        <select name="status">
            <option value="active"
            <?php if($category['status']=="active") echo "selected"; ?>>
            Active
            </option>

            <option value="inactive"
            <?php if($category['status']=="inactive") echo "selected"; ?>>
            Inactive
            </option>
        </select>

        <br><br>

        <button type="submit" name="update" class="btn-save">
            Update
        </button>

        <a href="index.php" class="btn-cancel">
            Cancel
        </a>

    </form>

</div>

</body>
</html>