<?php
// include connect file
// include('./includes/connect.php');
function getproducts(){
    global $con;
    // condition to check isset or not
    if(!isset($_GET['category'])){ 
    $select_query = "Select * from `products` order by rand() LIMIT 0,9";
    $result_query = mysqli_query($con, $select_query);
    // Fetch and process the data without displaying it
    while ($row = mysqli_fetch_assoc($result_query)) {
        $product_id = $row['product_id'];
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_keywords = $row['product_keywords'];
        $product_image1 = $row['product_image1'];
        $product_price = $row['product_price'];
        $category_id = $row['category_id'];
        // The following HTML generation is commented out to prevent displaying the data
        echo "<div class='col-md-3 mb-3 '>
            <div class='card' >
                <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                <div class='card-body'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text'>$product_description</p>
                     <p class='price'>Price :$product_price/-</p>
                    <a href='cat.php?add_to_cart= $product_id' class='btn btn-info'>Add to cart</a>
                    <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                </div>
            </div>
        </div>";
    }
}
}
// getting all products
function get_all_products(){
    global $con;
    // condition to check isset or not
    if(!isset($_GET['category'])){ 
    $select_query = "Select * from `products` order by rand()";
    $result_query = mysqli_query($con, $select_query);
    // Fetch and process the data without displaying it
    while ($row = mysqli_fetch_assoc($result_query)) {
        $product_id = $row['product_id'];
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_keywords = $row['product_keywords'];
        $product_image1 = $row['product_image1'];
        $product_image2 = $row['product_image2'];
        $product_image3 = $row['product_image3'];
        $product_price = $row['product_price'];
        $category_id = $row['category_id'];
        // The following HTML generation is commented out to prevent displaying the data
        echo "<div class='col-md-3 mb-3 '>
            <div class='card'>
                <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                <div class='card-body'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text'>$product_description</p>
                     <p class='price'>Price :$product_price/-</p>
                    <a href='cat.php?add_to_cart= $product_id' class='btn btn-info'>Add to cart</a>
                    <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                </div>
            </div>
        </div>";
    }
}
}
// function to unique function 
function get_unique_categories() {
    global $con;
    // Check if 'category' is set in the URL
    if (isset($_GET['category'])) {
        $category_id = intval($_GET['category']); // Sanitize the category ID
        // Fetch products for the selected category
        $select_query = "SELECT * FROM `products` WHERE `category_id` = $category_id";
        $result_query = mysqli_query($con, $select_query);
        // Check if query execution was successful
        if (!$result_query) {
            die("Query failed: " . mysqli_error($con));
        }
        // Check the number of rows returned
        $num_of_rows = mysqli_num_rows($result_query);
        if ($num_of_rows == 0) {
            echo "<h2 class='text-center text-danger'>No stock for this category</h2>";
        } else {
            // Loop through the results and display the products
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = htmlspecialchars($row['product_id']);
                $product_title = htmlspecialchars($row['product_title']);
                $product_description = htmlspecialchars($row['product_description']);
                $product_image1 = htmlspecialchars($row['product_image1']);
                $product_price = htmlspecialchars($row['product_price']);
                //Display the product card
                echo "
                <div class='col-md-3 mb-3'>
                    <div class='card'>
                        <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'><strong>Price:</strong> $$product_price</p>
                            <a href='add_to_cart.php?product_id=$product_id' class='btn btn-info'>Add to Cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View More</a>
                        </div>
                    </div>
                </div>";
            }
        }
    } 
}
    // displaying categories is sidnav   
    function getcategories(){
        global $con;
        if (!$con) {
                die("Database connection failed: " . mysqli_connect_error());
            }
            // Query to fetch all categories
            $select_categories = "SELECT * FROM `categories`";
            $result_categories = mysqli_query($con, $select_categories);
            // Check if query execution was successful
            if (!$result_categories) {
                die("Query failed: " . mysqli_error($con));
            }
            // Check if any rows are returned
            if (mysqli_num_rows($result_categories) > 0) {
                while ($row_data = mysqli_fetch_assoc($result_categories)) {
                    // Assign variables
                    $category_title = htmlspecialchars($row_data['category_title']);
                    $category_id = htmlspecialchars($row_data['category_id']);
                    // Generate HTML for each category
                    echo "
                    <li class='nav-item'>
                        <a href='cat.php?category=$category_id' class='nav-link text-light'>$category_title</a>
                    </li>";
                }
            } else {
                echo "<p>No categories found in the database.</p>";
        }
    }
    function search_product() {
        global $con;
        if (isset($_GET['search_data_product'])) {
            $search_data_value = mysqli_real_escape_string($con, $_GET['search_data']);  // Sanitize the input
            // Use prepared statements for security
            $stmt = $con->prepare("SELECT * FROM `products` WHERE `product_keywords` LIKE ?");
            if (!$stmt) {
                die("Prepare failed: " . $con->error);
            }
            $search_term = '%' . $search_data_value . '%';
            $stmt->bind_param("s", $search_term);
            if (!$stmt->execute()) {
                die("Execution failed: " . $stmt->error);
            }
            $result = $stmt->get_result();
            // Check if there are results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $product_id = $row['product_id'];
                    $product_title = $row['product_title'];
                    $product_description = $row['product_description'];
                    $product_image1 = $row['product_image1'];
                    $product_price = $row['product_price'];
                    echo "<div class='col-md-4 mb-3'>
                        <div class='card'>
                            <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$product_title</h5>
                                <p class='card-text'>$product_description</p>
                                <p class='price'>Price :$product_price/-</p>
                                <a href='cat.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                                <a href='product_details.php' class='btn btn-secondary'>View more</a>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "<h2 class='text-center text-danger'>No products found matching your search.</h2>";
            }
            $stmt->close();
        }
    }
// view details function
function view_details() {
    global $con;
    // Check if `product_id` is set
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        // SQL query to fetch product details
        $select_query = "SELECT * FROM `products` WHERE `product_id` = $product_id";
        $result_query = mysqli_query($con, $select_query);
        // Check if the query executed successfully
        if (!$result_query) {
            die("Query failed: " . mysqli_error($con));
        }
        // Check if any product is found
        if (mysqli_num_rows($result_query) == 0) {
            echo "<h2 class='text-center text-danger'>Product not found!</h2>";
            return;
        }
        // Fetch and display product details
        while ($row = mysqli_fetch_assoc($result_query)) {
            $product_title = $row['product_title'];
            $product_description = $row['product_description'];
            $product_keywords = $row['product_keywords'];
            $product_image1 = $row['product_image1'];
            $product_image2 = $row['product_image2'];
            $product_image3 = $row['product_image3'];
            $product_price = $row['product_price'];
            echo "
            <div class='row '>
                <div class='col-md-4 mb-3'>
                    <div class='card'>
                        <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='price'>Price :$product_price/-</p>
                           <a href='cat.php?add_to_cart= $product_id' class='btn btn-info'>Add to cart</a>
                            <a href='cat.php' class='btn btn-secondary'>Go home</a>
                        </div>
                    </div>
                </div>
                <div class='col-md-8'>
                    <h4 class='text-center text-info mb-4'>Related Image</h4>
                    <div class='row-mb-4 d-flex'>
                        <div class='col-md-6 d-flex'>
                            <img src='./admin_area/product_images/$product_image2' class='img-fluid '>
                        </div>
                        <div class='col-md-6 d-flex'>
                            <img src='./admin_area/product_images/$product_image3' class='img-fluid'>
                       </div>
                            </div>
                </div>
            </div>";
        }
    } else {
        echo "<h2 class='text-center text-danger'>No product selected!</h2>";
    }
}
// get ip address function
    function getIPAddress() {
    //whether ip is from the share internet
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    //whether ip is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     }
//whether ip is from the remote address
    else{
             $ip = $_SERVER['REMOTE_ADDR'];
     }
     return $ip;
}
// $ip = getIPAddress();
// echo 'User Real IP Address - '.$ip;
// cart function 
function cart() {
    if (isset($_GET['add_to_cart'])) {
        global $con;
        // Retrieve the user's IP address
        $get_ip_add = getIPAddress();
        // Get the product ID to add to the cart
        $get_product_id = intval($_GET['add_to_cart']); // Sanitize input
        // Debugging: Print IP and product ID
        echo "<p>Debug: IP Address: $get_ip_add</p>";
        echo "<p>Debug: Product ID to add: $get_product_id</p>";
        
        // Check if the item is already in the cart
        $select_query = "SELECT * FROM `cart_details` WHERE ip_address = '$get_ip_add' AND product_id = $get_product_id";
        $result_query = mysqli_query($con, $select_query);
        
        if (!$result_query) {
            die("SQL Error: " . mysqli_error($con));
        }
        
        $num_of_rows = mysqli_num_rows($result_query);
        
        if ($num_of_rows > 0) {
            // Item already in cart
            echo "<script>alert('This item is already present inside the cart')</script>";
            echo "<script>window.open('cat.php','_self')</script>";
        } else {
            // Add the item to the cart
            $insert_query = "INSERT INTO `cart_details` (product_id, ip_address, quantity) VALUES ($get_product_id, '$get_ip_add', 1)";
            $result_query = mysqli_query($con, $insert_query);
            
            if ($result_query) {
                echo "<script>alert('Product added to cart successfully!');</script>";
                echo "<script>window.open('cat.php','_self');</script>";
            } 
        }
    }
}
// function to get item cart numbers
function cart_item() {
    global $con;

    // Retrieve the user's IP address
    $get_ip_add = getIPAddress();

    // Check if "add_to_cart" is set
    if (isset($_GET['add_to_cart'])) {
        // Get the product ID to add to the cart
        $get_product_id = intval($_GET['add_to_cart']); // Sanitize input

        // Insert the item into the cart
        $insert_query = "INSERT INTO `cart_details` (product_id, ip_address, quantity) 
                         VALUES ($get_product_id, '$get_ip_add', 1)";
        $result_query = mysqli_query($con, $insert_query);

        if ($result_query) {
            echo "<script>alert('Product added to cart successfully!');</script>";
            echo "<script>window.open('cat.php', '_self');</script>";
        } 
    }

    // Query to count the items in the cart for the user's IP address
    $select_query = "SELECT * FROM `cart_details` WHERE ip_address = '$get_ip_add'";
    $result_query = mysqli_query($con, $select_query);

    // If the query fails
    if (!$result_query) {
        die("SQL Error: " . mysqli_error($con));
    }

    // Count the number of items in the cart
    $count_cart_items = mysqli_num_rows($result_query);

    // Output the count or 0 if no items are found
    echo   ($count_cart_items ? $count_cart_items : 0) . "</p>";
}

// total price function
function total_cart_price() {
    global $con;
    
    // Retrieve the user's IP address
    $get_ip_add = getIPAddress();
    
    // Initialize the total price to 0
    $total_price = 0;

    // Query to select cart items for the given IP address
    $cart_query = "SELECT * FROM `cart_details` WHERE ip_address = '$get_ip_add'";
    $result = mysqli_query($con, $cart_query);

    // Check for any error in query execution
    if (!$result) {
        die("SQL Error: " . mysqli_error($con));
    }

    // Loop through the cart items
    while ($row = mysqli_fetch_array($result)) {
        $product_id = $row['product_id'];

        // Query to get the price of the product
        $select_products = "SELECT * FROM `products` WHERE product_id = '$product_id'";
        $result_products = mysqli_query($con, $select_products);

        // Check if there are any errors while fetching product price
        if (!$result_products) {
            die("SQL Error: " . mysqli_error($con));
        }

        // Get the product price
        while ($row_product_price = mysqli_fetch_array($result_products)) {
            $product_price = $row_product_price['product_price'];  // Access the product price directly
            $total_price += $product_price;  // Add the product price to the total
        }
    }

    // Display the total price
    echo "Total Price $total_price";
}

// get user order details
function get_user_order_details() {
    global $con;

    // Sanitize username
    $username = mysqli_real_escape_string($con, $_SESSION['username']);

    // Fetch user details
    $get_details = "SELECT * FROM `user_table` WHERE username='$username'";
    $result_query = mysqli_query($con, $get_details);

    if (!$result_query) {
        die("User query failed: " . mysqli_error($con));
    }

    if (mysqli_num_rows($result_query) > 0) {
        while ($row_query = mysqli_fetch_array($result_query)) {
            $user_id = $row_query['user_id'];

            // Ensure no interfering GET parameters
            if (
                !isset($_GET['edit_account']) &&
                !isset($_GET['my_account']) &&
                !isset($_GET['my_orders']) &&
                !isset($_GET['delete_account'])
            ) {
                // Fetch pending orders
                $get_orders = "SELECT * FROM `user_orders` WHERE user_id=$user_id AND order_status='pending'";
                $result_orders_query = mysqli_query($con, $get_orders);

                if (!$result_orders_query) {
                    die("Orders query failed: " . mysqli_error($con));
                }

                $row_count = mysqli_num_rows($result_orders_query);
                if ($row_count > 0) {
                    echo "<h3 class='text-center text-success mt-5 mb-2'>You have <span class='text-danger'>$row_count</span> pending orders.</h3>
                     <p class='text-center'><a href='profile.php?my_orders' class='text-dark'>Order Details</a></p>";
                    
                } else {
                    echo "<h3 class='text-center'>You have no pending orders.</h3>";
                   
                }
            }
        }
    } else {
        echo "<h3 class='text-center'>User not found.</h3>";
    }
}


?>