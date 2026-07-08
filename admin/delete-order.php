<?php 
// Include the constants file
include('../config/constants.php');

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    // Get the ID of the admin to be deleted
    $id = $_GET['id'];

    // Database connection
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

    // Create the SQL query to delete the order
    $sql = "DELETE FROM tbl_order WHERE id='$id'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($res) {
        // Set session message for success
        $_SESSION['delete'] = "Order Deleted Successfully"; 
    } else {
        // Set session message for failure
        $_SESSION['delete'] = "Failed to Delete Failed"; 
    }

    // Redirect to manage-order page
    header("location:" . SITEURL . 'admin/manage-order.php'); 
    exit();
} else {
    // Redirect if ID is not set
    header("location:" . SITEURL . 'admin/manage-order.php'); 
    exit();
}
?>
