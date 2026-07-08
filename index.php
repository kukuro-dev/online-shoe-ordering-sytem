<?php
session_start();
$isLoggedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Ordering System</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">

    <style>
        body {
            background-image: url('images/indexbg.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            color: #fff;
            font-family: Arial, sans-serif;
        }

        /* Navbar */
        .navbar {
            background: rgba(0,0,0,0.8);
            padding: 10px 0;
        }

        .navbar .logo img {
            width: 80px;
            animation: flip 2s linear forwards;
            animation-iteration-count: 5; /* ~10 seconds if 2s per rotation */
        }

        @keyframes flip {
            0% { transform: rotateY(0deg); }
            50% { transform: rotateY(180deg); }
            100% { transform: rotateY(360deg); }
        }

        .navbar .menu {
            float: right;
        }

        .navbar .menu ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .navbar .menu ul li {
            display: inline-block;
            margin-left: 15px;
        }

        .navbar .menu ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .header {
            background: rgba(0,0,0,0.5);
            text-align: center;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header h1 {
            font-size: 50px;
            animation: wave 3s infinite linear;
        }

        @keyframes wave {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Categories Section */
        .categories {
            padding: 50px 0;
        }

        .categories h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .categories .shoe-row {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .categories .box-3 {
            background: rgba(255,255,255,0.9);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .categories .box-3:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 12px rgba(0,0,0,0.3);
            cursor: pointer;
        }

        .categories .box-3 img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        .video-section {
            background: rgba(47,53,66,0.9);
            padding: 50px 0;
            color: #fff;
            text-align: center;
            display: none;
        }

        .video-section video {
            width: 100%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.5);
        }

        .footer {
            background: rgba(0,0,0,0.8);
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .footer a {
            color: #ff6b6b;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .navbar .menu { float: none; text-align: center; margin-top: 10px; }
            .categories .shoe-row { justify-content: center; }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
            </div>
            <div class="menu">
                <ul>
                    <?php if ($isLoggedIn): ?>
                        <li><a href="user-profile.php"><i class="fas fa-user"></i> Profile</a></li>
                        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    <?php else: ?>
                        <li><a href="user-login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="user-signup.php"><i class="fas fa-user-plus"></i> Sign Up</a></li>
                        <li><a href="admin/login.php"><i class="fas fa-user-shield"></i> Admin</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section class="header">
        <h1>Explore Our KICKSTORE Store</h1>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <h2>Explore Shoe Brands</h2>
            <div class="shoe-row">
                <a href="https://www.nike.com" target="_blank">
                    <div class="box-3">
                        <img src="images/nike.jpg" alt="Nike">
                        <h3>Nike</h3>
                    </div>
                </a>
                <a href="https://www.adidas.com" target="_blank">
                    <div class="box-3">
                        <img src="images/adidas.jpg" alt="Adidas">
                        <h3>Adidas</h3>
                    </div>
                </a>
                <a href="https://www.puma.com" target="_blank">
                    <div class="box-3">
                        <img src="images/puma.jpg" alt="Puma">
                        <h3>Puma</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="video-section" id="video-section">
        <div class="container">
            <h2>Discover the Latest Trends</h2>
            <video id="shoe-video" autoplay loop>
                <source src="video/shoe_video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </section>

    <!-- ========== FOOTER ========== -->
<footer class="footer bg-dark text-light py-5 mt-5">
  <div class="container">
    <div class="row">
      <!-- About Section -->
      <div class="col-md-6">
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
      <div class="col-md-6">
        <h5 class="fw-bold text-uppercase mb-3">Contact Us</h5>
        <p><i class="fas fa-map-marker-alt me-2"></i> Camiguin, Philippines</p>
        <p><i class="fas fa-phone-alt me-2"></i> 09533501578</p>
        <p class="mt-3">
          <small>
            Student of <strong>Camiguin Polytechnic State College</strong><br>
            Taking a course of <strong>Bachelor of Science in Information Technology</strong>
          </small>
        </p>
      </div>
    </div>
    <hr class="border-light mt-4">
    <div class="text-center">
      <small>&copy; <?php echo date("Y"); ?> KickStore. All Rights Reserved.</small>
    </div>
  </div>
</footer>


    <script>
        // Show video after 3 seconds
        setTimeout(function() {
            document.getElementById('video-section').style.display = 'block';
            document.getElementById('shoe-video').play();
        }, 3000);
    </script>
</body>
</html>
