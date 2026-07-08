<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1><i class="fas fa-user-plus"></i> ADD ADMIN</h1>

        <br /><br />

        <form action="" method="POST">
            <table class='tbl-30'>
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <div class="input-group">
                            <i class="fas fa-id-card"></i>
                            <input type="text" name="full_name" placeholder="Enter Your Name" required>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" placeholder="Enter Your Username" required>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Enter Your Password" required>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                        <a href="manage-admin.php" class="btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                    </td>
                </tr>
            </table>
        </form>

        <br />

        <?php
        // Display message at the bottom
        if (isset($_SESSION['add'])) {
            echo "<div class='success-msg'><i class='fas fa-check-circle'></i> " . $_SESSION['add'] . "</div>";
            unset($_SESSION['add']); // Clear the message after displaying
        }
        ?>
        
    </div>
</div>

<?php include("partials/footer.php"); ?>

<?php
if (isset($_POST['submit'])) {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Storing the password as plain text

    $sql = "INSERT INTO tbl_admin SET
        full_name='$full_name',
        username='$username',
        password='$password'"; 

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
    $res = mysqli_query($conn, $sql);

    if ($res == TRUE) {
        $_SESSION['add'] = "Admin Added Successfully"; 
    } else {
        $_SESSION['add'] = "Failed to Add Admin"; 
    }

    header("location:".SITEURL.'admin/add-admin.php'); 
}
?>
