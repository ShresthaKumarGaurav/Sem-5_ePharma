<?php
include "include/navigation.php";
include "DBConnect.php";
$sql = "SELECT * FROM `category` ORDER BY `name` ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<div class="container" style="width: 60%;margin-left:20%;margin-right: 20%;">
    <h1>Category List</h1>
    <a href="category_add.php"><img src="images/bootstrap.jpg" height="30px">+</a>
    <table class="text-center table-bordered table-primary table-hover table-sm mb-2 ">
        <tr>
            <th>S.N.</th>
            <th>Category</th>
            <th>Description</th>
        </tr>
        <?php
        if ($result) {
            $i=0;
            while($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                    <td><?= ++$i;?></td>
                    <td><?= $row["name"];?></td>
                    <td><?= $row["description"];?></td>
                    <?php
                        // For extracting admin id from username
                        $a = $_SESSION['username'];             
                        $b = "SELECT * FROM `user` WHERE `username`='$a'";
                        $c = mysqli_query($conn,$b);
                        $d = mysqli_fetch_assoc($c);
                        $admin_id = $d['admin_id'];
                        if ($d['usertype']=="SuperAdmin")
                        {
                    ?>
                    <td><a href="category_update.php?id=<?= $row['id'];?>">Edit</a>&nbsp; | <a onclick="return confirm('Are you sure you want to delete this entry?')" href="category_delete.php?id=<?= $row['id'];?>">Delete</a></td>
                    <?php } ?>
                </tr>
                <?php
            }   
        } else {
            ?>
            <tr>
                <td colspan="6">No Record(s) found.</td>
            </tr>
            <?php
        }
        ?>
        <?php 
        mysqli_close($conn);
        ?>
    </table>
    <?php include 'include/footer.php';?>
</div>
</body>
</html>