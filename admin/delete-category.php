<?php 
// Include the constants file
include('../config/constants.php');

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    // Get the ID of the category to be deleted
    $id = $_GET['id'];

    // Database connection
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

    // Create the SQL query to delete the category
    $sql = "DELETE FROM tbl_category WHERE id='$id'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($res) {
        // Set session message for success
        $_SESSION['delete'] = "Category Deleted Successfully"; 
    } else {
        // Set session message for failure
        $_SESSION['delete'] = "Failed to Delete Category"; 
    }

    // Redirect to manage-categories page
    header("location:" . SITEURL . 'admin/manage-category.php'); 
    exit();
} else {
    // Redirect if ID is not set
    header("location:" . SITEURL . 'admin/manage-category.php'); 
    exit();
}
?>
