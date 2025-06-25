<!-- connect file-->
<?php
 include('../includes/connect.php');
 include('../functions/common_function.php');
 session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $_SESSION['username']?></title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css file -->
     <link rel="stylesheet" href="style.css">
     <style>
      body{
        overflow-x:hidden;
      }
      .profile_img{
        width:90%;
        margin:auto;
        display:block;
        object-fit: contain;
      }
      .edit_img{
        width:100px;
        height:100px;
        object-fit: contain;
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
      <ul class="navbar-nav me-auto ">
        <li class="nav-item">
          <a class="nav-link active fs-4 fw-bold" aria-current="page" href="../cat.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="../display_all.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="profile.php">My Account</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="../cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php  cart_item();  ?></sup></a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="#"><?php total_cart_price();?>/-</a>
        </li>
      </ul>
      <!-- <form class="d-flex" action="../search_product.php" method="get">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
         <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
      </form> -->
    </div>
  </div>
</nav>
<!-- calling the cart function -->
 <?php
 cart();
 ?>
 <nav class="navbar navbar-expand-lg bg-secondary">
 <ul class="navbar-nav me-auto">
 <?php
if (!isset($_SESSION['username'])) {
    echo "<li class='nav-item'>
          <a class='nav-link fs-4 fw-bold ' href='#'>Welcome Guest</a>
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
<!-- thried child -->
 <!-- <div class="bg-light">
  <h3 class="text-center">Agro Store</h3>
  <p class="text-center"></p>
 </div> -->
 <!-- fourth child -->
  <div class="row">
    <div class="col-md-2 p-0">
   <div class="navbar-nav bg-secondary text-center " style="height:100vh">
   <li class="nav-item bg-info">
          <a class="nav-link text-light"  href="#" ><h4>Your profile</h4></a>
        </li>
        <?php
// Get the username from the session
$username = mysqli_real_escape_string($con, $_SESSION['username']);
// Query to fetch user image
$user_image_query = "SELECT * FROM `user_table` WHERE username='$username'";
$result_image = mysqli_query($con, $user_image_query);
// Check if the query executed successfully
if (!$result_image) {
    die("Query failed: " . mysqli_error($con));
}
// Fetch the user image
$row_image = mysqli_fetch_array($result_image);
if ($row_image) {
    $user_image = $row_image['user_image'];
} else {
    die("No user image found for the given username.");
}
// Display the image
echo "
<li class='nav-item'>
    <img src='./user_images/$user_image' alt='User Image' class='profile_img my-4'>
</li>
";
?>
        <li class="nav-item ">
          <a class="nav-link text-light"  href="profile.php">Pending Orders</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link text-light"  href="profile.php?edit_account" >Edit Account</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link text-light"  href="profile.php?my_orders" >My Orders</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link text-light"  href="profile.php?delete_account" >Delete Account</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link text-light"  href="users_area/logout.php" >Logout</a>
        </li>
   </ul>
    </div>
    </div>
    <div class="col-md-10 text-center">
    <?php
    // calling the function
    get_user_order_details();
    if(isset($_GET['edit_account'])){
        include('edit_account.php');
    }
    if(isset($_GET['my_orders'])){
      include('user_orders.php');
  }
  if(isset($_GET['delete_account'])){
    include('delete_account.php');
}
    ?>
    </div>
  </div>
<!-- last child-->
  <div class="bg-info p-3 text-center">
    <p>All rights reserved ©  2025  </p>
  </div>
   </div>
<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>