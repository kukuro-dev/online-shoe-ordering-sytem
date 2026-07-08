<?php

session_start();

include('config/constants.php');


if (isset($_GET['id'])) {
    $shoe_id = $_GET['id'];

  
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the shoe ID to the cart session array
    if (!in_array($shoe_id, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $shoe_id;
        // Set a session variable for the success message
        $_SESSION['add_to_cart_message'] = "Shoe added to cart successfully!";
    }

    // Redirect to the cart page
    header('Location: cart.php');
    exit();
}
?>
