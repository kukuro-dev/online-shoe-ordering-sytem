<?php
include('config/constants.php'); // Database connection

$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);
}

$query = "SELECT * FROM tbl_category WHERE title LIKE '%$searchQuery%' AND active='yes'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Categories - Shoe Ordering System</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">

<style>
body { font-family: Arial, sans-serif; margin:0; padding:0; }

/* Navbar with icons */
.navbar { background: #fff; padding: 10px 0; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
.navbar .logo img { width: 120px; }
.navbar ul { list-style: none; margin:0; padding:0; display:flex; justify-content:flex-end; align-items:center; }
.navbar ul li { margin-left: 20px; }
.navbar ul li a { color: #ff6b81; font-weight:bold; text-decoration:none; display:flex; align-items:center; gap:5px; }
.navbar ul li a:hover { color: #333; }

/* Category Search */
.category-search { padding: 70px 0; background: url('images/shoebg.jpg') center/cover no-repeat; color:#fff; text-align:center; }
.category-search input[type="text"] { width:50%; padding:10px; border-radius:5px; border:1px solid #ccc; }
.category-search input[type="submit"] { padding:10px 20px; background:#ff6b81; border:none; color:#fff; border-radius:5px; cursor:pointer; }
.category-search input[type="submit"]:hover { background:#ff4757; }

/* Category Cards */
.category-menu { padding:50px 0; }
.category-menu-box { display:flex; flex-wrap:wrap; justify-content:center; gap:30px; }
.category-menu-img { background:#f9f9f9; border-radius:10px; overflow:hidden; width:48%; text-align:center; transition: transform 0.3s, box-shadow 0.3s; }
.category-menu-img:hover { transform:scale(1.05); box-shadow:0 8px 16px rgba(0,0,0,0.2); }
.category-menu-img img { width:50%; height:130px; object-fit:cover; }
.category-menu-desc { padding:15px; }
.category-menu-desc h4 { font-size:18px; margin-bottom:10px; color:#333; }
.category-menu-desc a { display:inline-block; padding:10px 15px; background:#ff6b81; color:#fff; border-radius:5px; text-decoration:none; transition: background 0.3s; }
.category-menu-desc a i { margin-right:5px; }
.category-menu-desc a:hover { background:#ff4757; }

/* Footer */
footer { background:#222; color:#ddd; padding:40px 20px; margin-top:50px; }
footer h5 { color:#fff; margin-bottom:15px; }
footer p, footer small { color:#bbb; }
footer a { color:#ff6b81; text-decoration:none; }
footer a:hover { text-decoration:underline; }
footer .social a { margin-right:15px; color:#bbb; transition:0.3s; }
footer .social a:hover { color:#ff6b81; }

/* Responsive */
@media(max-width:991px){
    .category-menu-img{width:48%; margin-bottom:20px;}
}
@media(max-width:768px){
    .category-menu-img{width:90%;}
    .category-search input[type="text"]{width:70%;}
    .navbar ul{flex-direction:column; gap:10px; align-items:flex-start;}
}
</style>
</head>
<body>

<!-- Navbar with icons -->
<nav class="navbar container">
    <div class="logo float-start">
        <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
    </div>
    <ul>
        <li><a href="user-dashboard.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="categories.php"><i class="fas fa-th-large"></i> Categories</a></li>
        <li><a href="shoe.php"><i class="fas fa-shoe-prints"></i> Shoes</a></li>
        <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
    </ul>
</nav>

<!-- Category Search -->
<section class="category-search">
    <div class="container">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search for categories..." value="<?php echo htmlspecialchars($searchQuery); ?>" required>
            <input type="submit" value="Search">
        </form>
        <?php if ($searchQuery): ?>
            <h2>Categories matching: <span><?php echo htmlspecialchars($searchQuery); ?></span></h2>
        <?php endif; ?>
    </div>
</section>

<!-- Category Menu -->
<section class="category-menu">
    <div class="container">
        <h2 class="text-center mb-4">Category Menu</h2>
        <div class="category-menu-box">
            <?php
            if (!empty($result) && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="category-menu-img">
                            <img src="images/' . htmlspecialchars($row['image_name']) . '" alt="' . htmlspecialchars($row['title']) . '">
                            <div class="category-menu-desc">
                                <h4>' . htmlspecialchars($row['title']) . '</h4>
                                <a href="category-shoe.php?category_id=' . $row['id'] . '"><i class="fas fa-eye"></i> View Shoes</a>
                            </div>
                          </div>';
                }
            } else {
                echo '<p class="text-center">No categories found matching your search.</p>';
            }
            mysqli_free_result($result);
            ?>
        </div>
    </div>
</section>

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
