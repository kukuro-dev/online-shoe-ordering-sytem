<?php

include('config/constants.php');

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted username and password
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

   
    $sql = "SELECT * FROM tbl_users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Fetch user data
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

        
            header("Location: user-dashboard.php");
            exit();
        } else {
            
            header("Location: user-login.php?error=Invalid username or password.");
            exit();
        }
    } else {
       
        header("Location: user-login.php?error=Invalid username or password.");
        exit();
    }
} else {
    // Not a POST request
    header("Location: user-login.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
