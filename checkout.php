<!-- connect file-->
<?php
 include('../includes/connect.php');
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check out page</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css file -->
     <link rel="stylesheet" href="style.css">
     <style>
      .logo{
        width:7%;
        height:7%;
      }
     </style>
</head>
<body>
 <!--  navbar -->
   <div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container-fluid">
   <img src="../images/logo.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active fs-4 fw-bold" aria-current="page" href="../cat.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="../display_all.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="../users_area/user_registration.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="Contact.php">Contact</a>
        </li>
      </ul>
      <!-- <form class="d-flex" action="search_product.php" method="get">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
         <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
      </form> -->
    </div>
  </div>
</nav>
<!-- second child -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
 <ul class="navbar-nav me-auto">
 <li class="nav-item">
          <a class="nav-link fs-4 fw-bold" href="#">Welcome Guest</a>
        </li>
        <?php
        if(!isset($_SESSION['username'])){
          echo" <li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='./user_login.php'>Logout</a>
        </li>";
        } else{
          echo" <li class='nav-item'>
          <a class='nav-link fs-4 fw-bold' href='logout.php'>Login</a>
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
  <div class="row px-1" >
    <div class="col-md-12">
    <!-- products-->
    <div class="row">
        <?php
if(!isset($_SESSION['username'])){
    include('user_login.php');

}else {
    include('payment.php');

}
?>
    </div>
</div>
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