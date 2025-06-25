<?php
if (isset($_GET['delete_category'])) {
    $delete_category = $_GET['delete_category'];
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $con->prepare("DELETE FROM categories WHERE category_id = ?");
    if ($stmt === false) {
        // Handle error in preparing the statement
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }
    // Bind the parameter to the statement
    $bind = $stmt->bind_param('i', $delete_category);
    if ($bind === false) {
        // Handle error in binding parameters
        die('Bind failed: ' . htmlspecialchars($stmt->error));
    }
    // Execute the statement
    $exec = $stmt->execute();
    if ($exec === false) {
        // Handle error in execution
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    } else {
        // Success message
        echo "<script>alert('Category has been deleted successfully');</script>";
        echo "<script>window.open('./index.php?view_categories','_self');</script>";
    }
    // Close the statement
    $stmt->close();
}
?>
