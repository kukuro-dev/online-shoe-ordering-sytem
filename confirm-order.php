<?php
// Include the database configuration file
include('config.php'); // Make sure this path is correct

if (isset($_POST['submit'])) {
    // Retrieve form data
    $shoe_id = intval($_POST['shoe_id']);
    $qty = intval($_POST['qty']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full-name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Here you could insert this data into an orders table in your database
    $query = "INSERT INTO orders (shoe_id, qty, full_name, contact, email, address) VALUES ('$shoe_id', '$qty', '$full_name', '$contact', '$email', '$address')";

    if (mysqli_query($conn, $query)) {
        echo "<p class='text-center'>Order placed successfully!</p>";
    } else {
        echo "<p class='text-center'>Error: " . mysqli_error($conn) . "</p>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
