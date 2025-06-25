<?php
include('../includes/connect.php');
// Check if the connection is successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
// SQL query to fetch categories and their products
$query = "SELECT c.category_title, p.product_name, p.product_price 
          FROM categories c
          JOIN products p ON c.category_id = p.category_id
          ORDER BY c.category_title, p.product_name";
$result = mysqli_query($con, $query);

// Check if the query executed successfully
if (!$result) {
    die("Error executing query: " . mysqli_error($con));
}
$current_category = null;

// Process the results
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Display category title when it changes
        if ($current_category !== $row['category_title']) {
            $current_category = $row['category_title'];
            echo "<h3>" . htmlspecialchars($current_category) . "</h3>";
        }
        // Display product details
        echo "<p>Product: " . htmlspecialchars($row['product_name']) . " - Price: $" . htmlspecialchars($row['product_price']) . "</p>";
    }
} else {
    echo "<p>No products found.</p>";
}
?>
