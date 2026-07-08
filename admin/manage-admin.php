<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE ADMIN</h1>

        <br /><br />

        <a href="add-admin.php" class="btn-primary"><i class="fas fa-plus"></i> Add Admin</a>

        <br /><br />

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

            $sql = "SELECT * FROM tbl_admin";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                $sn = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    $full_name = $row['full_name'];
                    $username = $row['username'];

                    echo "<tr>
                        <td>{$sn}</td>
                        <td>{$full_name}</td>
                        <td>{$username}</td>
                        <td>
                            <a href='update-admin.php?id={$row['id']}' class='btn-secondary'>
                                <i class='fas fa-edit'></i> Update
                            </a> 
                            <a href='delete-admin.php?id={$row['id']}' class='btn-tertiary'>
                                <i class='fas fa-trash-alt'></i> Delete
                            </a> 
                        </td>
                    </tr>";
                    $sn++;
                }
            } else {
                echo "<tr>
                    <td colspan='4'>No Admins Added Yet.</td>
                </tr>";
            }

            mysqli_close($conn);
            ?>
        </table>
    </div> 
</div>

<?php include('partials/footer.php'); ?>
