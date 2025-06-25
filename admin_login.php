<?php
include('../includes/connect.php');
include('../functions/common_function.php');
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
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
        Admin Login
        </h2>
        <div class="row d-flex justify-content-center ">
            <div class="col-lg-6 col-xl-2">
                <img src="..\images\adminlo.jpg.png" alt="Admin Registration" class="img-fluid">
            </div>
            <div class="col-lg-6 col-xl-4">
<form action="" method="post">
    <div class="form-outline mb-4">
        <label for="admin_name" class="form-label">Username</label>
        <input type="text" id="admin_name" name="admin_name" placeholder="Enter your username" requeried="requeried"  class="form-control">
    </div>
    <div class="form-outline mb-4">
        <label for="admin_password" class="form-label">Password</label>
        <input type="password" id="admin_password" name="admin_password" placeholder="Enter your password" requeried="requeried"  class="form-control">
    </div>
    <input type="submit" class="bg-info py-2 px-3 border-0" name="admin_login" value="Login">
    <p class="small fw-bold mt-2 pt-1">Don't you have an account?<a href="admin_registration.php" class="link-danger">Register</a></p>
    </div>
    </div>
    
  </div>
  </form>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['admin_login'])) {
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];
    // Use prepared statements for security
    $stmt = $con->prepare("SELECT * FROM `admin_table` WHERE admin_name='$admin_name'");
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row_data = $result->fetch_assoc();
        if (password_verify($admin_password, $row_data['admin_password'])) {
            if (isset($_SESSION['admin_name'])) {
                echo "<script>alert('Login Successful'); window.open('profile.php', '_self');</script>";
             } else {
                 echo "<script>alert('Redirecting to admin page'); window.open('profile.php','_self');</script>";
             }
        } else {
            echo "<script>alert('Invalid Credentials');</script>";
        }
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}
?>
