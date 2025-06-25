<!-- connect file-->
<?php
 include('includes/connect.php');
 include('functions/common_function.php');
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Details</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css file -->
     <link rel="stylesheet" href="style.css">
     <style>
        .cart_img{
   width:80px;
   height:80px; 
   object-fit:contain;
}
     </style>
</head>
<body>
   <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container-fluid">
   <img src="./images/logo.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active fs-4 fw-bold" aria-current="page" href="cat.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="display_all.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="./users_area/user_registration.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="Contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php  cart_item();  ?></sup></a>
        </li>
    </div>
  </div>
</nav>
<!-- calling the cart function -->
 <?php
 cart();
 ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
 <ul class="navbar-nav me-auto">
 <?php
if (!isset($_SESSION['username'])) {
    echo "<li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='#'>Welcome Guest</a>
          </li>";
} else {
    echo "<li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='#'>Welcome " . $_SESSION['username'] . "</a>
          </li>";
}
?>
        <?php
        if(!isset($_SESSION['username'])){
          echo" <li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='./users_area/user_login.php'>Login</a>
        </li>";
        } else{
          echo" <li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='./users_area/logout.php'>Logout</a>
        </li>";
        }
?>
 </ul>
</nav>
 <div class="bg-light">
  <h3 class="text-center"></h3>
  <p class="text-center"></p>
 </div>
 <div class="container">
    <div class="row">
        <form action="" method="post">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Product Title</th>
                    <th>Product Image</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <!-- <th>Remove</th>
                    <th collapse="2">Operations</th>
                </tr> -->
            </thead>
            <tbody>
                <!-- php code to display  dynamic data -->
                <?php
$get_ip_add = getIPAddress();
$total_price = 0;
// Corrected table name with backticks
$cart_query = "SELECT * FROM `cart_details` WHERE ip_address = '$get_ip_add'"; // Use backticks
$result = mysqli_query($con, $cart_query);
// Error handling for cart query
if (!$result) {
    die("Error in cart query: " . mysqli_error($con));
}
while ($row = mysqli_fetch_array($result)) {
    $product_id = $row['product_id'];
    // Corrected table name with backticks and removed extra space
    $select_products = "SELECT * FROM `products` WHERE product_id = '$product_id'"; // Removed space before $product_id
    $result_products = mysqli_query($con, $select_products);
    // Error handling for product query
    if (!$result_products) {
        die("Error in product query: " . mysqli_error($con));
    }
    while ($row_product_price = mysqli_fetch_array($result_products)) {
        $price_table = $row_product_price['product_price'];
        $product_title = $row_product_price['product_title'];
        $product_image1 = $row_product_price['product_image1'];
        // Directly adding the product price to total
        $total_price += $price_table;
?>
<tr>
    <td><?php echo $product_title; ?></td>
    <td><img src="images/<?php echo $product_image1; ?>" alt="" class="cart_img"></td>
    <td><input type="number" name="qty"  class="form-input w-50" placeholder="1">
  </td>
<!-- <?php
   $get_Ip_add=getIPAddress();
   if(isset($_POST['update_cart'])){
    $quantities=$_POST['qty'];
    $update_cart="update 'cart_details' set quantity=$quantities where ip_address='$get_ip_add'";
    $result_product_quantity=mysqli_query($con,$update_cart);
    $total_price=$total_price*$quantities;
   }
?> -->
    <td><?php echo $price_table; ?>/-</td>
    <!-- <td><input type="checkbox" name="remove_item" value="<? echo $product_id   ?>"></td>
    <!-- <td>
      
        <input type="submit" value="Update cart" class="bg-info px-3 py-2 border-0 mx-3" name="update_cart">
        
       
        <input type="submit" value="Remove cart" class="bg-info px-3 py-2 border-0 mx-3" name="remove_cart">

    </td> --> -->
</tr>

<?php
    }
}
?>      
</table>
<!-- Subtotal -->
<div class="d-flex mb-5">
    <h4 class="px-3">Subtotal: <strong class="text-info"><?php echo $total_price; ?>/-</strong></h4>
   <button class="bg-info text-decoration-none px-3 py-2 border-0 mx-3"> <a href="cat.php">Continue Shopping</a></button>
   <button class="bg-secondary p-3 py-2 border-0 text-light"> <a href="./users_area/checkout.php" class=' text-light text-decoration-none'>Checkout</a></button>
</div>
    </div>
 </div>
</form>
<!-- function to remove item-->
<!-- <?php
function remove_cart_item() {
    global $con;

    // Check if the remove_cart form is submitted
    if (isset($_POST['remove_cart'])) {
        // Iterate through each item to be removed
        if (isset($_POST['remove_item']) && is_array($_POST['remove_item'])) {
            foreach ($_POST['remove_item'] as $remove_id) {
                // Sanitize the product ID
                $remove_id = intval($remove_id);
                // Delete the item from the database
                $delete_query = "DELETE FROM `cart_details` WHERE product_id = $remove_id";
                $run_delete = mysqli_query($con, $delete_query);
                // Check if the query executed successfully
                if ($run_delete) {
                    echo "<script>alert('Item removed successfully!');</script>";
                  
                } else {
                    echo "<script>alert('Failed to remove the item: " . mysqli_error($con) . "');</script>";
                }
            }
        } //else {
        //     echo "<script>alert('No items selected for removal.');</script>";
        // }
    }
}
remove_cart_item();
?> -->
  <div class="bg-info p-3 text-center">
    <p>All rights reserved ©  2025  </p>
</div>
  </div>
   </div>
<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>