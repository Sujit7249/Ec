<?php
if (isset($_GET['edit_category'])) {
    $edit_category = $_GET['edit_category'];
    $get_categories = "SELECT * FROM categories WHERE category_id = $edit_category";
    $result = mysqli_query($con, $get_categories);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category_title = $row['category_title'];
    } else {
        echo "Category not found.";
    }
    if (isset($_POST['edit_cat'])) {
        $cat_title = $_POST['category_title'];
    
        // Prepare the SQL statement
        $stmt = $con->prepare("UPDATE `categories` SET `category_title` = ? WHERE `category_id` = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($con->error));
        }
        // Bind parameters
        $bind = $stmt->bind_param('si', $cat_title, $edit_category);
        if ($bind === false) {
            die('Bind failed: ' . htmlspecialchars($stmt->error));
        }
        // Execute the statement
        $exec = $stmt->execute();
        if ($exec === false) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        } else {
            echo "<script>alert('Category has been updated successfully');</script>";
            echo "<script>window.open('./index.php?view_categories','_self');</script>";
        }
        // Close the statement
        $stmt->close();
    }
}
?>
<div class="container mt-3">
    <h1 class="text-center">Edit Category</h1>
    <form action="" method="post" class="text-center">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="category_title" class="form-label">Category Title</label>
            <input type="text" name="category_title" id="category_title" class="form-control" required="required" value="<?php echo $category_title?>"> 
        </div>
        <input type="submit" value="Update Category" class="btn btn-info px-3 mb-3" name="edit_cat">
    </form>
</div>