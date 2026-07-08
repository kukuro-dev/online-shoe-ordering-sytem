<?php 
include('../config/constants.php'); 

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";
    
    // Handle image upload
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/" . $image_name; 

        if (!move_uploaded_file($source_path, $destination_path)) {
            $_SESSION['add'] = "<div class='error'><i class='fas fa-exclamation-triangle'></i> Failed to Upload Image</div>"; 
            header("location:" . SITEURL . 'admin/add-category.php');
            exit();
        }
    } else {
        $image_name = ""; 
    }

    $sql = "INSERT INTO tbl_category SET 
        title='$title', 
        image_name='$image_name', 
        featured='$featured', 
        active='$active'";

    $res = mysqli_query($conn, $sql);

    $_SESSION['add'] = $res 
        ? "<div class='success'><i class='fas fa-check-circle'></i> Category Added Successfully</div>" 
        : "<div class='error'><i class='fas fa-times-circle'></i> Failed to Add Category</div>";

    header("location:" . SITEURL . 'admin/add-category.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
</head>
<body>
    <?php include('partials/menu.php'); ?>
    <div class="main-content">
        <div class="wrapper">
            <h1><i class="fas fa-plus-circle"></i> ADD CATEGORY</h1>

            <br /><br />

            <form action="" method="POST" enctype="multipart/form-data">
                <table class='tbl-30'>
                    <tr>
                        <td>Title:</td>
                        <td><input type="text" name="title" placeholder="Enter Category Title" required></td>
                    </tr>

                    <tr>
                        <td>Image:</td>
                        <td><input type="file" name="image" required></td>
                    </tr>

                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No" checked> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No" checked> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>

            <br />

            <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            ?>

            <br />
            <a href="manage-category.php" class="btn-primary"><i class="fas fa-arrow-left"></i> Back</a>

        </div>
    </div>
    <?php include('partials/footer.php'); ?>
</body>
</html>
