<?php
// database connection 
include('../includes/connect.php');

// Fetch user details
$username = $_SESSION['username'] ?? null;

// Ensure the username is set
if (!$username) {
    die("Session username is not set. Please log in.");
}

// Correct SQL query to fetch user details
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All My Orders</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional stylesheet -->
</head>
<body>
<h3 class="text-success">All My Orders</h3>
<table class="table table-bordered mt-5">
   <thead class="bg-info">
       <tr>
           <th>Sr No</th>
           <th>Amount Due</th>
           <th>Total Products</th>
           <th>Invoice Number</th>
           <th>Date</th>
           <th>Complete/Incomplete</th>
           <th>Status</th>
           <th>Return</th>
       </tr>
   </thead>
   <tbody class="bg-secondary">
    <?php
    // Fetch order details
    $get_order_details = "SELECT * FROM `user_orders` WHERE `user_id` = $user_id";
    $result_orders = mysqli_query($con, $get_order_details);
    if (!$result_orders) {
        die("Query Failed: " . mysqli_error($con));
    }

    $number = 1;

    // Loop through orders
    while ($row_orders = mysqli_fetch_assoc($result_orders)) {
        $order_id = $row_orders['order_id'];
        $amount_due = $row_orders['amount_due'];
        $total_products = $row_orders['total_products'];
        $invoice_number = $row_orders['invoice_number'];
        $order_status = $row_orders['order_status'];
        $order_date = $row_orders['order_date'];

        // Update status display
        if ($order_status == 'pending') {
            $order_status = 'Incomplete';
        } else {
            $order_status = 'Complete';
        }

        // Display order details
        echo "<tr>
                <td>$number</td>
                <td>$amount_due</td>
                <td>$total_products</td>
                <td>$invoice_number</td>
                <td>$order_date</td>
                <td>$order_status</td>";

        // Display payment status or confirmation link
        if ($order_status == 'Complete') {
            echo "<td>Paid</td>";
        } else {
            echo "<td><a href='confirm_payment.php?order_id=$order_id' class='text_light'>Confirm</a></td>";
        }

        // Display Return button
        echo "<td><a href='return_order.php?order_id=$order_id' class='text_light'>Return</a></td>";
        echo "</tr>";

        $number++;
    }
    ?>
   </tbody>
</table>
</body>
</html>
