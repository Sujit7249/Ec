<?php
if (isset($_GET['edit_products'])) {
    $edit_id = $_GET['edit_products'];
    // Fetch product data
    $get_data = "SELECT * FROM `products` WHERE product_id = $edit_id";
    $result = mysqli_query($con, $get_data);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_keywords = $row['product_keywords'];
        $category_id = $row['category_id'];
        $product_image1 = $row['product_image1'];
        $product_image2 = $row['product_image2'];
        $product_image3 = $row['product_image3'];
        $product_price = $row['product_price'];
    } else {
        die("No product found with the given ID.");
    }
    // Fetch category name
    $select_category = "SELECT * FROM `categories` WHERE category_id = $category_id";
    $result_category = mysqli_query($con, $select_category);
    if ($result_category && mysqli_num_rows($result_category) > 0) {
        $row_category = mysqli_fetch_assoc($result_category);
        $category_title = $row_category['category_title'];
    } else {
        $category_title = "Unknown Category";
    }
}
?>
<div class="container mt-5">
    <h1 class="text-center">Edit Products</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" id="product_title" value="<?php echo $product_title ?>" name="product_title" class="form-control" required>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_desc" class="form-label">Product Description</label>
            <input type="text" id="product_desc" value="<?php echo $product_description ?>" name="product_desc" class="form-control" required>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_keywords" class="form-label">Product Keywords</label>
            <input type="text" id="product_keywords" value="<?php echo $product_keywords ?>" name="product_keywords" class="form-control" required>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_category" class="form-label">Product Category</label>
            <select name="product_category" class="form-select">
                <option value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                <?php
                // Fetch all categories dynamically
                $select_category_all = "SELECT * FROM `categories`";
                $result_category_all = mysqli_query($con, $select_category_all);

                while ($row_category_all = mysqli_fetch_assoc($result_category_all)) {
                    $category_title_all = $row_category_all['category_title'];
                    $category_id_all = $row_category_all['category_id'];
                    echo "<option value='$category_id_all'>$category_title_all</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image1" class="form-label">Product Image1</label>
            <div class="d-flex">
                <input type="file" id="product_image1" name="product_image1" class="form-control w-90 m-auto" required>
                <img src="../admin_area/product_images/<?php echo $product_image1 ?>" alt="Product Image 1" class="product_img">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image2" class="form-label">Product Image2</label>
            <div class="d-flex">
                <input type="file" id="product_image2" name="product_image2" class="form-control w-90 m-auto" required>
                <img src="../admin_area/product_images/<?php echo $product_image2 ?>" alt="Product Image 2" class="product_img">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image3" class="form-label">Product Image3</label>
            <div class="d-flex">
                <input type="file" id="product_image3" name="product_image3" class="form-control w-90 m-auto" required>
                <img src="../admin_area/product_images/<?php echo $product_image3 ?>" alt="Product Image 3" class="product_img">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="text" id="product_price" value="<?php echo $product_price ?>" name="product_price" class="form-control" required>
        </div>
        <div class="w-50 m-auto">
            <input type="submit" name="edit_product" value="Update Product" class="btn btn-info px-3 mb-3">
        </div>
    </form>
</div>
<!-- edting product -->
<?php
if (isset($_POST['edit_product'])) {
    // Retrieve form data
    $product_title = $_POST['product_title'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];
    $product_category = $_POST['product_category'];
    $product_price = $_POST['product_price'];

    // Retrieve uploaded images
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];

    $temp_image1 = $_FILES['product_image1']['tmp_name'];
    $temp_image2 = $_FILES['product_image2']['tmp_name'];
    $temp_image3 = $_FILES['product_image3']['tmp_name'];

    // Check for empty fields
    if (
        $product_title == '' || $product_desc == '' || $product_keywords == '' || $product_category == '' ||
        $product_image1 == '' || $product_image2 == '' || $product_image3 == '' || $product_price == ''
    ) {
        echo "<script>alert('Please fill all the fields and continue the process');</script>";
    } else {
        // Move uploaded files to the designated folder
        move_uploaded_file($temp_image1, "../admin_area/product_images/$product_image1");
        move_uploaded_file($temp_image2, "../admin_area/product_images/$product_image2");
        move_uploaded_file($temp_image3, "../admin_area/product_images/$product_image3");

        // Update query
        $update_product = "UPDATE `products` 
            SET category_id = '$product_category',
                product_title = '$product_title',
                product_description = '$product_desc',
                product_keywords = '$product_keywords',
                product_image1 = '$product_image1',
                product_image2 = '$product_image2',
                product_image3 = '$product_image3',
                product_price = '$product_price',
                date = NOW() 
            WHERE product_id = $edit_id";

        $result_update = mysqli_query($con, $update_product);

        if ($result_update) {
            echo "<script>alert('Product updated successfully');</script>";
            echo "<script>window.open('./index.php', '_self');</script>";
        } else {
            echo "<script>alert('Failed to update product: " . mysqli_error($con) . "');</script>";
        }
    }
}
?>
