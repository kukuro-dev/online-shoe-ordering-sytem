<?php 
include('../config/constants.php'); 
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";

    if (isset($_FILES['image_name']['name']) && $_FILES['image_name']['name'] != "") {
        $image_name = $_FILES['image_name']['name'];
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "Shoe_" . time() . "." . $ext;
        $source_path = $_FILES['image_name']['tmp_name'];
        $destination_path = "../images/" . $image_name;

        if (!move_uploaded_file($source_path, $destination_path)) {
            $_SESSION['add'] = "Failed to Upload Image"; 
            header("location:" . SITEURL . 'admin/add-shoes.php');
            exit();
        }
    } else {
        $image_name = "";
    }

    $sql = "INSERT INTO tbl_shoe (title, description, price, image_name, category_id, featured, active) 
            VALUES ('$title', '$description', '$price', '$image_name', '$category_id', '$featured', '$active')";
    $res = mysqli_query($conn, $sql);

    $_SESSION['add'] = $res ? "Shoe Added Successfully" : "Failed to Add Shoe";
    header("location:" . SITEURL . 'admin/add-shoes.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Shoe</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
</head>
<body>
<?php include('partials/menu.php'); ?>

<div class="main-content">
<div class="wrapper">
<h1>ADD SHOE</h1>

<form action="" method="POST" enctype="multipart/form-data">
<table class='tbl-30'>
<tr>
<td>Title:</td>
<td><input type="text" name="title" placeholder="Enter Shoe Title" required></td>
</tr>

<tr>
<td>Description:</td>
<td><textarea name="description" placeholder="Enter Shoe Description" required></textarea></td>
</tr>

<tr>
<td>Price:</td>
<td><input type="number" name="price" placeholder="Enter Shoe Price" required></td>
</tr>

<tr>
<td>Image:</td>
<td><input type="file" name="image_name" required></td>
</tr>

<tr>
<td>Category:</td>
<td>
<select name="category_id" required>
<option value="">Select Category</option>
<?php
$category_sql = "SELECT * FROM tbl_category";
$category_res = mysqli_query($conn, $category_sql);
if ($category_res) {
    while ($category_row = mysqli_fetch_assoc($category_res)) {
        $cat_id = $category_row['id'];
        $cat_title = $category_row['title'];
        echo "<option value='$cat_id'>$cat_title</option>";
    }
}
?>
</select>
</td>
</tr>

<tr>
<td>Featured:</td>
<td>
<input type="radio" name="featured" value="Yes" required> Yes
<input type="radio" name="featured" value="No" required checked> No
</td>
</tr>

<tr>
<td>Active:</td>
<td>
<input type="radio" name="active" value="Yes" required> Yes
<input type="radio" name="active" value="No" required checked> No
</td>
</tr>

<tr>
<td colspan="2">
<button type="submit" name="submit" class="btn-secondary"><i class="fas fa-plus"></i> Add Shoe</button>
<a href="manage-shoes.php" class="btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
</td>
</tr>
</table>
</form>

<?php
if (isset($_SESSION['add'])) {
    echo "<div class='success-message'><i class='fas fa-check-circle'></i> ".$_SESSION['add']."</div>";
    unset($_SESSION['add']);
}
?>

</div>
</div>

<?php include('partials/footer.php'); ?>
</body>
</html>
