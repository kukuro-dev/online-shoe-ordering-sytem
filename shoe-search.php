<?php
// shoe-search.php
// Include database configuration file
include('config/constants.php'); // make sure this path is correct

// Initialize search query
$searchQuery = "";

// Check if the search form is submitted
if (isset($_POST['submit'])) {
    $searchQuery = $_POST['search'];
    // Escape search query to prevent SQL injection (basic)
    $searchQuery = mysqli_real_escape_string($conn, $searchQuery);
}

// Fetch shoes matching the search query (if empty, this returns all active shoes)
$query = "SELECT * FROM tbl_shoe 
          WHERE (title LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%') 
          AND active = 'Yes'";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShoeHub - Search Results</title>

    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="assets/fontawesome/css/all.min.css" rel="stylesheet">

    <link rel="icon" href="images/favicon.ico" type="image/x-icon">

    <style>
      /* Page basics */
      body { font-family: "Segoe UI", Roboto, Arial, sans-serif; background:#f4f6f9; color:#222; }

      /* Header / navbar */
      .site-header { background: #0b1b2b; color: #fff; }
      .site-header .logo img { width:110px; height:auto; }
      .site-header .nav-link { color: rgba(255,255,255,0.9); }
      .site-header .nav-link:hover { color: #f8d210; }

      /* Search area */
      .shoe-search { padding: 40px 0; background: linear-gradient(115deg, rgba(255,107,129,0.06), rgba(255,107,129,0.02)); }
      .shoe-search .form-control { max-width: 600px; display: inline-block; }

      /* Cards */
      .card .card-img-top { height: 220px; object-fit: cover; }
      .card-title { font-size: 1.05rem; font-weight: 600; }
      .price { color: #d9534f; font-weight: 700; }

      /* Footer */
      .site-footer {
        background: #0f1724;
        color: #d1d9e6;
        padding: 40px 0;
      }
      .site-footer h5 { color: #ffffff; }
      .site-footer .text-muted { color: #a9b3c6 !important; }
      .site-footer a.text-reset { color: inherit; text-decoration: none; }
      .site-footer a.text-reset:hover { color: #f8d210; text-decoration: none; }
      .site-footer .fa-lg { color:#cbd5e1; }
      .site-footer a:hover .fa-lg { color:#f8d210; }

      @media (max-width:767.98px) {
        .shoe-search .form-control { width: 100%; }
      }
    </style>
</head>
<body>

  <!-- NAVBAR -->
  <header class="site-header">
    <nav class="navbar navbar-expand-lg container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="images/logo.png" alt="ShoeHub logo">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon" style="color:#fff;"><i class="fas fa-bars"></i></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="user-dashboard.php"><i class="fas fa-home me-1"></i> Home</a></li>
          <li class="nav-item"><a class="nav-link" href="categories.php"><i class="fas fa-list me-1"></i> Categories</a></li>
          <li class="nav-item"><a class="nav-link" href="shoe.php"><i class="fas fa-shoe-prints me-1"></i> Shoes</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fas fa-envelope me-1"></i> Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="user-logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- SEARCH -->
  <section class="shoe-search text-center">
    <div class="container">
      <form action="shoe-search.php" method="POST" class="d-flex justify-content-center align-items-start gap-2 mb-3">
        <input type="search" name="search" placeholder="Search for shoes or descriptions..." required
               value="<?php echo htmlspecialchars($searchQuery); ?>" class="form-control">
        <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-search me-1"></i> Search</button>
      </form>

      <h2 class="mb-0">Search Results <?php if ($searchQuery !== ""): ?>for <span class="text-primary"><?php echo htmlspecialchars($searchQuery); ?></span><?php endif; ?></h2>
    </div>
  </section>

  <!-- RESULTS -->
  <section class="shoe-menu py-5">
    <div class="container">
      <h3 class="text-center mb-4">Shoes Found</h3>

      <div class="row">
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $image = !empty($row['image_name']) ? 'images/' . htmlspecialchars($row['image_name']) : 'images/default-shoe.jpg';
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo $image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="price mb-2">₱<?php echo number_format((float)$row['price'], 2); ?></p>
                            <p class="card-text text-muted mb-3" style="flex:1;"><?php echo htmlspecialchars($row['description']); ?></p>
                            <div>
                              <a href="order.php?id=<?php echo (int)$row['id']; ?>" class="btn btn-primary">
                                <i class="fas fa-shopping-cart me-1"></i> Order Now
                              </a>
                              <a href="shoe.php" class="btn btn-outline-secondary ms-2">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="col-12"><p class="text-center text-muted">No shoes found matching your search.</p></div>';
        }

        // free result
        if ($result) mysqli_free_result($result);
        ?>
      </div>
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


  <!-- Bootstrap JS -->
  <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
