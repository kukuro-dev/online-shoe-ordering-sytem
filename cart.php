<?php
session_start();
include('config/constants.php');

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$total = 0;
$result = null;

if (!empty($_SESSION['cart'])) {
    $cart_item_ids = implode(",", array_map('intval', $_SESSION['cart']));
    $query = "SELECT * FROM tbl_shoe WHERE id IN ($cart_item_ids)";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart - Shoe Ordering System</title>

<!-- Bootstrap & Font Awesome -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
 <link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
body { font-family: Arial, sans-serif; background:#f4f4f4; }

.navbar { background:#fff; padding:10px 30px; box-shadow:0 2px 5px rgba(0,0,0,0.1); display:flex; align-items:center; justify-content:space-between; }
.navbar .logo img { width:100px; }
.navbar ul { list-style:none; display:flex; gap:20px; margin:0; padding:0; }
.navbar ul li a { color:#ff6b81; font-weight:bold; text-decoration:none; display:flex; align-items:center; gap:5px; }
.navbar ul li a:hover { color:#333; }

.cart-container { display:flex; flex-direction:column; align-items:center; }
.cart-item { display:flex; justify-content:space-between; width:90%; margin-bottom:20px; background:#fff; padding:15px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); position:relative; }
.cart-item img { width:120px; height:100px; object-fit:cover; border-radius:10px; }
.cart-item-info { flex:1; margin-left:15px; }
.cart-item-desc { font-size:16px; font-weight:bold; margin-bottom:5px; }
.cart-item-price { font-size:16px; color:#d9534f; margin-bottom:10px; }
.btn-remove { background:#ff4d4d; color:#fff; border:none; padding:8px 12px; border-radius:5px; position:absolute; bottom:15px; right:15px; }
.btn-remove:hover { background:#ff7979; transform:scale(1.05); }
.cart-total { margin-top:30px; font-size:18px; font-weight:bold; text-align:right; width:90%; }
.cart-buttons { margin-top:20px; width:90%; text-align:right; }
.btn-proceed { background:#ff6b81; color:#fff; padding:10px 20px; border:none; border-radius:5px; }
.btn-proceed:hover { background:#ff4757; }

.footer, .social { text-align:center; padding:20px 0; }
.social ul { list-style:none; display:flex; justify-content:center; gap:15px; padding:0; }
.social ul li a img { width:40px; transition:transform 0.3s; }
.social ul li a img:hover { transform:scale(1.2); }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar container">
    <div class="logo"><a href="index.php"><img src="images/logo.png" alt="Logo"></a></div>
    <ul>
        <li><a href="user-dashboard.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="categories.php"><i class="fas fa-th-large"></i> Categories</a></li>
        <li><a href="shoe.php"><i class="fas fa-shoe-prints"></i> Shoes</a></li>
        <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
        <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
    </ul>
</nav>

<!-- Cart Section -->
<section class="cart my-5">
    <div class="container">
        <h2 class="text-center mb-4">Your Cart</h2>

        <div class="cart-container">
        <?php
        if ($result && mysqli_num_rows($result) > 0):
            while ($row = mysqli_fetch_assoc($result)):
                $id = $row['id'];
                $title = htmlspecialchars($row['title']);
                $price = (float)$row['price'];
                $image_name = htmlspecialchars($row['image_name']);
                $image_path = "images/{$image_name}";
                if (!file_exists($image_path) || $image_name=="") $image_path='images/default.jpg';
                $total += $price;
        ?>
            <div class="cart-item">
                <img src="<?php echo $image_path; ?>" alt="<?php echo $title; ?>">
                <div class="cart-item-info">
                    <p class="cart-item-desc"><?php echo $title; ?></p>
                    <p class="cart-item-price">₱<?php echo number_format($price,2); ?></p>
                </div>
                <a href="remove-cart.php?id=<?php echo $id; ?>" class="btn-remove"><i class="fas fa-trash"></i> Remove</a>
            </div>
        <?php
            endwhile;
            mysqli_free_result($result);
        else:
            echo '<p class="text-center">Your cart is empty.</p>';
        endif;
        ?>
        </div>

        <div class="cart-total">
            Total: ₱<?php echo number_format($total,2); ?>
        </div>

        <div class="cart-buttons">
            <a href="checkout.php" class="btn-proceed"><i class="fas fa-credit-card"></i> Proceed to Checkout</a>
        </div>
    </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="footer bg-dark text-light py-5 mt-5">
  <div class="container">
    <div class="row">
      <!-- About Section -->
      <div class="col-md-6 text-start">
        <h5 class="fw-bold text-uppercase mb-3">Shoe Online Ordering System</h5>
        <p>
          Our platform provides a seamless way to purchase shoes online. 
          With a wide range of footwear options, from casual sneakers to formal shoes, 
          we ensure every customer finds the perfect fit. The system is built with 
          convenience, quality, and efficiency in mind.
        </p>
        <p>
          Committed to innovation, we strive to create an enjoyable shopping experience 
          by integrating trusted brands and user-friendly features that guarantee both 
          satisfaction and style.
        </p>
      </div>

      <!-- Contact Section -->
      <div class="col-md-6 text-start">
        <h5 class="fw-bold text-uppercase mb-3">Contact Us</h5>
        <p><i class="fas fa-map-marker-alt me-2"></i> Camiguin, Philippines</p>
        <p><i class="fas fa-phone-alt me-2"></i> 09533501578</p>
        <p class="mt-3">
          <small>
            Student of <strong>Camiguin Polytechnic State College</strong><br>
            Taking a course of <strong>Bachelor of Science in Information Technology</strong>
          </small>
        </p>

        <!-- Social Media -->
        <div class="mt-3">
          <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
          <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
          <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
        </div>
      </div>
    </div>
    <hr class="border-light mt-4">
    <div class="text-start">
      <small>&copy; <?php echo date("Y"); ?> KickStore. All Rights Reserved.</small>
    </div>
  </div>
</footer>

    

<?php
mysqli_close($conn);
?>
