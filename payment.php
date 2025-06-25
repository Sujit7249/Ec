<?php
include('../includes/connect.php');
include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" >
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <style>
        .payment_img {
            width: 90%;
            margin: auto;
            display: block;
        }
    </style>
</head>
<body>
    <!-- access user id-->
    <?php
    $user_ip = getIPAddress();
    $get_user = "SELECT * FROM `user_table` WHERE user_ip='$user_ip'";
    $result = mysqli_query($con, $get_user);

    if ($result && mysqli_num_rows($result) > 0) {
        $run_query = mysqli_fetch_array($result);
        $user_id = $run_query['user_id'];
    } else {
        $user_id = null; // Fallback if no user found
    }
    ?>
    <div class="container">
        <h2 class="text-center text-info">Payment Options</h2>
        <div class="row d-flex justify-content-center align-items-center my-5">
            <div class="col-md-6">
                <a href="https://www.paypal.com"><img src="../images/upi.jpg" alt="Payment" class="payment_img"></a>
            </div>
            <div class="col-md-6">
                <a href="order.php?user_id=<?php echo $user_id ? $user_id : 'unknown'; ?>">
                    <h2 class="text-center">Pay Offline</h2>
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
