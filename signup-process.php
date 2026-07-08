<?php
// Include your database connection file
include('config/constants.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user data from the form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        header("Location: user-signup.php?error=All fields are required");
        exit();
    }

    // Check if the username already exists
    $check_sql = "SELECT * FROM tbl_users WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Username already exists, handle the error
        header("Location: user-signup.php?error=Username already taken");
        exit();
    }

    // Perform the database insert operation (make sure to hash the password)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO tbl_users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to login page on success
        header("Location: user-login.php");
        exit();
    } else {
        // Handle error, redirect back to signup or show error
        header("Location: user-signup.php?error=Signup failed");
        exit();
    }
}

// Close the database connection
mysqli_close($conn);
?>
