<?php include('../config/constants.php'); ?>
<html>
<head>
    <title>Shoe Store Website</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
     <link rel="icon" type="image/x-icon" href="../images/favicon.ico"> <!-- For .ico -->
    
</head>
<body>
    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li>
                    <a href="index.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="manage-admin.php"><i class="fas fa-user-shield"></i> Admin</a>
                </li>
                <li>
                    <a href="manage-category.php"><i class="fas fa-list"></i> Category</a>
                </li>
                <li>
                    <a href="manage-shoes.php"><i class="fas fa-shoe-prints"></i> Shoes</a>
                </li>
                <li>
                    <a href="manage-order.php"><i class="fas fa-shopping-cart"></i> Order</a>
                </li>
                <li>
                    <a href="<?php echo SITEURL; ?>admin/logout.php" class="btn-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li> 
            </ul>
        </div>
    </div>
</body>
</html>
