<?php
// Start session
session_start();
include('config/constants.php'); // Database connection

// Function to get the recent order of a user
function getRecentOrder($conn, $user_id) {
    $userSql = "SELECT username FROM tbl_users WHERE id = '$user_id'";
    $userResult = mysqli_query($conn, $userSql);
    if ($userRow = mysqli_fetch_assoc($userResult)) {
        $username = $userRow['username'];
        $sql = "SELECT shoes, price, qty, total, order_date, status 
                FROM tbl_order 
                WHERE customer_name = '$username' 
                ORDER BY order_date DESC 
                LIMIT 1";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($result);
    }
    return null;
}

function getCategories($conn) {
    $sql = "SELECT title FROM tbl_category WHERE active = 'Yes'";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['title'];
    }
    return $categories;
}

function getAllShoes($conn) {
    $sql = "SELECT title, price FROM tbl_shoe WHERE active = 'Yes'";
    $result = mysqli_query($conn, $sql);
    $shoes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $shoes[] = $row['title'] . " - ₱" . $row['price'];
    }
    return $shoes;
}

function getAdminDetails() {
    return "Admin Contact: 09533591578, Facebook: Anonymous Database";
}

function getUserDetails($user_id, $conn) {
    $sql = "SELECT username, email FROM tbl_users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Handle chatbot responses
function getChatbotResponse($message, $conn, $user_id) {
    $message = strtolower(trim($message));
    $response = "";

    if (in_array($message, ['hi', 'hello'])) {
        $response = "Hello! How can I assist you today?";
    } elseif (strpos($message, 'order') !== false) {
        $order = getRecentOrder($conn, $user_id);
        $response = $order 
            ? "Your recent order: " . $order['shoes'] . " (Qty: " . $order['qty'] . "), Total: ₱" . $order['total'] . ". Status: " . $order['status'] . "." 
            : "You haven't placed any orders yet.";
    } elseif (strpos($message, 'category') !== false) {
        $categories = getCategories($conn);
        $response = !empty($categories) ? "Available categories: " . implode(', ', $categories) . "." : "No categories available.";
    } elseif (strpos($message, 'shoes') !== false) {
        $shoes = getAllShoes($conn);
        $response = !empty($shoes) ? "Available shoes: " . implode(', ', $shoes) . "." : "No shoes available.";
    } elseif (strpos($message, 'admin') !== false) {
        $response = getAdminDetails();
    } elseif (strpos($message, 'user') !== false) {
        $userDetails = getUserDetails($user_id, $conn);
        $response = $userDetails ? "You are logged in as: " . $userDetails['username'] . "." : "User details not found.";
    } elseif (strpos($message, 'email') !== false) {
        $userDetails = getUserDetails($user_id, $conn);
        $response = $userDetails ? "Your email is: " . $userDetails['email'] . "." : "Email not found.";
    } elseif (strpos($message, 'username') !== false) {
        $userDetails = getUserDetails($user_id, $conn);
        $response = $userDetails ? "Your username is: " . $userDetails['username'] . "." : "Username not found.";
    } else {
        $response = "Please clarify your text. You can ask about orders, categories, shoes, admin, or your account details.";
    }

    return $response;
}

// AJAX response
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $user_id = $_SESSION['user_id'] ?? null;
    $message = $_POST['message'];
    $response = getChatbotResponse($message, $conn, $user_id);
    echo json_encode(['response' => $response]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - Shoe Ordering System</title>
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<style>
body { font-family: Arial, sans-serif; background:#f8f9fa; }
.navbar { background:#fff; padding:15px 20px; box-shadow:0 2px 5px rgba(0,0,0,0.1); position:fixed; top:0; width:100%; z-index:1000;}
.navbar ul li a { color:#ff6b81; font-weight:600; }
.navbar ul li a:hover { color:#333; }
.navbar .menu ul { list-style:none; padding:0; margin:0; display:flex; gap:20px;}
.chatbox-container { max-width:500px; margin:120px auto 50px auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);}
.chatbox { height:400px; overflow-y:auto; background:#fdfdfd; padding:10px;}
.user-message, .bot-response { padding:10px 15px; border-radius:25px; margin:10px 0; max-width:80%; display:flex; align-items:center; gap:8px; word-wrap:break-word;}
.user-message { background:#d1e7fd; margin-left:auto;}
.bot-response { background:#fff3cd; margin-right:auto;}
.input-box { display:flex; margin-top:10px;}
.input-box input { flex:1; border-radius:25px; padding:10px;}
.input-box button { border-radius:25px; padding:10px 15px;}
.social ul { list-style:none; display:flex; justify-content:center; padding:0; gap:15px;}
.social ul li a img { width:40px; transition: transform 0.3s; }
.social ul li a img:hover { transform:scale(1.2);}
.footer { background:#111; color:#fff; padding:30px 20px; margin-top:40px; }
.footer .col-md-6 { margin-bottom:15px; }
</style>
</head>
<body>

<!-- Navbar -->
<section class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Logo" style="width:100px;"></a>
        </div>
        <div class="menu">
            <ul>
                <li><a href="user-dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="categories.php"><i class="fas fa-list"></i> Categories</a></li>
                <li><a href="shoe.php"><i class="fas fa-shoe-prints"></i> Shoes</a></li>
                <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
            </ul>
        </div>
    </div>
</section>

<!-- Chatbox -->
<section class="chatbox-container">
    <div class="chatbox" id="chatbox"></div>
    <div class="input-box">
        <input type="text" id="userMessage" placeholder="Type a message..." autocomplete="off">
        <button id="sendMessage" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send</button>
    </div>
</section>

<!-- Social -->
<section class="social mt-5">
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
<script>
document.getElementById('sendMessage').addEventListener('click', function() {
    const message = document.getElementById('userMessage').value;
    if (!message.trim()) return;
    const chatbox = document.getElementById('chatbox');

    const userDiv = document.createElement('div');
    userDiv.classList.add('user-message');
    userDiv.innerHTML = '<i class="fas fa-user"></i> ' + message;
    chatbox.appendChild(userDiv);

    fetch('contact.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'message=' + encodeURIComponent(message)
    })
    .then(res => res.json())
    .then(data => {
        const botDiv = document.createElement('div');
        botDiv.classList.add('bot-response');
        botDiv.innerHTML = '<i class="fas fa-robot"></i> ' + data.response;
        chatbox.appendChild(botDiv);
        chatbox.scrollTop = chatbox.scrollHeight;
    });

    document.getElementById('userMessage').value = '';
});
</script>
</body>
</html>
