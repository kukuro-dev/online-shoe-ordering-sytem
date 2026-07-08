<?php 
include('../config/constants.php'); 

if (!isset($_GET['id'])) {
    header('location:' . SITEURL . 'admin/manage-admin.php');
    exit;
}

$id = $_GET['id'];
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

$sql = "SELECT * FROM tbl_admin WHERE id=$id";
$res = mysqli_query($conn, $sql);

if ($res && mysqli_num_rows($res) == 1) {
    $row = mysqli_fetch_assoc($res);
    $full_name = $row['full_name'];
    $username = $row['username'];
    $password = $row['password'];
} else {
    header('location:' . SITEURL . 'admin/manage-admin.php');
    exit;
}
?>

<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1><i class="fas fa-user-edit"></i> UPDATE ADMIN</h1>

        <br /><br />

        <form action="" method="POST">
            <table class='tbl-30'>
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <div class="input-group">
                            <i class="fas fa-id-card"></i>
                            <input type="text" name="full_name" value="<?php echo $full_name; ?>" required>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" value="<?php echo $username; ?>" required>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" value="<?php echo $password; ?>" required>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                        <a href="manage-admin.php" class="btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
                    </td>
                </tr>
            </table>
        </form>

        <br />

        <?php
        if (isset($_SESSION['update'])) {
            echo "<div class='success-msg'><i class='fas fa-check-circle'></i> " . $_SESSION['update'] . "</div>";
            unset($_SESSION['update']);
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "UPDATE tbl_admin SET 
            full_name='$full_name',
            username='$username',
            password='$password' 
            WHERE id=$id";

    $res = mysqli_query($conn, $sql);

    $_SESSION['update'] = $res ? "Admin Updated Successfully" : "Failed to Update Admin";

    header('location:' . SITEURL . 'admin/manage-admin.php'); 
    exit;
}
?>
