<?php
session_start();
include('config/constants.php');

$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$query = "SELECT * FROM tbl_shoe WHERE title LIKE '%$searchQuery%' AND active='yes'";
$result = mysqli_query($conn, $query);

$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shoe Ordering System</title>

<!-- Local Bootstrap -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

<!-- Local Font Awesome -->
<link rel="stylesheet" href="assets/fontawesome/css/all.min.css">

<link rel="stylesheet" href="css/style.css">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
body { font-family: Arial, sans-serif; background-color:#f4f4f4; }

/* Navbar */
.navbar { background:#fff; padding:10px 30px; box-shadow:0 2px 5px rgba(0,0,0,0.1); display:flex; align-items:center; justify-content:space-between; }
.navbar .logo img { width:100px; }
.navbar ul { list-style:none; display:flex; gap:20px; margin:0; padding:0; }
.navbar ul li a { color:#ff6b81; font-weight:bold; display:flex; align-items:center; gap:5px; text-decoration:none; }
.navbar ul li a:hover { color:#333; }

/* Shoe Search */
.shoe-search { padding:70px 20px; background:url('images/shoebg.jpg') center/cover no-repeat; color:#fff; text-align:center; }
.shoe-search input[type="text"] { width:50%; padding:10px; border-radius:5px; border:1px solid #ccc; margin-right:10px; }
.shoe-search input[type="submit"] { padding:10px 20px; border:none; border-radius:5px; background:#ff6b81; color:#fff; cursor:pointer; }
.shoe-search input[type="submit"]:hover { background:#ff4757; }

/* Shoe Menu */
.shoe-menu { padding:30px 0; }
.shoe-menu-container { display:flex; flex-wrap:wrap; gap:20px; justify-content:center; }
.shoe-menu-box { background:#fff; border-radius:8px; padding:15px; width:220px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 4px 8px rgba(0,0,0,0.1); transition:transform 0.3s, box-shadow 0.3s; }
.shoe-menu-box:hover { transform:scale(1.05); box-shadow:0 8px 16px rgba(0,0,0,0.2); }
.shoe-menu-img img { width:100%; height:200px; object-fit:cover; border-radius:8px; }
.shoe-menu-desc h4 { font-size:18px; margin:10px 0 5px; }
.shoe-menu-desc p { margin:5px 0; color:#555; font-size:14px; }
.btn { display:inline-block; padding:8px 12px; border-radius:5px; text-decoration:none; margin-top:5px; transition:background 0.3s; }
.btn-order { background:#ff6b81; color:#fff; }
.btn-order:hover { background:#ff4757; }
.btn-cart { background:#4CAF50; color:#fff; }
.btn-cart:hover { background:#2d7034; }

/* Footer */
.footer { background:#f9f9f9; padding:20px 0; text-align:center; }
.footer p { font-weight:bold; color:#333; }
.footer p a { color:#ff4757; text-decoration:none; }
.footer p a:hover { text-decoration:underline; }

/* Social */
.social { padding:30px 0; }
.social ul { list-style:none; margin:0; padding:0; display:flex; justify-content:center; }
.social ul li { margin:0 15px; }
.social ul li a img { width:40px; height:auto; transition:transform 0.3s; }
.social ul li a img:hover { transform:scale(1.2); }

/* Responsive */
@media(max-width:768px) { .shoe-menu-box{ width:45%; } }
@media(max-width:480px) { .shoe-menu-box{ width:100%; } }
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
        <li><a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart (<?php echo $cart_count; ?>)</a></li>
    </ul>
</nav>

<!-- Shoe Search -->
<section class="shoe-search">
    <form method="GET">
        <input type="text" name="search" placeholder="Search for Shoes..." value="<?php echo htmlspecialchars($searchQuery); ?>" required>
        <input type="submit" value="Search">
    </form>
    <?php if($searchQuery): ?>
        <h2>Shoes matching: "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
    <?php endif; ?>
</section>

<!-- Shoe Menu -->
<section class="shoe-menu container">
    <h2 class="text-center mb-4">Shoe Menu</h2>
    <div class="shoe-menu-container">
        <?php
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['id'];
                $title = htmlspecialchars($row['title']);
                $price = number_format((float)$row['price'], 2);
                $desc = htmlspecialchars($row['description']);
                $image = !empty($row['image_name']) ? $row['image_name'] : 'no-image.png';
        ?>
        <div class="shoe-menu-box">
            <div class="shoe-menu-img">
                <img src="images/<?php echo $image; ?>" alt="<?php echo $title; ?>">
            </div>
            <div class="shoe-menu-desc">
                <h4><?php echo $title; ?></h4>
                <p>₱<?php echo $price; ?></p>
                <p><?php echo $desc; ?></p>
            </div>
            <div>
                <a href="order.php?id=<?php echo $id; ?>" class="btn btn-order"><i class="fas fa-cart-arrow-down"></i> Order Now</a>
                <a href="add-to-cart.php?id=<?php echo $id; ?>" class="btn btn-cart"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
            </div>
        </div>
        <?php
            }
        } else {
            echo '<p class="text-center">No shoes available.</p>';
        }
        mysqli_free_result($result);
        ?>
    </div>
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
    

<!-- Local Bootstrap JS -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
