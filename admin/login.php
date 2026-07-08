<?php
// Start the session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database constants
include('../config/constants.php');

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            $_SESSION['login'] = "Login Successful";
            $_SESSION['user'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['login'] = "Incorrect Username or Password";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['login'] = "Database query failed";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="../images/favicon.ico">

<style>
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
    font-family: Arial, sans-serif;
    background: #f4f6f9; /* clean neutral background */
}

main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-card {
    background: #fff;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    width: 350px;
}

.login-card h1 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
    font-size: 26px;
    font-weight: bold;
}

.input-group {
    position: relative;
    margin-bottom: 20px;
}

.input-group i {
    position: absolute;
    top: 12px;
    left: 10px;
    color: #999;
}

.input-group input {
    width: 100%;
    padding: 12px 12px 12px 35px;
    border-radius: 6px;
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
}

.input-group input:focus {
    border-color: #007bff;
}

.eye-toggle {
    position: absolute;
    top: 12px;
    right: 10px;
    cursor: pointer;
    color: #999;
}

.btn-login, .btn-back {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 10px;
}

.btn-login {
    background: #007bff;
    color: #fff;
}

.btn-login:hover {
    background: #0056b3;
}

.btn-back {
    background: #6c757d;
    color: #fff;
}

.btn-back:hover {
    background: #5a6268;
}

.error {
    text-align: center;
    color: red;
    margin-bottom: 15px;
    font-weight: bold;
}

/* Footer */
footer {
    width: 100%;
    padding: 40px 30px;
    background: #1a1a1a; /* dark background */
    color: #fff;
}
footer h5 {
    color: #ffffff;
}
footer p, footer small {
    color: #dcdcdc;
}
footer hr {
    border-color: #444;
}
</style>
</head>
<body>

<main>
    <div class="login-card">
        <h1>Admin Login</h1>

        <?php
        if (isset($_SESSION['login'])) {
            echo "<div class='error'>" . $_SESSION['login'] . "</div>";
            unset($_SESSION['login']);
        }
        ?>

        <form action="" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fas fa-eye eye-toggle" id="togglePassword"></i>
            </div>

            <button type="submit" name="submit" class="btn-login">Login</button>
        </form>

        <a href="../index.php" class="btn-back text-center d-block">Back</a>
    </div>
</main>

<!-- ========== FOOTER ========== -->
<footer class="footer">
  <div class="container">
    <div class="row">
      <!-- About Section -->
      <div class="col-md-6">
        <h5 class="fw-bold text-uppercase mb-3">Shoe Online Ordering System</h5>
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

      <!-- Contact Section -->
      <div class="col-md-6">
        <h5 class="fw-bold text-uppercase mb-3">Contact Us</h5>
        <p>
          <i class="fas fa-map-marker-alt me-2"></i> Camiguin, Philippines
        </p>
        <p>
          <i class="fas fa-phone-alt me-2"></i> 09533501578
        </p>
        <p class="mt-3">
          <small>
            Student of <strong>Camiguin Polytechnic State College</strong><br>
            Taking a course of <strong>Bachelor of Science in Information Technology</strong>
          </small>
        </p>
      </div>
    </div>
    <hr class="mt-4">
    <div class="text-start">
      <small>&copy; <?php echo date("Y"); ?> KickStore. All Rights Reserved.</small>
    </div>
  </div>
</footer>

<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});
</script>
</body>
</html>
