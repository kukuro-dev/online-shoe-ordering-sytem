<?php 
// Include the constants file
include('../config/constants.php'); 

// Check if ID is set
if (isset($_GET['id'])) {
    // Get the ID
    $id = $_GET['id'];

    // Database connection
    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

    // Fetch shoe details
    $sql = "SELECT * FROM tbl_shoe WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        // Check if the shoe exists
        $count = mysqli_num_rows($res);
        if ($count == 1) {
            // Get shoe data
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $description = $row['description'];
            $price = $row['price'];
            $image_name = $row['image_name']; // Existing image
            $category_id = $row['category_id'];
            $featured = $row['featured'];
            $active = $row['active'];
        } else {
            // Redirect to manage shoes if shoe not found
            header("location:" . SITEURL . 'admin/manage-order.php');
        }
    }
} else {
    // Redirect to manage shoes if ID is not set
    header("location:" . SITEURL . 'admin/manage-shoes.php');
}

// Handle form submission for updating the shoe
if (isset($_POST['submit'])) {
    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category']; // Ensure you have this field in your form
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // Handle image upload
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $source_path = $_FILES['image']['tmp_name'];
        $destination_path = "../images/" . $image_name; 

        // Move the uploaded file
        if (move_uploaded_file($source_path, $destination_path)) {
            // Remove the previous image if it exists
            if ($image_name != "") {
                unlink("../images/" . $image_name); // Delete old image
            }
        } else {
            $_SESSION['upload'] = "Failed to Upload Image"; 
            header("location:" . SITEURL . 'admin/manage-shoes.php');
            exit();
        }
    } else {
        // If no new image, keep the existing one
        $image_name = $image_name; 
    }

    // Update database
    $sql2 = "UPDATE tbl_shoe SET 
        title='$title', 
        description='$description', 
        price='$price', 
        image_name='$image_name', 
        category_id='$category_id', 
        featured='$featured', 
        active='$active' 
        WHERE id=$id";

    // Execute the query
    $res2 = mysqli_query($conn, $sql2);

    // Set session message based on success or failure
    if ($res2) {
        $_SESSION['update'] = "Shoe Updated Successfully"; 
    } else {
        $_SESSION['update'] = "Failed to Update Shoe"; 
    }

    // Redirect to manage shoes
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
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to your CSS -->
</head>
<body>
    <?php include('partials/menu.php'); ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Shoe</h1>

            <br /><br />

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
                            if ($image_name != "") {
                                echo "<img src='../images/$image_name' alt='$title' width='100px'>";
                            } else {
                                echo "No Image Found";
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
                            <select name="category" required>
                                <?php
                                // Fetch categories for dropdown
                                $sql = "SELECT * FROM tbl_category";
                                $res = mysqli_query($conn, $sql);
                                if ($res == TRUE) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];
                                        // Check if the category is selected
                                        $selected = ($category_id == $category_id) ? "selected" : "";
                                        echo "<option value='$category_id' $selected>$category_title</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes" <?php echo ($featured == "Yes") ? "checked" : ""; ?>> Yes
                            <input type="radio" name="featured" value="No" <?php echo ($featured == "No") ? "checked" : ""; ?>> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="Yes" <?php echo ($active == "Yes") ? "checked" : ""; ?>> Yes
                            <input type="radio" name="active" value="No" <?php echo ($active == "No") ? "checked" : ""; ?>> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Update Shoe" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <?php include("partials/footer.php"); ?>
</body>
</html>
