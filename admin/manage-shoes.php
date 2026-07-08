<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE SHOES</h1>

        <br /><br />

        <a href="add-shoes.php" class="btn-primary">
            <i class="fas fa-plus"></i> Add Shoe
        </a> <!-- Button to add shoes -->

        <br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Category</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

            $sql = "SELECT tbl_shoe.*, tbl_category.title AS category_title 
                    FROM tbl_shoe 
                    JOIN tbl_category ON tbl_shoe.category_id = tbl_category.id";
            $res = mysqli_query($conn, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res);

                if ($count > 0) {
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $category_title = $row['category_title'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        echo "<tr>
                            <td>$sn</td>
                            <td>$title</td>
                            <td>$description</td>
                            <td>₱" . number_format($price, 2) . "</td>
                            <td>";
                                if($image_name != ""){
                                    echo "<img src='../images/$image_name' alt='$title' width='100px'>";
                                } else {
                                    echo "<i class='fas fa-image fa-2x' style='color: #ccc;'></i>";
                                }
                        echo "</td>
                            <td>$category_title</td>
                            <td>$featured</td>
                            <td>$active</td>
                            <td>
                                <a href='update-shoes.php?id=$id' class='btn-secondary'>
                                    <i class='fas fa-edit'></i> Update
                                </a> 
                                <a href='delete-shoes.php?id=$id' class='btn-tertiary'>
                                    <i class='fas fa-trash-alt'></i> Delete
                                </a> 
                            </td>
                        </tr>";
                        $sn++;
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No Shoes Found</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>

<?php include("partials/footer.php"); ?>
