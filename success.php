<?php
session_start();
if (!isset($_SESSION['order'])) {
    echo '<div class="alert alert-danger text-center mt-5">No order found.</div>';
    exit();
}

$order = $_SESSION['order'];
$grand_total = 0;
foreach ($order['items'] as $item) {
    $grand_total += $item['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Receipt</title>
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<style>
body { font-family: Arial, sans-serif; background:#f8f9fa; }

/* Navbar */
.navbar { background:#fff; padding:10px 30px; box-shadow:0 2px 5px rgba(0,0,0,0.1); display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.navbar .logo img { width:100px; }
.navbar ul { list-style:none; display:flex; gap:20px; margin:0; padding:0; }
.navbar ul li a { color:#ff6b81; font-weight:bold; display:flex; align-items:center; gap:5px; text-decoration:none; }
.navbar ul li a:hover { color:#333; }

/* Receipt Container */
.receipt-container { max-width:900px; margin:0 auto 50px auto; background:#fff; padding:30px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
h2, h3 { text-align:center; margin-bottom:20px; }
.order-info td, .order-info th { padding:10px; vertical-align:top; }
.items th, .items td { vertical-align:middle; }
.items th { background:#ff6b81; color:#fff; }
.print-btn { margin-top:20px; }
.shoe-img { width:60px; height:60px; object-fit:cover; border-radius:5px; }

/* Hide navbar when printing */
@media print {
    .navbar, .print-btn { display: none; }
    body { background: #fff; }
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar container">
    <div class="logo"><a href="index.php"><img src="images/logo.png" alt="Logo"></a></div>
    <ul>
        <li><a href="user-dashboard.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="categories.php"><i class="fas fa-th-large"></i> Categories</a></li>
        <li><a href="shoe.php"><i class="fas fa-shoe-prints"></i> Shoes</a></li>
        <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
    </ul>
</nav>

<div class="receipt-container">
    <h2><i class="fas fa-receipt"></i> Order Receipt</h2>
    <h3>KICKSTORE</h3>

    <table class="table table-bordered order-info mt-4">
        <tr>
            <th><i class="fas fa-user"></i> Customer Name</th>
            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
        </tr>
        <tr>
            <th><i class="fas fa-phone"></i> Contact</th>
            <td><?php echo htmlspecialchars($order['customer_contact']); ?></td>
        </tr>
        <tr>
            <th><i class="fas fa-envelope"></i> Email</th>
            <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
        </tr>
        <tr>
            <th><i class="fas fa-map-marker-alt"></i> Address</th>
            <td><?php echo htmlspecialchars($order['customer_address']); ?></td>
        </tr>
    </table>

    <h4 class="mt-4"><i class="fas fa-box"></i> Ordered Items</h4>
    <table class="table table-striped table-bordered items">
        <thead>
            <tr>
                <th>Shoe</th>
                <th>Size</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($order['items'] as $item): ?>
            <tr>
                <td>
                    <?php if(!empty($item['image_name']) && file_exists("images/".$item['image_name'])): ?>
                        <img src="images/<?php echo $item['image_name']; ?>" class="shoe-img" alt="<?php echo htmlspecialchars($item['title']); ?>">
                    <?php endif; ?>
                    <?php echo htmlspecialchars($item['title']); ?>
                </td>
                <td><?php echo htmlspecialchars($item['size']); ?></td>
                <td><?php echo htmlspecialchars($item['qty']); ?></td>
                <td>₱<?php echo number_format($item['price'],2); ?></td>
                <td>₱<?php echo number_format($item['total'],2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="text-end fw-bold">Grand Total</td>
                <td class="fw-bold">₱<?php echo number_format($grand_total,2); ?></td>
            </tr>
        </tbody>
    </table>

    <button class="btn btn-primary print-btn" onclick="window.print()"><i class="fas fa-print"></i> Print Receipt</button>
</div>

<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
unset($_SESSION['order']); // clear session after showing receipt
?>
