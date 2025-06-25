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
    <title>Agro Home</title>
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
     </style>
</head>
<body>
   <div class="container-fluid p-0 ">
  <nav class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container-fluid">
   <img src="./images/logo.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto ">
        <li class="nav-item">
          <a class="nav-link active fs-4 fw-bold" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="display_all.php">Products</a>
        </li>
        <?php
if(isset($_SESSION['username'])){
  echo "<li class='nav-item'>
   <a class='nav-link fs-4 fw-bold' href='./users_area/profile.php'>My Account</a>
  </li>";
}else{
  echo "<li class='nav-item'>
   <a class='nav-link fs-4 fw-bold' href='./users_area/user_registration.php'>Register</a>
  </li>";
}
        ?>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="Contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php  cart_item();  ?></sup></a>
        </li>
        <li class="nav-item fs-4 fw-bold">
          <a class="nav-link" href=""><?php total_cart_price();?>/-</a>
        </li>
      </ul>
      <ul class="navbar-nav">
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
    </div>
  </div>
</nav>
 <?php
 cart();
 ?>
 <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
 <form class="d-flex " action="search_product.php" method="get">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
         <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
      </form>
</nav>
<div class="d-flex ">
<div class="col-md-2 bg-secondary p-0">
      <ul class="navbar-nav me-auto text-center">
        <li class="nav-item bg-info">
          <a href="#" class="nav-link text-light"><h4>Categories</h4></a>
          </li>     
          <?php
          getcategories();
?>
      </div>
  <div class="row px-1" >
    <div class="row" >
 <?php
 // calling function
 search_product();
 getproducts();
 get_unique_categories();
 $ip = getIPAddress();  
 echo 'User Real IP Address - '.$ip;   
  ?>
    </div>
</div>
</div> 
    </div>
  </div>
  <div class="bg-info p-3 text-center">
    <p>All rights reserved ©  2025  </p>
  </div>
   </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>