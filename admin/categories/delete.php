<?php
/* Connect to the database */
include '../../config/database.php';

/* Check if category ID is received */
if (isset($_GET['id'])) {

    /* Get the category ID */
    $id = $_GET['id'];

    /* Delete category from database */
    $sql = "DELETE FROM categories WHERE id = $id";

    /* Run the query */
    if (mysqli_query($conn, $sql)) {

        /* Go back to category list */
        header("Location: index.php");
        exit();

    } else {

        /* Show error if deletion fails */
        echo "Error deleting category: " . mysqli_error($conn);
    }

} else {

    /* If ID is not provided */
    echo "Category ID not found.";
}
?>