<!-- connect file-->
<?php
include('../includes/connect.php');
session_start();
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']); // Sanitize input
    echo "Order ID: " . $order_id;
    // Fetch order details
    $select_data = "SELECT * FROM `user_orders` WHERE order_id = $order_id";
    $result = mysqli_query($con, $select_data);
    if ($result) {
        $row_fetch = mysqli_fetch_assoc($result);
        $invoice_number = $row_fetch['invoice_number'];
        $amount_due = $row_fetch['amount_due'];
    } else {
        die("Error fetching order: " . mysqli_error($con));
    }
}
if (isset($_POST['confirm_payment'])) {
    $invoice_number = intval($_POST['invoice_number']); // Sanitize input
    $amount = floatval($_POST['amount']); // Sanitize input
    $payment_mode = mysqli_real_escape_string($con, $_POST['payment_mode']); // Sanitize input
    // Insert payment record
    $insert_query = "
        INSERT INTO `user_payments` (order_id, invoice_number, amount, payment_mode)
        VALUES ($order_id, $invoice_number, $amount, '$payment_mode')
    ";
    $result = mysqli_query($con, $insert_query);
    if ($result) {
        echo "<h3 class='text-center text-light'>Successfully completed the payment</h3>";
        echo "<script>window.open('profile.php?my_orders', '_self')</script>";
        // Update order status
        $update_orders = "UPDATE `user_orders` SET order_status = 'Complete' WHERE order_id = $order_id";
        $result_orders = mysqli_query($con, $update_orders);

        if (!$result_orders) {
            die("Error updating order: " . mysqli_error($con));
        }
    } else {
        die("Error inserting payment: " . mysqli_error($con));
    }
}
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
      <!-- bootstrap css link -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">;
 </head>
 <body class="bg-secondary">
    <h1 class="text-center text-light">Confirm Payment</h1>
    <div class="container my-5">
        <form action="" method="post">
            <div class="form-outline my-4 text-center w-50 m-auto">
                <input type="text" class="form-control w-50 m-auto " name="invoice_number" value="<?php echo $invoice_number      ?>">
            </div>
            <div class="form-outline my-4 text-center w-50 m-auto">
                <label for="" class="text-light">Amount</label>
                <input type="text" class="form-control w-50 m-auto " name="amount" value="<?php echo $amount_due      ?>">
                </div>
                <div class="form-outline my-4 text-center w-50 m-auto">
                    <select name="payment_mode" class="form-select w-50 m-auto">
                        <option>Select Payment Mode</option>
                        <option>UPI</option>
                        <option>Netbanking</option>
                        <option>Cash on Delivery</option>
                        <option>Payoffline</option>
                    </select>
                </div>
                <div class="form-outline my-4 text-center w-50 m-auto">
                <input type="submit" class="bg-info py-2 px-3 border-0" value="Confirm" name="confirm_payment">
            </div>
        </form>
    </div>
 </body>
 </html>