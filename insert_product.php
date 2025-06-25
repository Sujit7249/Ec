<?php
include('../includes/connect.php');

if (isset($_POST['insert_product'])) {
    // Fetch form data
    $product_title = $_POST['product_title'];
    $description = $_POST['description'];
    $products_keywords = $_POST['products_keywords'];
    $product_category = $_POST['product_category'];
    $product_price = $_POST['product_price'];
    $product_status = 'true';
    // Access images
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];
    // Access temporary image names
    $temp_image1 = $_FILES['product_image1']['tmp_name'];
    $temp_image2 = $_FILES['product_image2']['tmp_name'];
    $temp_image3 = $_FILES['product_image3']['tmp_name'];
    // Check if any field is empty
    if (
        empty($product_title) || empty($description) || empty($products_keywords) ||
        empty($product_category) || empty($product_price) || empty($product_image1) ||
        empty($product_image2) || empty($product_image3)
    ) {
        echo "<script>alert('Please fill all the available fields.')</script>";
        exit();
    } else {
        // Move uploaded images to the specified folder Server side to be uploaded 
        move_uploaded_file($temp_image1, "./product_images/$product_image1");
        move_uploaded_file($temp_image2, "./product_images/$product_image2");
        move_uploaded_file($temp_image3, "./product_images/$product_image3");
        // Insert query
        $insert_products = "INSERT INTO `products` 
            (product_title, product_description, product_keywords, category_id, 
             product_image1, product_image2, product_image3, product_price, date, status) 
            VALUES 
            ('$product_title', '$description', '$products_keywords', '$product_category', 
             '$product_image1', '$product_image2', '$product_image3', '$product_price', NOW(), '$product_status')";
        // Execute query
        $result_query = mysqli_query($con, $insert_products);
        // Check if the query was successful
        if ($result_query) {
            echo "<script>alert('Successfully inserted product.')</script>";
        } else {
            echo "<script>alert('Failed to insert product: " . mysqli_error($con) . "')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products-Admin Dashboard</title>
     <!-- bootstratp css link -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- font awesome link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- css file -->
<link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Products</h1>
        <!-- form-->
         <form action="" method="post" enctype="multipart/form-data">
            <!-- title-->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter product title" autocomplete="off" required="required">
            </div>
            <!-- description-->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Product description</label>
                <input type="text" name="description" id="description" class="form-control" placeholder="Enter product description" autocomplete="off" required="required">
            </div>
            <!-- keywords-->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="products_keywords" class="form-label">Products keywords</label>
                <input type="text" name="products_keywords" id="products_keywords" class="form-control" placeholder="Enter Products keywords" autocomplete="off" required="required">
            </div>
             <!-- categories-->
             <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_category" id="" class="form-select">
                <option value="">Select a Category</option>
                <?php
// Query to fetch categories (using correct syntax)
$select_query = "SELECT * FROM `categories`";
// Execute the query
$result_query = mysqli_query($con, $select_query);
// Check if the query execution was successful
if (!$result_query) {
    die("Query failed: " . mysqli_error($con));
}
// Check if any rows are returned
if (mysqli_num_rows($result_query) > 0) {
    while ($row = mysqli_fetch_assoc($result_query)) {
        $category_title = htmlspecialchars($row['category_title']); // Escaping for safety
        $category_id = htmlspecialchars($row['category_id']); // Escaping for safety
        
        // Generate the HTML for the dropdown
        echo "<option value='$category_id'> $category_title</option>";
    }
} else {
    echo "<option value=''>No categories available</option>"; // If no data is found
}
?>            
            </select>
            </div>
            <!-- Image 1-->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class="form-label">Products Image 1</label>
                <input type="file" name="product_image1" id="product_image1" class="form-control" required="required">
            </div>
              <!-- Image 2-->
              <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class="form-label">Products Image 2</label>
                <input type="file" name="product_image2" id="product_image2" class="form-control" required="required">
            </div>
              <!-- Image 3-->
              <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image3" class="form-label">Products Image 3</label>
                <input type="file" name="product_image3" id="product_image3" class="form-control" required="required">
            </div>
            <!-- Price-->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product price</label>
                <input type="text" name="product_price" id="product_price" class="form-control" placeholder="Enter Products price" autocomplete="off" required="required">
            </div>
            <!-- Button-->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product"  class="btn btn-info mb-3 px-3" value="Insert Product">
            </div>
         </form>
    </div> 
</body>
</html>