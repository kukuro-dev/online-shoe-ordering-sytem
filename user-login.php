<?php
include('config/constants.php');

$sql = "SELECT s.*, c.title AS category_title 
        FROM tbl_shoe s 
        JOIN tbl_category c ON s.category_id = c.id 
        WHERE s.active = 'Yes' 
        ORDER BY s.id DESC 
        LIMIT 6";
$result = mysqli_query($conn, $sql);
$new_releases = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">

    <style>
        body {
            background-image: url('images/logbg.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        /* Top Label */
        .top-label {
            position: absolute;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 36px;
            font-weight: bold;
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
            animation: wave 0.5s infinite;
            animation-iteration-count: 20;
            text-align: center;
        }

        @keyframes wave {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .login-panel h2 {
            font-size: 32px;
            font-weight: bold;
            color: #fff;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
            animation: wave 0.5s infinite;
            animation-iteration-count: 20;
            text-align: center;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 120px;
            gap: 20px;
        }

        .login-panel {
            background-color: rgba(255, 107, 129, 0.9);
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
        }

        .discovery-section {
            flex-grow: 1;
            padding: 20px;
            background-color: rgba(255, 107, 129, 0.8);
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 300px;
            max-width: 600px;
        }

        .shoe-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .shoe {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 45%;
            margin: 10px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .shoe:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }

        .shoe img {
            width: 80%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .shoe h3, .shoe p { color: #000; }

        .btn i { margin-right: 5px; }

        video { max-width: 100%; height: auto; margin-top: 20px; }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                margin-top: 100px;
            }

            .discovery-section {
                max-width: 100%;
            }

            .shoe {
                width: 80%;
            }
        }
    </style>
</head>
<body>

<div class="top-label">WELCOME TO OUR KICKSTORE</div>

<div class="container">
    <!-- Login Panel -->
    <div class="login-panel">
        <h2><i class="fas fa-user-circle"></i> Log In</h2>
        <form action="login-process.php" method="POST">
            <!-- Username -->
            <div class="mb-3">
                <label class="form-label text-white">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label text-white">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="fas fa-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>
            </div>

            <!-- Buttons stacked -->
            <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-sign-in-alt"></i> Log In
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </form>

        <p class="mt-3 text-white text-center">
            Don't have an account? 
            <a href="user-signup.php" class="text-white text-decoration-underline">Sign Up</a>
        </p>
    </div>

    <!-- Discovery Section -->
    <div class="discovery-section">
        <h2>Discover New Brands</h2>
        <p>Check out our latest shoe releases!</p>

        <video autoplay muted loop>
            <source src="video/shoe_video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div class="shoe-container">
            <?php if (!empty($new_releases)): ?>
                <?php foreach ($new_releases as $shoe): ?>
                    <div class="shoe">
                        <img src="images/<?php echo htmlspecialchars($shoe['image_name']); ?>" alt="<?php echo htmlspecialchars($shoe['title']); ?>">
                        <h3><?php echo htmlspecialchars($shoe['title']); ?></h3>
                        <p>Price: $<?php echo htmlspecialchars($shoe['price']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No new releases to display!</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- JS Scripts -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/fontawesome/js/all.min.js"></script>

<script>
    // Eye toggle
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        if(type === 'password') {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });
</script>

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


</body>
</html>

<?php
mysqli_close($conn);
?>
