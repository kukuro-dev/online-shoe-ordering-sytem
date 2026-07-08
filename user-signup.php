<?php
include('config/constants.php');

$sql = "SELECT s.*, c.title AS category_title 
        FROM tbl_shoe s 
        JOIN tbl_category c ON s.category_id = c.id 
        WHERE s.active = 'yes' 
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
    <title>User Sign Up</title>

    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
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
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-image: url('images/shoebg.jpg');
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 120px; 
            text-align: center;
            color: #fff;
        }

        header h1 {
            font-size: 36px;
            margin: 0;
            text-transform: uppercase;
            animation: wave 0.5s infinite;
            animation-iteration-count: 20;
        }

        @keyframes wave {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
            width: 90%;
            max-width: 1200px;
        }

        .signup-panel {
            background-color: rgba(255,107,129,0.9);
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
        }

        .signup-panel h2 {
            font-size: 28px;
            text-align: center;
            animation: wave 0.5s infinite;
            animation-iteration-count: 20;
        }

        .input-group-text { background-color: #fff; border: none; }

        .form-control { border-radius: 0 5px 5px 0; }

        .btn {
            background-color: #7bed9f;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            width: 100%;
            margin-top: 10px;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #2ed573;
            color: #fff;
            transform: scale(1.05);
        }

        .discovery-section {
            background-color: rgba(255,107,129,0.9);
            padding: 20px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 300px;
            max-width: 600px;
        }

        video { max-width: 100%; height: auto; margin-top: 10px; }

        @media (max-width: 768px) {
            .container { flex-direction: column; }
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome to Our KICKSTORE Store</h1>
</header>

<div class="container">
    <div class="signup-panel">
        <h2><i class="fas fa-user-plus"></i> Sign Up</h2>
        <form action="signup-process.php" method="POST">
            <!-- Username -->
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="fas fa-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn"><i class="fas fa-user-plus"></i> Sign Up</button>
            <a href="user-login.php" class="btn btn-secondary mt-2"><i class="fas fa-arrow-left"></i> Back</a>
        </form>
    </div>

    <div class="discovery-section">
        <h2>Check out our video below!</h2>
        <video controls>
            <source src="video/Epic.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</div>

<section class="footer text-center mt-3">
    <p>All rights reserved. Designed By <a href="#" class="text-white text-decoration-underline">Aaron Aranas</a></p>
</section>

<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/fontawesome/js/all.min.js"></script>
<script>
    // Eye toggle password
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        eyeIcon.classList.toggle('fa-eye');
        eyeIcon.classList.toggle('fa-eye-slash');
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
