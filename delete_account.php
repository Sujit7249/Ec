<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
</head>
<body>
    <h3 class="text-danger mb-4">Delete Account</h3>
    <form action="" method="post" class="mt-5">
      <div class="form-outline mb-4">
        <input type="submit" class="form-control w-50 m-auto" name="delete" value="Delete Account"> 
      </div>
    </form>
    <div class="form-outline mb-4">
        <input type="submit" class="form-control w-50 m-auto" name="dont_delete" value="Don't Delete Account"> 
      </div>
</body>
</html>
<?php
$username_session = $_SESSION['username'] ?? null;
// Ensure session variable exists
if (!$username_session) {
    echo "<script>alert('No user is logged in. Please log in first.')</script>";
    echo "<script>window.open('../index.php', '_self')</script>";
    exit();
}
// Handle account deletion
if (isset($_POST['delete'])) {
    // Correct SQL query
    $delete_query = "DELETE FROM `user_table` WHERE `username` = '$username_session'";
    $result = mysqli_query($con, $delete_query);
    if ($result) {
        // Successfully deleted account
        session_destroy(); // Destroy session after deletion
        echo "<script>alert('Account deleted successfully.')</script>";
        echo "<script>window.open('../index.php', '_self')</script>";
    } else {
        // Handle query failure
        echo "<script>alert('Error: Unable to delete account. Please try again.')</script>";
        echo "Error: " . mysqli_error($con); // Debugging message (optional for development)
    }
}
// Handle cancel deletion
if (isset($_POST['dont_delete'])) {
    echo "<script>window.open('profile.php', '_self')</script>";
}
?>
