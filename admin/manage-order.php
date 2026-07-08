<?php include('partials/menu.php'); ?>

<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE ORDERS</h1>

        <br /><br />

        <table class="tbl-full" style="border-collapse: collapse; width: 100%; border: 1px solid #a4b0be;">
            <tr>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">S.N</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Shoe</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Price</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Quantity</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Size</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Total</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Order Date</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Status</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Customer Name</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Contact</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Email</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Address</th>
                <th style="border: 1px solid #a4b0be; background-color: #a4b0be; color: #fff; padding: 10px;">Actions</th>
            </tr>

            <?php
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
            $sql = "SELECT o.id, o.shoes, o.price, o.qty, o.size, o.total, o.order_date, o.status, 
                           o.customer_name, o.customer_contact, o.customer_email, o.customer_address, 
                           s.title AS shoe_name 
                    FROM tbl_order o 
                    JOIN tbl_shoe s ON o.shoes = s.id";
            $res = mysqli_query($conn, $sql);

            if ($res) {
                $count = mysqli_num_rows($res);
                if ($count > 0) {
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $shoes = $row['shoe_name'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $size = $row['size'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];

                        echo "<tr>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$sn</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$shoes</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>₱$price</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$qty</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$size</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>₱$total</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$order_date</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$status</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$customer_name</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$customer_contact</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$customer_email</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px;'>$customer_address</td>
                            <td style='border: 1px solid #a4b0be; padding: 10px; text-align: center;'>
                                <a href='delete-order.php?id=$id' class='btn-tertiary' style='text-decoration:none; color:#fff; padding:5px 8px; background-color:#e74c3c; border-radius:5px;'>
                                    <i class='fas fa-trash'></i> Delete
                                </a>
                            </td>
                        </tr>";
                        $sn++;
                    }
                } else {
                    echo "<tr><td colspan='13' style='border: 1px solid #a4b0be; padding: 10px; text-align:center;'>No Orders Found</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>

<?php include("partials/footer.php"); ?>
