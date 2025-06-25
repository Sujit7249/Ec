<?php
include('../includes/connect.php');
include('../functions/common_function.php');

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    die("User ID is not set.");
}

// Getting total items and total price of all items
$get_ip_address = getIPAddress();
$total_price = 0;
$cart_query_price = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_address'";
$result_cart_price = mysqli_query($con, $cart_query_price);

if (!$result_cart_price) {
    die("Query failed: " . mysqli_error($con));
}

$invoice_number = mt_rand();
$status = 'pending';
$count_products = mysqli_num_rows($result_cart_price);

while ($row_price = mysqli_fetch_array($result_cart_price)) {
    $product_id = $row_price['product_id'];
    $select_product = "SELECT * FROM `products` WHERE product_id=$product_id";
    $run_price = mysqli_query($con, $select_product);

    if (!$run_price) {
        die("Query failed: " . mysqli_error($con));
    }

    while ($row_product_price = mysqli_fetch_array($run_price)) {
        $product_price = $row_product_price['product_price'];
        $total_price += $product_price;
    }
}

// Getting quantity from cart
$get_cart = "SELECT * FROM `cart_details` WHERE ip_address='$get_ip_address'";
$run_cart = mysqli_query($con, $get_cart);

if (!$run_cart) {
    die("Query failed: " . mysqli_error($con));
}

$get_item_quantity = mysqli_fetch_array($run_cart);
$quantity = $get_item_quantity['quantity'] ?? 0;

if ($quantity == 0) {
    $quantity = 1;
    $subtotal = $total_price;
} else {
    $subtotal = $total_price * $quantity;
}

// Insert into user_orders
$insert_orders = "INSERT INTO `user_orders` (user_id, amount_due, invoice_number, total_products, order_date, order_status) 
                  VALUES ($user_id, $subtotal, $invoice_number, $count_products, NOW(), '$status')";
$result_query = mysqli_query($con, $insert_orders);

if (!$result_query) {
    die("Query failed: " . mysqli_error($con));
}

// Insert into orders_pending
$insert_pending_orders = "INSERT INTO `orders_pending` (user_id, invoice_number, product_id, quantity, order_status) 
                           VALUES ($user_id, $invoice_number, $product_id, $quantity, '$status')";
$result_pending = mysqli_query($con, $insert_pending_orders);

// if (!$result_pending) {
//     die("Query failed: " . mysqli_error($con));
// }

// Empty cart
$empty_cart = "DELETE FROM `cart_details` WHERE ip_address='$get_ip_address'";
$result_empty_cart = mysqli_query($con, $empty_cart);

if (!$result_empty_cart) {
    die("Query failed: " . mysqli_error($con));
}

// Redirect to profile
echo "<script>window.open('profile.php', '_self');</script>";
?>
