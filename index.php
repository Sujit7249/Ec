<!-- connect file-->
<?php
 include('../includes/connect.php');
 include('../functions/common_function.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- bootstratp css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- css file -->
 <link rel="stylesheet" href="../style.css">
 <style>
    .admin_image{
    width:100px;
    object-fit:contain;
    }
    .footer{
        position:absolute;
        bottom:0;
    }
    body{
        overflow-x:hidden;
    }
    .product_img{
        width:100px;
        object-fit:contain;
    }
 </style>
</head>
<body>
   <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child-->
        <nav class="navbar navbar-expand navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images/logo.png" alt="" class="logo" >
                <nav class="navbar navbar-expand">
                    <ul class="navbar-nav">
                    <!-- <?php

if (!isset($_SESSION['username'])) {
    echo "<li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='#'>Welcome Guest</a>
          </li>";
} else {
    echo "<li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='#'>Welcome " . $_SESSION['admin_name'] . "</a>
          </li>";
}
?>

        <?php
        if(!isset($_SESSION['admin_name'])){
          echo" <li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='../admin_area/admin_login.php'>Login</a>
        </li>";
        } else{
          echo" <li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='../admin_area/logout.php'>Logout</a>
        </li>";

        }
?> -->
                    </ul>
          </nav>
            </div>
        </nav>
        <!-- second child-->
         <div class="bg-light">
            <h3 class="text-center p-2">Manage Details</h3>
         </div>
<!-- thried child -->
 <div class="row">
    <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
        <div class="p-3">
        <a href="#"><img src="../images/logo1.png" alt="" class="admin_image"></a>
        <p class="text-light text-center"><?php echo "sujit"?></p>
        </div>
        <div class="button text-center">
            <button class="my-3"><a href="insert_product.php" class="nav-link text-light bg-info my-1">Insert Products</a></button>
            <button><a href="index.php?view_products" class="nav-link text-light bg-info my-1">View Products</a></button>
            <button><a href="index.php?insert_category" class="nav-link text-light bg-info my-1">Insert Categories</a></button>
            <button><a href="index.php?view_categories" class="nav-link text-light bg-info my-1">View Categories</a></button>
            <button><a href="index.php?list_orders" class="nav-link text-light bg-info my-1">All Orders</a></button>
            <button><a href="index.php?list_payments" class="nav-link text-light bg-info my-1">All Payment</a></button>
            <button><a href="index.php?list_users" class="nav-link text-light bg-info my-1">List User</a></button>
            <button><a href="" class="nav-link text-light bg-info my-1">Logout</a></button>
        </div>
    </div>
 </div>
 <!-- fourth child-->
  <div class="container my-3">
    <?php
    if(isset($_GET['insert_category'])){
        include('insert_categories.php');
    }
    if(isset($_GET['view_products'])){
        include('view_products.php');
    }
    if(isset($_GET['edit_products'])){
        include('edit_products.php');
    }
    if(isset($_GET['delete_product'])){
        include('delete_product.php');
    }
    if(isset($_GET['view_categories'])){
        include('view_categories.php');
    }
    if(isset($_GET['edit_category'])){
        include('edit_category.php');
    }
    if(isset($_GET['delete_category'])){
        include('delete_category.php');
    }
    if(isset($_GET['list_orders'])){
        include('list_orders.php');
    }
    if(isset($_GET['list_payments'])){
        include('list_payments.php');
    }
    if(isset($_GET['list_users'])){
        include('list_users.php');
    }
    ?>
  </div>
 <!-- last child-->
 <div class="bg-info p-2 text-center">
    <p>All rights reserved ©  2025  </p>
</div>
    </div>
   <!-- bootstratp js link -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>