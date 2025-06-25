 <?php
include('../includes/connect.php');
include('../functions/common_function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <!-- bootstratp css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body{
            overflow:hidden;
        }
    </style>
</head>
<bod>
    <div class="continer-fluid m-3">
        <h2 class="text-center mb-5 ">
        Admin Registration
        </h2>
        <div class="row d-flex justify-content-center ">
            <div class="col-lg-6 col-xl-2">
                <img src="../images/adminreg.jpg" alt="Admin Registration" class="img-fluid">
            </div>
            <div class="col-lg-6 col-xl-4">
<form action="" method="post">
    <div class="form-outline mb-4">
        <label for="admin_name" class="form-label">admin name</label>
        <input type="text" id="admin_name" name="admin_name" placeholder="Enter your adminname" requeried="requeried"  class="form-control">
    </div>
    <div class="form-outline mb-4">
        <label for="admin_email" class="form-label">Email</label>
        <input type="email" id="admin_email" name="admin_email" placeholder="Enter your adminemail" requeried="requeried"  class="form-control">
    </div>
    <div class="form-outline mb-4">
        <label for="admin_password" class="form-label">Password</label>
        <input type="password" id="admin_password" name="admin_password" placeholder="Enter your password" requeried="requeried"  class="form-control">
    </div>
    <div class="form-outline mb-4">
        <label for="conf_admin_password" class="form-label">confirm Password</label>
        <input type="password" id="conf_admin_password" name="conf_admin_password" placeholder="Enter your password" requeried="requeried"  class="form-control">
    </div>
    <input type="submit" class="bg-info py-2 px-3 border-0" name="admin_registration" value="Register">
    <p class="small fw-bold mt-2 pt-1">Do you already have an account?<a href="admin_login.php" class="link-danger">Login</a></p>
    </div>
    </div>
  </div>
  </form>
</body>
</html>
<?php
// Start the session
session_start();
if (isset($_POST['admin_registration'])) {
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];
    $conf_admin_password = $_POST['conf_admin_password'];
    // Validate empty fields
    if (empty($admin_name) || empty($admin_email) || empty($admin_password)) {
        echo "<script>alert('All fields are required.')</script>";
        exit();
    }
    // Validate passwords match
    if ($admin_password !== $conf_admin_password) {
        echo "<script>alert('Passwords do not match.')</script>";
        exit();
    }
    // Check for duplicate username or email
    $select_query = "SELECT * FROM `admin_table` WHERE admin_name='$admin_name' OR admin_email='$admin_email'";
    $result = mysqli_query($con, $select_query);
    if (!$result) {
        die("Database Error: " . mysqli_error($con));
    }
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username or Email already exists.')</script>";
        exit();
    }
    // Secure password hashing
    $hashed_password = password_hash($admin_password, PASSWORD_BCRYPT);
    // Insert user data into the database
    $insert_query = "INSERT INTO `admin_table` (admin_name, admin_email, admin_password) 
                     VALUES ('$admin_name', '$admin_email', '$hashed_password')";
    $sql_execute = mysqli_query($con, $insert_query);

    if ($sql_execute) {
        echo "<script>alert('Data inserted successfully.')</script>";
    } else {
        die("Database Error: " . mysqli_error($con));
    }
}
?> 
