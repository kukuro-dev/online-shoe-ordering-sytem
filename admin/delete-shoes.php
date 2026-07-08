<?php 
// Include the constants file
include('../config/constants.php');

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    // Get the ID of the shoe to be deleted
    $id = $_GET['id'];

    // Database connection
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

    // Create the SQL query to get the shoe's image name
    $sql = "SELECT image_name FROM tbl_shoe WHERE id='$id'";
    $res = mysqli_query($conn, $sql);
    
    if ($res) {
        // Check if the shoe exists
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            // Get the image name
            $row = mysqli_fetch_assoc($res);
            $image_name = $row['image_name'];

            // Remove the image file from the server if it exists
            if ($image_name != "") {
                $path = "../images/" . $image_name; // Specify the path to the image
                if (file_exists($path)) {
                    unlink($path); // Delete the image file
                }
            }
            
            // Create the SQL query to delete the shoe
            $sql = "DELETE FROM tbl_shoe WHERE id='$id'";
            $res = mysqli_query($conn, $sql);

            // Check if the query was successful
            if ($res) {
                $_SESSION['delete'] = "Shoe Deleted Successfully"; 
            } else {
                $_SESSION['delete'] = "Failed to Delete Shoe"; 
            }
        } else {
            $_SESSION['delete'] = "Shoe Not Found"; 
        }
    } else {
        $_SESSION['delete'] = "Failed to Retrieve Shoe"; 
    }

    // Redirect to manage-shoes page
    header("location:" . SITEURL . 'admin/manage-shoes.php'); 
    exit();
} else {
    // Redirect if ID is not set
    header("location:" . SITEURL . 'admin/manage-shoes.php'); 
    exit();
}
?>
