<?php 
include('../config/constants.php'); 

if (!isset($_GET['id'])) {
    header('location:' . SITEURL . 'admin/manage-category.php');
    exit();
}

$id = $_GET['id'];
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
$sql = "SELECT * FROM tbl_category WHERE id=$id";
$res = mysqli_query($conn, $sql);

if ($res == TRUE && mysqli_num_rows($res) == 1) {
    $row = mysqli_fetch_assoc($res);
    $title = $row['title'];
    $image_name = $row['image_name'];
    $featured = $row['featured'];
    $active = $row['active'];
} else {
    header('location:' . SITEURL . 'admin/manage-category.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Category</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
</head>
<body>
<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1><i class="fas fa-edit"></i> Update Category</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class='tbl-30'>
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" required></td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php 
                        if ($image_name != "") {
                            echo "<img src='".SITEURL."images/$image_name' width='100px'>";
                        } else {
                            echo "<i class='fas fa-image'></i> Image not available";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if($featured=="Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if($featured=="No") echo "checked"; ?>> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if($active=="Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if($active=="No") echo "checked"; ?>> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <br>
        <?php
        if (isset($_SESSION['update'])) {
            echo "<div class='success'><i class='fas fa-check-circle'></i> ".$_SESSION['update']."</div>";
            unset($_SESSION['update']);
        }
        ?>

        <br>
        <a href="manage-category.php" class="btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";

    $image_name_new = $image_name; // default keep current image
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name_new = $_FILES['image']['name'];
        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/" . $image_name_new;

        if (!move_uploaded_file($source_path, $destination_path)) {
            $_SESSION['update'] = "<div class='error'><i class='fas fa-exclamation-triangle'></i> Failed to Upload Image</div>";
            header("location:" . SITEURL . 'admin/update-category.php?id=' . $id);
            exit();
        }
    }

    $sql2 = "UPDATE tbl_category SET 
                title='$title',
                image_name='$image_name_new',
                featured='$featured',
                active='$active'
             WHERE id=$id";

    $res2 = mysqli_query($conn, $sql2);

    $_SESSION['update'] = $res2 
        ? "<div class='success'><i class='fas fa-check-circle'></i> Category Updated Successfully</div>"
        : "<div class='error'><i class='fas fa-times-circle'></i> Failed to Update Category</div>";

    header('location:' . SITEURL . 'admin/manage-category.php');
    exit();
}
?>
