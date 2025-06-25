<h3 class="text-center text-success">All Users</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-info">
    </thead>
    <tbody>
        <?php
        // Fetch orders query
        $user_payments = "SELECT * FROM user_table";
        $result = mysqli_query($con, $user_payments);

        if (!$result) {
            // Handle query error
            echo "<h2 class='bg-danger text-center mt-5'>Error fetching orders: " . mysqli_error($con) . "</h2>";
        } else {
            $row_count = mysqli_num_rows($result);

            if ($row_count == 0) {
                echo "<h2 class='text-danger text-center mt-5'>No users yet</h2>";
            } else {
                echo"  <tr>
            <th>Sl no</th>
            <th>Username</th>
            <th>user email</th>
            <th>User image</th>
            <th>User address</th>
            <th>User mobile</th>
            <th>Delete</th>
        </tr>";
                
                $number = 0; // Initialize counter
                while ($row_data = mysqli_fetch_assoc($result)) {
                    // Retrieve row data
                    $user_id = $row_data['user_id'];
                    $username = $row_data['username'];
                    $user_email = $row_data['user_email'];
                    $user_image = $row_data['user_image'];
                    $user_address=$row_data['user_address'];
                    $user_mobile = $row_data['user_mobile'];
                    $number++;

                    // Display table row
                    echo "
                    <tr>
                        <td>$number</td>
                        <td>$username</td>
                        <td>$user_email</td>
                        <td><img src='../users_area\user_images/$user_image' alt='$username' class='product_img'></td>
                        <td>$user_address</td>
                        <td>$user_mobile</td>
                        <td><a href='delete_order.php?order_id=$user_id'><i class='fa-solid fa-trash'></i></a></td>
                    </tr>";
                  
                }
            }
        }
        ?>
    </tbody>
</table>
