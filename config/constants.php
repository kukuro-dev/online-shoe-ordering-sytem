<?php
// Start the session only if it hasn't been started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session to manage session variables
}

// Define constants for database connection and site URL only if not already defined
if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost/shoe-order/'); // Change if your project path is different
}

if (!defined('LOCALHOST')) {
    define('LOCALHOST', 'localhost'); // Database host
}

if (!defined('DB_USERNAME')) {
    define('DB_USERNAME', 'root'); // Database username
}

if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', ''); // Database password (usually empty for local XAMPP)
}

if (!defined('DB_NAME')) {
    define('DB_NAME', 'shoe-order'); // Database name
}

// Establish database connection using defined constants
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die("Connection failed: " . mysqli_connect_error());

// Select the database
$db_select = mysqli_select_db($conn, DB_NAME) or die("Database selection failed: " . mysqli_error($conn));

// Optionally, you can check the connection status here
if ($conn) {
    // Connection is successful
    // You can add some logging or debugging here if necessary.
}
?>
