<?php
include('config/constants.php'); // Database connection

$categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : null;
if (!$categoryId) {
    header('Location: categories.php');
    exit;
}

$categoryQuery = "SELECT title FROM tbl_category WHERE id = $categoryId";
$categoryResult = mysqli_query($conn, $categoryQuery);
$category = mysqli_fetch_assoc($categoryResult);

$shoeQuery = "SELECT * FROM tbl_shoe WHERE category_id = $categoryId AND active = 'yes'";
$shoeResult = mysqli_query($conn, $shoeQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shoes in Category - Shoe Ordering System</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
body { font-family: Arial, sans-serif; margin:0; padding:0; }

/* Navbar */
.navbar {
    background:#fff;
    padding:10px 30px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.navbar .logo img { width:100px; }
.navbar ul { list-style:none; display:flex; gap:20px; margin:0; padding:0; }
.navbar ul li a {
    color:#ff6b81;
    text-decoration:none;
    font-weight:bold;
    display:flex;
    align-items:center;
    gap:5px;
}
.navbar ul li a:hover { color:#333; }

/* Shoes */
.shoe-container { display:flex; flex-wrap:wrap; gap:20px; margin-top:20px; }
.shoe-item { flex:1 0 45%; background:#fff; border-radius:8px; box-shadow:0 4px 6px rgba(0,0,0,0.1); text-align:center; padding:15px; transition:all 0.3s; }
.shoe-item:hover { transform:scale(1.05); box-shadow:0 8px 12px rgba(0,0,0,0.2); }
.shoe-item img { width:150px; height:auto; border-radius:5px; }
.shoe-item h4 { margin-top:10px; font-size:18px; color:#333; }
.shoe-item p { margin:10px 0; font-size:14px; color:#777; }
.shoe-item a { display:inline-block; margin-top:10px; padding:8px 15px; background-color:#ff6b81; color:#fff; border-radius:5px; text-decoration:none; }
.shoe-item a:hover { background-color:#ff4757; }

/* Back Link */
.back-link { margin:20px 0; display:inline-block; padding:10px 20px; background-color:#333; color:#fff; text-decoration:none; border-radius:5px; }
.back-link:hover { background-color:#555; }

/* Footer */
.footer { background:#222; color:#ccc; padding:40px 0; margin-top:40px; }
.footer h5 { color:#fff; font-weight:bold; margin-bottom:15px; }
.footer p, .footer small { color:#ccc; margin-bottom:8px; }
.footer a { color:#ff6b81; text-decoration:none; }
.footer a:hover { text-decoration:underline; }
</style>
</head>
<body>

<!-- Navbar -->
<section class="navbar">
    <div class="logo">
        <a href="index.php" title="Logo"><img src="images/logo.png" alt="Logo"></a>
    </div>
    <div class="menu">
        <ul>
            <li><a href="user-dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="categories.php"><i class="fas fa-th-large"></i> Categories</a></li>
            <li><a href="shoe.php"><i class="fas fa-shoe-prints"></i> Shoes</a></li>
            <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
        </ul>
    </div>
</section>

<!-- Shoes Section -->
<div class="container my-4">
    <h2>Shoes in Category: <?php echo htmlspecialchars($category['title']); ?></h2>

    <a href="categories.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Categories</a>

    <div class="shoe-container">
        <?php if (mysqli_num_rows($shoeResult) > 0): ?>
            <?php while ($shoe = mysqli_fetch_assoc($shoeResult)): ?>
                <div class="shoe-item">
                    <img src="images/<?php echo htmlspecialchars($shoe['image_name']); ?>" alt="<?php echo htmlspecialchars($shoe['title']); ?>">
                    <h4><?php echo htmlspecialchars($shoe['title']); ?></h4>
                    <p><?php echo htmlspecialchars($shoe['description']); ?></p>
                    <p><strong>PHP <?php echo number_format($shoe['price'], 2); ?></strong></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No shoes found in this category.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <!-- About -->
      <div class="col-md-6">
        <h5>Shoe Online Ordering System</h5>
        <p>
          Our platform provides a seamless way to purchase shoes online. 
          With a wide range of footwear options, from casual sneakers to formal shoes, 
          we ensure every customer finds the perfect fit. 
        </p>
        <p>
          Committed to innovation, we strive to create an enjoyable shopping experience 
          by integrating trusted brands and user-friendly features that guarantee both 
          satisfaction and style.
        </p>
      </div>
      <!-- Contact -->
      <div class="col-md-6">
        <h5>Contact Us</h5>
        <p><i class="fas fa-map-marker-alt me-2"></i> Camiguin, Philippines</p>
        <p><i class="fas fa-phone-alt me-2"></i> 09533501578</p>
        <p><small>Student of <strong>Camiguin Polytechnic State College</strong><br>
           Taking a course of <strong>Bachelor of Science in Information Technology</strong></small></p>
        <!-- Socials -->
        <a href="#"><i class="fab fa-facebook fa-lg me-3"></i></a>
        <a href="#"><i class="fab fa-instagram fa-lg me-3"></i></a>
        <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
      </div>
    </div>
    <hr class="border-light mt-4">
    <div class="text-start">
      <small>&copy; <?php echo date("Y"); ?> KickStore. All Rights Reserved.</small>
    </div>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_free_result($categoryResult);
mysqli_free_result($shoeResult);
mysqli_close($conn);
?>
