<?php
include('../config/constants.php');
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

if (!isset($_GET['id'])) {
    header('location:' . SITEURL . 'admin/manage-shoes.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM tbl_shoe WHERE id=$id";
$res = mysqli_query($conn, $sql);

if ($res && mysqli_num_rows($res) == 1) {
    $row = mysqli_fetch_assoc($res);
    $title = $row['title'];
    $description = $row['description'];
    $price = $row['price'];
    $current_image = $row['image_name'];
    $category_id = $row['category_id'];
    $featured = $row['featured'];
    $active = $row['active'];
} else {
    header('location:' . SITEURL . 'admin/manage-shoes.php');
    exit();
}

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";

    // Handle new image upload
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/" . $image_name;

        if (!move_uploaded_file($source_path, $destination_path)) {
            $_SESSION['upload'] = "Failed to Upload Image";
            header("location:" . SITEURL . 'admin/update-shoes.php?id=' . $id);
            exit();
        }
    } else {
        $image_name = $current_image; // Keep current image if no new upload
    }

    $sql2 = "UPDATE tbl_shoe SET 
        title='$title',
        description='$description',
        price='$price',
        image_name='$image_name',
        category_id='$category_id',
        featured='$featured',
        active='$active' 
        WHERE id=$id";

    $res2 = mysqli_query($conn, $sql2);
    $_SESSION['update'] = $res2 ? "Shoe Updated Successfully" : "Failed to Update Shoe";
    header("location:" . SITEURL . 'admin/manage-shoes.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Shoe</title>
<link rel="stylesheet" href="../css/style.css">
<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<?php include('partials/menu.php'); ?>

<div class="main-content">
<div class="wrapper">
<h1>Update Shoe</h1>

<?php
if (isset($_SESSION['update'])) {
    echo "<p style='color:green;'>" . $_SESSION['update'] . "</p>";
    unset($_SESSION['update']);
}
?>

<form action="" method="POST" enctype="multipart/form-data">
<table class='tbl-30'>

<tr>
<td>Title:</td>
<td><input type="text" name="title" value="<?php echo $title; ?>" required></td>
</tr>

<tr>
<td>Description:</td>
<td><textarea name="description" rows="5" required><?php echo $description; ?></textarea></td>
</tr>

<tr>
<td>Price:</td>
<td><input type="number" name="price" value="<?php echo $price; ?>" required></td>
</tr>

<tr>
<td>Current Image:</td>
<td>
<?php
if ($current_image != "") {
    echo "<img src='../images/$current_image' width='100px'>";
} else {
    echo "<i class='fas fa-image fa-2x' style='color:#ccc;'></i>";
}
?>
</td>
</tr>

<tr>
<td>New Image:</td>
<td><input type="file" name="image"></td>
</tr>

<tr>
<td>Category:</td>
<td>
<select name="category_id" required>
<option value="">Select Category</option>
<?php
$sql_cat = "SELECT * FROM tbl_category";
$res_cat = mysqli_query($conn, $sql_cat);
if ($res_cat) {
    while ($row_cat = mysqli_fetch_assoc($res_cat)) {
        $cat_id = $row_cat['id'];
        $cat_title = $row_cat['title'];
        $selected = ($cat_id == $category_id) ? "selected" : "";
        echo "<option value='$cat_id' $selected>$cat_title</option>";
    }
}
?>
</select>
</td>
</tr>

<tr>
<td>Featured:</td>
<td>
<input type="radio" name="featured" value="Yes" <?php if ($featured=="Yes") echo "checked"; ?>> Yes
<input type="radio" name="featured" value="No" <?php if ($featured=="No") echo "checked"; ?>> No
</td>
</tr>

<tr>
<td>Active:</td>
<td>
<input type="radio" name="active" value="Yes" <?php if ($active=="Yes") echo "checked"; ?>> Yes
<input type="radio" name="active" value="No" <?php if ($active=="No") echo "checked"; ?>> No
</td>
</tr>

<tr>
<td colspan="2">
<button type="submit" name="submit" class="btn-secondary">
<i class="fas fa-edit"></i> Update Shoe
</button>
<a href="manage-shoes.php" class="btn-primary">
<i class="fas fa-arrow-left"></i> Back
</a>
</td>
</tr>

</table>
</form>
</div>
</div>

<?php include("partials/footer.php"); ?>
</body>
</html>
