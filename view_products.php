
 <h3 class="text-center text-success">All Products</h3>
 <table class="table table-bordered mt-5" >
    <thead class="bg-info">
        <tr>
            <th>Product Id</th>
            <th>Product Title</th>
            <th>Product Image</th>
            <th>Product Price</th>
            <th>Total Sold</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody class="bg-secondary">
    <?php
// Fetch products
$get_products = "SELECT * FROM `products`"; // Correct SQL syntax
$result = mysqli_query($con, $get_products);

if (!$result) {
    die("Query Failed: " . mysqli_error($con)); // Error handling
}

$number = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $product_id = $row['product_id'];
    $product_title = $row['product_title'];
    $product_image1 = $row['product_image1'];
    $product_price = $row['product_price'];
    $status = $row['status'];
    $number++;
?>
    <tr class='text-center'>
        <td><?php echo $number; ?></td>
        <td><?php echo $product_title; ?></td>
        <td><img src='./product_images/<?php echo $product_image1; ?>' class='product_img' alt='<?php echo $product_title; ?>'></td>
        <td><?php echo $product_price; ?></td>
        <td>
            <?php
            // Count pending orders
            $get_count = "SELECT * FROM `orders_pending` WHERE product_id = $product_id";
            $result_count = mysqli_query($con, $get_count);

            if ($result_count) {
                $rows_count = mysqli_num_rows($result_count);
                echo $rows_count;
            } else {
                echo "0"; // Default value if query fails
            }
            ?>
        </td>
        <td><?php echo $status; ?></td>
        <td><a href='index.php?edit_products=<?php echo $product_id; ?>'><i class='fa-solid fa-pen-to-square'></i></a></td>
        <td><a href='index.php?delete_product=<?php echo $product_id; ?>'><i class='fa-solid fa-trash'></i></a></td>
    </tr>
<?php
}
?>




       
    </tbody>
 </table>
