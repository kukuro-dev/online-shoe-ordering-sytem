<?php
include('config/constants.php');

// Fetch new releases from the database
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
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">

    
    <style>
        /* Navigation Bar */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: white;
            padding: 10px 20px;
            color: #fff;
        }
        .navbar .logo img {
            height: 80px;
        }
        .navbar ul {
            list-style: none;
            display: flex;
        }
        .navbar ul li {
            margin: 0 15px;
        }
        .navbar ul li a {
            color: #ff6b81; /* Font color */
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .navbar ul li a:hover {
            color: #333; /* Dark gray hover effect */
        }

        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .text-center {
            text-align: center;
        }
        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
        }
        .shoes-row, .category-row {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .shoe-box, .category-box {
            flex: 1;
            margin: 0 10px;
            text-align: center;
            border: 2px solid #ff6b81; /* Added border */
            padding: 10px; /* Added padding */
            border-radius: 5px; /* Rounded corners */
        }
        .shoe-box img, .category-box img {
            width: 80%;
            height: auto;
            display: block;
            margin: auto;
            border-radius: 5px;
        }
        .shoe-box h4, .category-box h4 {
            margin-top: 10px;
            font-size: 16px;
            color: #333;
        }
        video {
            display: block;
            margin: 20px auto;
            width: 80%;
            height: auto;
        }
        .card-container {
            display: flex;
            justify-content: space-around;
            margin: 20px auto;
        }
        .card {
            width: 45%;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid #ff6b81; /* Added border */
            margin: 10px;
        }
        .card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .card h3 {
            margin-top: 10px;
            font-size: 18px;
            color: #333;
        }

        /* Title Styles */
        .store-title {
            font-size: 48px;
            color: #ff6b81;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 10px #ff6b81, 0 0 20px #ff6b81, 0 0 30px #ff6b81;
            margin-top: 50px;
        }

        .title-line {
            width: 80%;
            border-top: 2px solid #ff6b81;
            margin: 20px auto;
        }

        /* Added border around sections */
        .section-border {
            border: 2px solid #ff6b81;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Footer Styles */
        .footer {
            background: #f9f9f9;
            padding: 20px 0;
            text-align: center;
        }

        .footer p {
            font-weight: bold;
            color: #ffffffff;
        }

        .footer p a {
            color: #ff4757;
            text-decoration: none;
        }

        .footer p a:hover {
            text-decoration: underline;
        }

     
        /* Social Media Section */
        .social {
            padding: 30px 0; /* Increased padding to make it larger */
        }

        .social ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        .social ul li {
            margin: 0 15px; /* Increased space between icons */
        }

        .social ul li a img {
            width: 40px; /* Increased icon size */
            height: auto;
            transition: transform 0.3s ease-in-out;
        }

        .social ul li a img:hover {
            transform: scale(1.2);
        }

        .navbar ul li a i {
    margin-right: 8px; /* space between icon and text */
}

    </style>
</head>

<body>

<!-- Navigation Bar -->
<div class="navbar">
    <div class="logo">
        <img src="images/logo.png" alt="Logo">
    </div>
    <ul>
    <li><a href="user-dashboard.php"><i class="fa-solid fa-house"></i> Home</a></li>
    <li><a href="categories.php"><i class="fa-solid fa-list"></i> Categories</a></li>
    <li><a href="shoe.php"><i class="fa-solid fa-shoe-prints"></i> Shoes</a></li>
    <li><a href="contact.php"><i class="fa-solid fa-envelope"></i> Contact</a></li>
    <li><a href="index.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
</ul>
   
</div>

<!-- Store Title and Line -->
<div class="store-title">
    KICKSTORE STORE
</div>

<div class="title-line"></div>

<!-- Carousel -->
<div class="carousel">
    <button class="carousel-btn" id="prev">&#10094;</button>
    <div class="carousel-images" id="carousel-images">
        <img src="images/shoe1.jpg" alt="Shoe 1">
        <img src="images/shoe2.jpg" alt="Shoe 2">
        <img src="images/shoe3.png" alt="Shoe 3">
        <img src="images/shoe4.jpg" alt="Shoe 4">
        <img src="images/shoe5.jpg" alt="Shoe 5">
        <img src="images/shoe6.jpg" alt="Shoe 6">
        <img src="images/shoe7.jpg" alt="Shoe 7">
    </div>
    <button class="carousel-btn" id="next">&#10095;</button>
</div>

<style>
.carousel {
    position: relative;
    max-width: 90%;
    margin: 30px auto;
    overflow: hidden;
    border-radius: 10px;
    border: 2px solid #ff6b81;
    height: 600px;
}
.carousel-images {
    display: flex;
    transition: transform 0.5s ease-in-out;
    height: 100%;
}
.carousel-images img {
    min-width: 100%;
    object-fit: cover;
    border-radius: 10px;
}
.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    font-size: 30px;
    color: #fff;
    background: rgba(0,0,0,0.5);
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    border-radius: 50%;
    z-index: 10;
}
#prev { left: 10px; }
#next { right: 10px; }
</style>

<script>
const carousel = document.getElementById('carousel-images');
const images = carousel.getElementsByTagName('img');
let index = 0;

function showSlide(i){
    if(i < 0) index = images.length - 1;
    else if(i >= images.length) index = 0;
    else index = i;
    carousel.style.transform = `translateX(-${index * 100}%)`;
}

document.getElementById('prev').addEventListener('click', () => showSlide(index-1));
document.getElementById('next').addEventListener('click', () => showSlide(index+1));

// Auto-slide every 5 seconds
setInterval(() => showSlide(index+1), 5000);
</script>


<!-- Shoes Section with Boundary -->
<section class="shoes section-border">
    <div class="container">
        <h2 class="text-center">Available Shoes</h2>
        <div class="shoes-row">
            <?php
            // Fetch 3 shoes from the database
            $query = "SELECT * FROM tbl_shoe WHERE active = 'Yes' LIMIT 3";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = htmlspecialchars($row['title']);
                    $price = htmlspecialchars($row['price']);
                    $image_name = htmlspecialchars($row['image_name']);
                    $image_path = 'images/' . $image_name; // Assuming images are stored in the 'images' folder
            ?>
                    <div class="shoe-box">
                        <img src="<?php echo $image_path; ?>" alt="<?php echo $title; ?>">
                        <h4><?php echo $title; ?></h4>
                        <p>Price: ₱<?php echo $price; ?></p>
                    </div>
            <?php
                }
            } else {
                echo '<p class="text-center">No shoes available at the moment.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Cards Section with Boundary -->
<section class="cards-section section-border">
    <div class="container">
        <div class="card-container">
            <div class="card">
                <img src="images/card1.jpg" alt="Card1">
                <h3>"Every Step, A Statement."</h3>
            </div>
            <div class="card">
                <img src="images/card2.jpg" alt="Card2">
                <h3>"Shoe Your Style, Own the Moment."</h3>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section with Boundary -->
<section class="categories section-border">
    <div class="container">
        <h2 class="text-center">Explore Shoe Categories</h2>
        <div class="category-row">
            <?php
            // Fetch 3 categories from the database
            $query = "SELECT * FROM tbl_category WHERE active = 'Yes' LIMIT 3";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $title = htmlspecialchars($row['title']);
                    $image_name = htmlspecialchars($row['image_name']);
                    $image_path = 'images/' . $image_name; // Assuming images are stored in the 'images' folder
            ?>
                    <div class="category-box">
                        <img src="<?php echo $image_path; ?>" alt="<?php echo $title; ?>">
                        <h4><?php echo $title; ?></h4>
                    </div>
            <?php
                }
            } else {
                echo '<p class="text-center">No categories available at the moment.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- First Video Section -->
<section class="video-section">
    <div class="container">
        <video controls>
        <source src="video/vid1.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</section>

<!-- Cards Section -->
<section class="cards-section section-border">
    <div class="container">
        <div class="card-container">
            <div class="card">
                <img src="images/image.jpg" alt="Card 1">
                <h3>"Every Journey Begins with the Right Step."</h3>
            </div>
            <div class="card">
                <img src="images/image1.jpg" alt="Card 2">
                <h3>"Walk the Path of Comfort and Style."</h3>
            </div>
        </div>
    </div>
</section>

<!-- Second Video Section -->
<section class="video-section">
    <div class="container">
        <video controls>
            <source src="video/vid.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</section>


<!-- Cards Section -->
<section class="cards-section section-border">
    <div class="container">
        <div class="card-container">
            <div class="card">
                <img src="images/ee.jpg" alt="Card 1">
                <h3>"Where Comfort Meets Fashion."</h3>
            </div>
            <div class="card">
                <img src="images/sh.jpg" alt="Card 2">
                <h3>"Step Up Your Game."</h3>
            </div>
        </div>
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
    <hr class="mt-4 border-light">
    <div class="text-start">
      <small>&copy; <?php echo date("Y"); ?> KickStore. All Rights Reserved.</small>
    </div>
  </div>
</footer>

    

</body>
</html>
