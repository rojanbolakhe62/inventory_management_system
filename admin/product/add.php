<?php
/* Connect to the database */
include '../../config/database.php';

/* Get all categories */
$category_sql = "SELECT * FROM categories WHERE status = 'active' ORDER BY category_name ASC";
$category_result = mysqli_query($conn, $category_sql);

/* Check if form is submitted */
if (isset($_POST['submit'])) {

    /* Get form values */
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    /* Insert product into database */
    $sql = "INSERT INTO products
            (product_name, category_id, quantity, price, description, status)
            VALUES
            ('$product_name', '$category_id', '$quantity', '$price', '$description', '$status')";

    /* Run query */
    if (mysqli_query($conn, $sql)) {

        /* Go back to product list */
        header("Location: index.php");
        exit();

    } else {

        /* Display error */
        $error = "Error adding product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Product</title>

    <!-- Product add page CSS -->
    <link rel="stylesheet" href="../../assets/css/product_add.css">
</head>

<body>

<div class="container">

    <h1>Add Product</h1>

    <!-- Display error -->
    <?php if (isset($error)) { ?>
        <p class="error"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST">

        <!-- Product name -->
        <div class="form-group">
            <label>Product Name</label>

            <input type="text"
                   name="product_name"
                   placeholder="Enter product name"
                   required>
        </div>

        <!-- Category -->
        <div class="form-group">
            <label>Category</label>

            <select name="category_id" required>

                <option value="">Select Category</option>

                <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>

                    <option value="<?php echo $category['id']; ?>">
                        <?php echo htmlspecialchars($category['category_name']); ?>
                    </option>

                <?php } ?>

            </select>
        </div>

        <!-- Quantity -->
        <div class="form-group">
            <label>Quantity</label>

            <input type="number"
                   name="quantity"
                   min="0"
                   placeholder="Enter quantity"
                   required>
        </div>

        <!-- Price -->
        <div class="form-group">
            <label>Price</label>

            <input type="number"
                   name="price"
                   step="0.01"
                   min="0"
                   placeholder="Enter price"
                   required>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label>Description</label>

            <textarea name="description"
                      placeholder="Enter product description"></textarea>
        </div>

        <!-- Status -->
        <div class="form-group">
            <label>Status</label>

            <select name="status">

                <option value="active">Active</option>

                <option value="inactive">Inactive</option>

            </select>
        </div>

        <!-- Buttons -->
        <div class="buttons">

            <button type="submit" name="submit" class="save-btn">
                Save Product
            </button>

            <a href="index.php" class="cancel-btn">
                Cancel
            </a>

        </div>

    </form>

</div>

</body>
</html>