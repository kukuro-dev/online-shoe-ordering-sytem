<?php include('partials/menu.php'); ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Ordering System - Admin</title>

    <!-- Bootstrap and FontAwesome -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<div class="main-content">
    <div class="container-fluid py-4">
        <h1 class="mb-4">Dashboard</h1>
        <div class="row g-4">

            <?php
            // ✅ Connect to database
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

            // ✅ Get total counts
            $category_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_category"))['total'];
            $admin_count    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_admin"))['total'];
            $shoe_count     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_shoe"))['total'];
            $order_count    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_order"))['total'];
            ?>

            <!-- Card: Categories -->
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-list fa-3x text-primary mb-2"></i>
                        <h2><?php echo $category_count; ?></h2>
                        <p class="text-muted">Categories</p>
                    </div>
                </div>
            </div>

            <!-- Card: Admins -->
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-user-shield fa-3x text-success mb-2"></i>
                        <h2><?php echo $admin_count; ?></h2>
                        <p class="text-muted">Admins</p>
                    </div>
                </div>
            </div>

            <!-- Card: Shoes -->
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-shoe-prints fa-3x text-warning mb-2"></i>
                        <h2><?php echo $shoe_count; ?></h2>
                        <p class="text-muted">Shoes</p>
                    </div>
                </div>
            </div>

            <!-- Card: Orders -->
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart fa-3x text-danger mb-2"></i>
                        <h2><?php echo $order_count; ?></h2>
                        <p class="text-muted">Orders</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Chart -->
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> System Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="summaryChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
// ✅ Pass PHP values to JavaScript
const summaryData = {
    labels: ['Admins', 'Categories', 'Shoes', 'Orders'],
    datasets: [{
        label: 'Total Count',
        data: [
            <?php echo $admin_count; ?>,
            <?php echo $category_count; ?>,
            <?php echo $shoe_count; ?>,
            <?php echo $order_count; ?>
        ],
        backgroundColor: [
            'rgba(40, 167, 69, 0.6)',   // Green - Admins
            'rgba(0, 123, 255, 0.6)',   // Blue - Categories
            'rgba(255, 193, 7, 0.6)',   // Yellow - Shoes
            'rgba(220, 53, 69, 0.6)'    // Red - Orders
        ],
        borderColor: [
            'rgba(40, 167, 69, 1)',
            'rgba(0, 123, 255, 1)',
            'rgba(255, 193, 7, 1)',
            'rgba(220, 53, 69, 1)'
        ],
        borderWidth: 2
    }]
};

// ✅ Render Chart
const ctx = document.getElementById('summaryChart').getContext('2d');
new Chart(ctx, {
    type: 'bar', // Change to 'pie' or 'doughnut' if you prefer
    data: summaryData,
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<?php include("partials/footer.php"); ?>
</body>
</html>
