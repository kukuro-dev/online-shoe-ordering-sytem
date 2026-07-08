<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1><i class="fas fa-list"></i> MANAGE CATEGORIES</h1>

        <br /><br />

        <a href="add-category.php" class="btn-primary"><i class="fas fa-plus-circle"></i> Add Category</a>

        <br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

            $sql = "SELECT * FROM tbl_category";
            $res = mysqli_query($conn, $sql);

            if ($res && mysqli_num_rows($res) > 0) {
                $sn = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                    echo "<tr>
                        <td>$sn</td>
                        <td>$title</td>
                        <td>";
                            if($image_name != "") {
                                echo "<img src='../images/$image_name' alt='$title' style='width:100px; height:auto;'>";
                            } else {
                                echo "<div class='text-center'><i class='fas fa-image'></i> No Image</div>";
                            }
                    echo "</td>
                        <td>$featured</td>
                        <td>$active</td>
                        <td>
                            <a href='update-category.php?id=$id' class='btn-secondary'><i class='fas fa-edit'></i> Update</a> 
                            <a href='delete-category.php?id=$id' class='btn-tertiary'><i class='fas fa-trash-alt'></i> Delete</a>
                        </td>
                    </tr>";
                    $sn++;
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No Categories Found</td></tr>";
            }
            ?>

        </table>

        <br />
        <a href="index.php" class="btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<?php include("partials/footer.php"); ?>
