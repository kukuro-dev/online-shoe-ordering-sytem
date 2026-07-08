<?php
session_start();
include('config/constants.php');

$total = 0;

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Get cart items
$cart_item_ids = implode(",", array_map('intval', $_SESSION['cart']));
$result = mysqli_query($conn, "SELECT * FROM tbl_shoe WHERE id IN ($cart_item_ids) AND active='yes'");

$cart_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
    $total += (float)$row['price'];
}

// Handle form submission
if (isset($_POST['submit'])) {
    $customer_name = mysqli_real_escape_string($conn, $_POST['full-name']);
    $customer_contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['email']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['address']);

    $order_items = [];
    $grand_total = 0;

    foreach ($cart_items as $item) {
        $qty = intval($_POST['qty_' . $item['id']]);
        $size = mysqli_real_escape_string($conn, $_POST['size_' . $item['id']]);
        $total_item = $item['price'] * $qty;

        $order_items[] = [
            'title' => $item['title'],
            'image_name' => $item['image_name'],
            'size' => $size,
            'qty' => $qty,
            'price' => $item['price'],
            'total' => $total_item
        ];

        $grand_total += $total_item;
    }

    $_SESSION['order'] = [
        'customer_name' => $customer_name,
        'customer_contact' => $customer_contact,
        'customer_email' => $customer_email,
        'customer_address' => $customer_address,
        'items' => $order_items
    ];

    unset($_SESSION['cart']);
    header("Location: success.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - ShoeHub</title>

<!-- Bootstrap & Font Awesome -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
body { font-family: Arial, sans-serif; background:#f4f4f4; }
.navbar { background:#fff; padding:10px 30px; box-shadow:0 2px 5px rgba(0,0,0,0.1); display:flex; align-items:center; justify-content:space-between; }
.navbar .logo img { width:100px; }
.navbar ul { list-style:none; display:flex; gap:20px; margin:0; padding:0; }
.navbar ul li a { color:#ff6b81; font-weight:bold; display:flex; align-items:center; gap:5px; text-decoration:none; }
.navbar ul li a:hover { color:#333; }
.checkout-card { max-width: 1000px; margin:40px auto; background:#fff; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); padding:30px; }
.checkout-card h2 { text-align:center; margin-bottom:30px; color:#333; }
.shoe-item { display:flex; gap:20px; margin-bottom:30px; border-bottom:1px solid #eee; padding-bottom:20px; }
.shoe-item img { width:200px; height:200px; object-fit:cover; border-radius:10px; }
.shoe-desc h4 { font-size:20px; color:#333; margin-bottom:10px; }
.shoe-price { font-size:18px; color:#d9534f; margin-bottom:10px; }
.form-label { font-weight:bold; margin-top:10px; }
.btn-order { background:#ff6b81; color:#fff; }
.btn-order:hover { background:#ff4757; }
.footer { background:#212529; color:#ccc; padding:40px 20px; margin-top:40px; }
.footer h5 { color:#fff; margin-bottom:15px; }
.footer p, .footer small { margin:0; }
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
    </ul>
</nav>

<!-- Checkout Form -->
<section class="checkout-card">
    <h2>Confirm Your Order</h2>
    <form method="POST">
        <?php foreach($cart_items as $item): ?>
            <div class="shoe-item">
                <img src="images/<?php echo htmlspecialchars($item['image_name']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                <div class="shoe-desc">
                    <h4><?php echo htmlspecialchars($item['title']); ?></h4>
                    <p class="shoe-price">₱<?php echo number_format($item['price'],2); ?></p>
                    <label class="form-label"><i class="fas fa-ruler-horizontal"></i> Size</label>
                    <input type="text" name="size_<?php echo $item['id']; ?>" class="form-control" placeholder="Enter size" required>
                    <label class="form-label"><i class="fas fa-sort-numeric-up"></i> Quantity</label>
                    <input type="number" name="qty_<?php echo $item['id']; ?>" class="form-control" value="1" min="1" required>
                </div>
            </div>
        <?php endforeach; ?>

        <fieldset>
            <legend>Delivery Details</legend>
            <label class="form-label"><i class="fas fa-user"></i> Full Name</label>
            <input type="text" name="full-name" class="form-control" required>

            <label class="form-label"><i class="fas fa-phone"></i> Contact Number</label>
            <input type="tel" name="contact" class="form-control" required>

            <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" class="form-control" required>

            <label class="form-label"><i class="fas fa-map-marker-alt"></i> Address</label>
            <textarea name="address" rows="4" class="form-control" required></textarea>

            <button type="submit" name="submit" class="btn btn-order w-100 mt-3"><i class="fas fa-check-circle"></i> Confirm Order</button>
        </fieldset>
    </form>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <!-- About -->
      <div class="col-md-6 text-start">
        <h5>Shoe Online Ordering System</h5>
        <p>
          Our platform provides a seamless way to purchase shoes online. 
          With a wide range of footwear options, we ensure every customer 
          finds the perfect fit. Built for convenience, quality, and efficiency.
        </p>
        <p>
          Committed to innovation, we integrate trusted brands and 
          user-friendly features that guarantee satisfaction and style.
        </p>
      </div>
      <!-- Contact -->
      <div class="col-md-6 text-start">
        <h5>Contact Us</h5>
        <p><i class="fas fa-map-marker-alt me-2"></i> Camiguin, Philippines</p>
        <p><i class="fas fa-phone-alt me-2"></i> 09533501578</p>
        <p class="mt-3"><small>
            Student of <strong>Camiguin Polytechnic State College</strong><br>
            Taking a course of <strong>Bachelor of Science in Information Technology</strong>
        </small></p>
      </div>
    </div>
    <hr class="border-secondary">
    <div class="text-start">
      <small>&copy; <?php echo date("Y"); ?> KickStore. All Rights Reserved.</small>
    </div>
  </div>
</footer>

<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>
