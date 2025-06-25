<?php
include('../includes/connect.php');
include('../functions/common_function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User -registration</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">New User Registration</h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline mb-4">
                        <!-- user name feield-->
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" id="user_username" class="form-control" placeholder="Enter your user name" autocomplete="off" required="required" name="user_username"/>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- email feield-->
                        <label for="user_email" class="form-label">Email</label>
                        <input type="text" id="user_email" class="form-control" placeholder="Enter your user email" autocomplete="off" required="required" name="user_email"/>
                    </div>
                      <!-- image feield-->
                    <div class="form-outline mb-4">
                        <label for="user_image" class="form-label">User Image</label>
                        <input type="file" id="user_image" class="form-control" placeholder="Enter your user image" autocomplete="off" required="required" name="user_image"/>
                    </div>
                    <!-- password feield-->
                    <div class="form-outline mb-4">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" id="user_password" class="form-control" placeholder="Enter your password" autocomplete="off" required="required" name="user_password"/>
                    </div>
                    <!-- confirm password feield-->
                    <div class="form-outline mb-4">
                        <label for="conf_user_password" class="form-label">Confirm Password</label>
                        <input type="password" id="conf_user_password" class="form-control" placeholder="Confirm Password" autocomplete="off" required="required" name="conf_user_password"/>
                    </div>
                     <!-- user address feield-->
                    <div class="form-outline mb-4">
                        <label for="user_address" class="form-label">Address</label>
                        <input type="text" id="user_address" class="form-control" placeholder="Enter your address" autocomplete="off" required="required" name="user_address"/>
                    </div>
                    <!-- user contact feield-->
                    <div class="form-outline mb-4">
                        <label for="user_contact" class="form-label">Contact</label>
                        <input type="text" id="user_contact" class="form-control" placeholder="Enter your mobile number" autocomplete="off" required="required" name="user_contact"/>
                    </div>
                    <div class="mt-4 pt-2">
                        <input type="submit" value="Register" class="bg-info py-2 px-3 border-0" name="user_register">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account ?<a href="user_login.php" class="text-danger"> Login</a> </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<!-- php code -->
<?php
// Start the session
session_start();
if (isset($_POST['user_register'])) {
    $user_username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $conf_user_password = $_POST['conf_user_password'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    // Function to get user IP address
    $user_ip = getIPAddress();
    // Validate empty fields
    if (empty($user_username) || empty($user_email) || empty($user_password) || empty($conf_user_password) || empty($user_address) || empty($user_contact) || empty($user_image)) {
        echo "<script>alert('All fields are required.')</script>";
        exit();
    }
    // Validate passwords match
    if ($user_password !== $conf_user_password) {
        echo "<script>alert('Passwords do not match.')</script>";
        exit();
    }
    // Check for duplicate username or email
    $select_query = "SELECT * FROM `user_table` WHERE username='$user_username' OR user_email='$user_email'";
    $result = mysqli_query($con, $select_query);
    if (!$result) {
        die("Database Error: " . mysqli_error($con));
    }
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username or Email already exists.')</script>";
        exit();
    }
    // Secure password hashing
    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);
    // Ensure the upload directory exists
    $upload_dir = "./user_images/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    // Move the uploaded file
    if (!move_uploaded_file($user_image_tmp, $upload_dir . $user_image)) {
        echo "<script>alert('Failed to upload image.')</script>";
        exit();
    }
    // Insert user data into the database
    $insert_query = "INSERT INTO `user_table` (username, user_email, user_password, user_image, user_ip, user_address, user_mobile) 
                     VALUES ('$user_username', '$user_email', '$hashed_password', '$user_image', '$user_ip', '$user_address', '$user_contact')";
    $sql_execute = mysqli_query($con, $insert_query);

    if ($sql_execute) {
        echo "<script>alert('Data inserted successfully.')</script>";
    } else {
        die("Database Error: " . mysqli_error($con));
    }
    // Select cart items
    $select_cart_items = "SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
    $result_cart = mysqli_query($con, $select_cart_items);
    if (!$result_cart) {
        die("Database Error: " . mysqli_error($con));
    }
    $rows_count = mysqli_num_rows($result_cart);
    if ($rows_count > 0) {
        $_SESSION['username'] = $user_username;
        echo "<script>alert('You have items in your cart');</script>";
        echo "<script>window.open('checkout.php', '_self');</script>";
    } else {
        echo "<script>window.open('../index.php', '_self');</script>";
    }
}
?>