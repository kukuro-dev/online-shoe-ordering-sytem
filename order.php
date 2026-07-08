<?php
session_start();
include('config/constants.php');

$shoe_id = '';
$price = 0;
$qty = 1;
$shoe = null;

if (isset($_GET['id'])) {
    $shoe_id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM tbl_shoe WHERE id='$shoe_id' AND active='yes'");
    if ($row = mysqli_fetch_assoc($result)) {
        $shoe = $row;
        $price = (float)$row['price'];
    }
}

$total = $price * $qty;

if (isset($_POST['submit'])) {
    $customer_name = mysqli_real_escape_string($conn, $_POST['full-name']);
    $customer_contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['email']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['address']);
    $qty = intval($_POST['qty']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $total = $price * $qty;

    // Save order info in session
    $_SESSION['order'] = [
        'customer_name' => $customer_name,
        'customer_contact' => $customer_contact,
        'customer_email' => $customer_email,
        'customer_address' => $customer_address,
        'items' => [
            [
                'title' => $shoe['title'],
                'image_name' => $shoe['image_name'],
                'size' => $size,
                'qty' => $qty,
                'price' => $price,
                'total' => $total
            ]
        ]
    ];

    // Redirect immediately to receipt
    header("Location: success.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Shoe</title>

<!-- Local Bootstrap -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Local Font Awesome -->
<link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
body { font-family: Arial, sans-serif; background:#f4f4f4; }

/* Navbar */
.navbar { background:#fff; padding:10px 30px; box-shadow:0 2px 5px rgba(0,0,0,0.1); display:flex; align-items:center; justify-content:space-between; }
.navbar .logo img { width:100px; }
.navbar ul { list-style:none; display:flex; gap:20px; margin:0; padding:0; }
.navbar ul li a { color:#ff6b81; font-weight:bold; display:flex; align-items:center; gap:5px; text-decoration:none; }
.navbar ul li a:hover { color:#333; }

/* Order Section */
.shoe-order { padding:40px 0; }
.shoe-order .card { max-width: 700px; margin:auto; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
.shoe-order .card-body { padding:30px; }
.shoe-order h2 { text-align:center; margin-bottom:30px; }

/* Shoe Image */
.shoe-img { width:100%; height:300px; object-fit:cover; border-radius:10px; margin-bottom:20px; }

/* Input */
.form-label { font-weight:bold; margin-top:10px; }
.form-control { border-radius:5px; }

/* Buttons */
.btn-order { background:#ff6b81; color:#fff; }
.btn-order:hover { background:#ff4757; }

/* Social */
.social ul { list-style:none; display:flex; justify-content:center; padding:0; gap:15px; margin-top:30px; }
.social ul li a img { width:40px; height:auto; transition:transform 0.3s; }
.social ul li a img:hover { transform:scale(1.2); }

/* Footer */
.footer { background:#f9f9f9; padding:30px 20px; margin-top:40px; }
.footer h5 { font-weight:bold; margin-bottom:15px; }
.footer p { margin:5px 0; }
.footer small { color:#555; }
</style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar container">
    <div class="logo">
        <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
    </div>
    <ul>
        <li><a href="user-dashboard.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="categories.php"><i class="fas fa-th-large"></i> Categories</a></li>
        <li><a href="shoe.php"><i class="fas fa-shoe-prints"></i> Shoes</a></li>
        <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
    </ul>
</nav>

<!-- Order Form -->
<section class="shoe-order">
    <div class="card">
        <div class="card-body">
            <h2>Confirm Your Order</h2>
            <form method="POST">
                <?php if($shoe): ?>
                    <img src="images/<?php echo htmlspecialchars($shoe['image_name'] ?: 'default-shoe.jpg'); ?>" alt="<?php echo htmlspecialchars($shoe['title']); ?>" class="shoe-img">

                    <h4><?php echo htmlspecialchars($shoe['title']); ?> - ₱<?php echo number_format($price,2); ?></h4>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-ruler-horizontal"></i> Size</label>
                        <input type="text" name="size" class="form-control" placeholder="Enter shoe size" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-sort-numeric-up"></i> Quantity</label>
                        <input type="number" name="qty" class="form-control" value="<?php echo $qty; ?>" min="1" required>
                    </div>
                <?php endif; ?>

                <hr>

                <h5>Delivery Details</h5>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" name="full-name" class="form-control" placeholder="Enter full name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="tel" name="contact" class="form-control" placeholder="Enter phone number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea name="address" class="form-control" rows="4" placeholder="Enter address" required></textarea>
                </div>

                <button type="submit" name="submit" class="btn btn-order w-100"><i class="fas fa-check-circle"></i> Confirm Order</button>
            </form>
        </div>
    </div>
</section>

<!-- Social -->
<section class="social">
    <ul>
        <li><a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png"/></a></li>
        <li><a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png"/></a></li>
        <li><a href="#"><img src="https://img.icons8.com/fluent/48/000000/twitter.png"/></a></li>
    </ul>
</section>

<!-- Footer -->
<footer class="footer bg-dark text-white pt-5 mt-5">
  <div class="container">
    <div class="row">
      <!-- About -->
      <div class="col-md-6 mb-4">
        <h5 class="fw-bold text-uppercase text-white">Shoe Online Ordering System</h5>
        <p class="text-white">
          ShoeHub provides a seamless way to order shoes online. 
          From stylish sneakers to formal footwear, we ensure customers find 
          the right pair for every occasion.
        </p>
        <p class="text-white">
          As a project of a student from Camiguin Polytechnic State College, 
          this platform demonstrates innovation and commitment to delivering 
          user-friendly solutions for online shopping.
        </p>
      </div>

      <!-- Contact -->
      <div class="col-md-6 mb-4">
        <h5 class="fw-bold text-uppercase text-white">Contact Us</h5>
        <p class="text-white"><i class="fas fa-map-marker-alt me-2"></i> Camiguin, Philippines</p>
        <p class="text-white"><i class="fas fa-phone-alt me-2"></i> 09533501578</p>
        <p class="text-white">
          <i class="fas fa-user-graduate me-2"></i> 
          Student of <strong class="text-white">Camiguin Polytechnic State College</strong><br>
          Taking <strong class="text-white">Bachelor of Science in Information Technology</strong>
        </p>
      </div>
    </div>

    <hr class="border-light">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <!-- Social Links -->
      <div class="social mb-2">
        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
        <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
      </div>

      <!-- Copyright -->
      <div class="text-white">
        <small>&copy; <?php echo date("Y"); ?> KickStore. All Rights Reserved.</small>
      </div>
    </div>
  </div>
</footer>


<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
