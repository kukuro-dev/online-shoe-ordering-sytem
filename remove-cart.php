<?php
session_start();

// Check if the 'id' is passed in the URL
if (isset($_GET['id'])) {
    $shoe_id = $_GET['id'];

    // Check if the cart session is initialized and contains the item
    if (isset($_SESSION['cart']) && in_array($shoe_id, $_SESSION['cart'])) {
        // Remove the item from the cart
        $_SESSION['cart'] = array_diff($_SESSION['cart'], [$shoe_id]);

        // Re-index the array to ensure sequential keys
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Redirect back to the cart page
header('Location: cart.php');
exit();
?>
