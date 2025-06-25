<?php
// database connection
include('../includes/connect.php');

// Fetch user details
session_start();
$username = $_SESSION['username'] ?? null;

// Ensure the username is set
if (!$username) {
    die("Session username is not set. Please log in.");
}

// Check if order_id is set in the URL
$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    die("Order ID is missing.");
}

// Fetch user details from the database
$get_user = "SELECT * FROM `user_table` WHERE `username` = '$username'";
$result = mysqli_query($con, $get_user);
if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}

$row_fetch = mysqli_fetch_assoc($result);
if (!$row_fetch) {
    die("No user found with the username '$username'.");
}

$user_id = $row_fetch['user_id'];

// Fetch order details
$get_order = "SELECT * FROM `user_orders` WHERE `order_id` = $order_id AND `user_id` = $user_id";
$result_order = mysqli_query($con, $get_order);
if (!$result_order || mysqli_num_rows($result_order) == 0) {
    die("Order not found or does not belong to you.");
}

$order_details = mysqli_fetch_assoc($result_order);

// Handle return form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $return_reason = mysqli_real_escape_string($con, $_POST['return_reason']);

    $insert_return = "INSERT INTO `order_returns` (`order_id`, `user_id`, `return_reason`, `return_date`, `return_status`) VALUES ($order_id, $user_id, '$return_reason', NOW(), 'Pending')";
    $result_insert = mysqli_query($con, $insert_return);

    if ($result_insert) {
        echo "<div style='color: green;'>Return request successfully submitted. We will process it shortly.</div>";
    } else {
        echo "<div style='color: red;'>Failed to submit the return request. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Order</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional stylesheet -->
</head>
<body>
<h3 class="text-warning">Return Order - Invoice Number: <?php echo $order_details['invoice_number']; ?></h3>
<p>Amount Due: <?php echo $order_details['amount_due']; ?></p>
<p>Total Products: <?php echo $order_details['total_products']; ?></p>
<p>Order Date: <?php echo $order_details['order_date']; ?></p>

<form method="POST">
    <label for="return_reason">Reason for Return:</label><br>
    <textarea name="return_reason" id="return_reason" rows="4" cols="50" required></textarea><br><br>

    <button type="submit" class="btn btn-danger">Submit Return Request</button>
</form>

</body>
</html>
