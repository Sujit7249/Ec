<?php
include('../includes/connect.php');
// Check if the connection is successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['insert_cat'])) {
    // Sanitize user input
    $category_title = trim($_POST['cat_title']);
    // Check if the category title is not empty
    if (!empty($category_title)) {
        $stmt = $con->prepare("INSERT INTO `categories` (category_title) VALUES (?)");
        $stmt->bind_param("s", $category_title);
        // Execute the query and check for errors
        if ($stmt->execute()) {
            echo "<script>alert('Category has been inserted successfully');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Please enter a category title');</script>";
    }
}
?>
<h2 class="text-center">Insert Categories</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
  <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
  <input type="text" class="form-control" name="cat_title" placeholder="Insert categories" aria-label="Categories" aria-describedby="basic-addon1">
</div>
<div class="input-group w-10 mb-2 m-auto">
<input type="submit" class=" bg-info border-0 p-2 my-3" name="insert_cat" value="insert categories">

</div>
</form>