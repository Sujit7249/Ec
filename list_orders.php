<h3 class="text-center text-success">All Orders</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-info">
    </thead>
    <tbody>
        <?php
        // Fetch orders query
        $get_orders = "SELECT * FROM user_orders";
        $result = mysqli_query($con, $get_orders);
        if (!$result) {
            // Handle query error
            echo "<h2 class='bg-danger text-center mt-5'>Error fetching orders: " . mysqli_error($con) . "</h2>";
        } else {
            $row_count = mysqli_num_rows($result);

            if ($row_count == 0) {
                echo "<h2 class='text-danger text-center mt-5'>No orders yet</h2>";
            } else {
                echo"  <tr>
            <th>Sl no</th>
            <th>Due Amount</th>
            <th>Invoice Number</th>
            <th>Total Products</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Delete</th>
        </tr>";
                
                $number = 0; // Initialize counter
                while ($row_data = mysqli_fetch_assoc($result)) {
                    // Retrieve row data
                    $order_id = $row_data['order_id'];
                    $user_id = $row_data['user_id'];
                    $amount_due = $row_data['amount_due'];
                    $invoice_number = $row_data['invoice_number'];
                    $total_products = $row_data['total_products'];
                    $order_date = $row_data['order_date'];
                    $order_status = $row_data['order_status'];
                    $number++;

                    // Display table row
                    echo "
                    <tr>
                        <td>$number</td>
                        <td>$amount_due</td>
                        <td>$invoice_number</td>
                        <td>$total_products</td>
                        <td>$order_date</td>
                        <td>$order_status</td>
                        <td><a href='delete_order.php?order_id=$order_id'><i class='fa-solid fa-trash'></i></a></td>
                    </tr>";
                  
                }
            }
        }
        ?>
    </tbody>
</table>
