<?php 
if (isset($_GET['delete_product'])) {
    $delete_id = $_GET['delete_product'];
    // Delete query with corrected syntax
    $delete_product = "DELETE FROM `products` WHERE product_id = $delete_id";
    // Execute the query
    $result_product = mysqli_query($con, $delete_product);
    // Check if the query was successful
    if ($result_product) {
        echo "<script>alert('Product deleted successfully');</script>";
        echo "<script>window.open('./index.php', '_self');</script>";
    } else {
        // Print error for debugging
        echo "<script>alert('Failed to delete product: " . mysqli_error($con) . "');</script>";
    }
}
?>
