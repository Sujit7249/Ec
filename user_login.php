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
    <title>Agro Store</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">User Login</h2>
        <div class="row d-flex align-items-center justify-content-center mt-5">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" >
                    <div class="form-outline mb-4">
                        <!-- user name feield-->
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" id="user_username" class="form-control" placeholder="Enter your user name" autocomplete="off" required="required" name="user_username"/>
                    </div>
                    <!-- password feield-->
                    <div class="form-outline mb-4">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" id="user_password" class="form-control" placeholder="Enter your password" autocomplete="off" required="required" name="user_password"/>
                    </div>
                    <div class="mt-4 pt-2">
                        <input type="submit" value="Login" class="bg-info py-2 px-3 border-0" name="user_login">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account ? <a href="user_registration.php" class="text-danger">Register </a> </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];
    // Use prepared statements for security
    $stmt = $con->prepare("SELECT * FROM `user_table` WHERE username='$user_username'");
    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row_data = $result->fetch_assoc();
        if (password_verify($user_password, $row_data['user_password'])) {
            $user_ip = getIPAddress();
            // Check cart details
            $cart_stmt = $con->prepare("SELECT * FROM `cart_details` WHERE ip_address = ?");
            $cart_stmt->execute();
            $cart_result = $cart_stmt->get_result();
            $row_count_cart = $cart_result->num_rows;
            if (isset($_SESSION['username'])) {
                echo "<script>alert('Login Successful'); window.open('profile.php', '_self');</script>";
             } else {
                 echo "<script>alert('Redirecting to payment'); window.open('payment.php','_self');</script>";
             }
        } else {
            echo "<script>alert('Invalid Credentials');</script>";
        }
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}
?>
