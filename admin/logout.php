<?php 
// Include the constants file
include('../config/constants.php'); 

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the front page (index.php)
header("Location: " . SITEURL . "index.php"); 
exit(); 
?>
