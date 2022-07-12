<?php include "include/navigation.php";
include "DBConnect.php";

// For extracting admin id from username
$a = $_SESSION['username'];             
$b = "SELECT * FROM `user` WHERE `username`='$a'";
$c = mysqli_query($conn,$b);
$d = mysqli_fetch_assoc($c);
$admin_id = $d['admin_id'];
$usertype =  $d['usertype'];

// Limiting Access to Owned Products Only
if ($usertype=="SuperAdmin")
{    $sql = "SELECT *,P.id AS pid,P.name AS pname FROM product P LEFT JOIN category C ON P.category=C.name ORDER BY `pname`";
}
else
{
    $sql = "SELECT *,P.id AS pid,P.name AS pname FROM product P LEFT JOIN category C ON P.category=C.name WHERE `pharmacy_id`='$admin_id' ORDER BY `pname`";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<div class="container"style="width: 60%;margin-left:20%;margin-right: 20%;">
    <h1>Product List</h1>
    <a href="product_add.php"><img src="images/bootstrap.jpg" height="30px">+</a>
    <table class="text-center table-bordered table-primary table-hover table-sm mb-2 ">
        <tr>
            <th>S.N.</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
        <?php if ($usertype=="SuperAdmin") {?>
            <th>Seller</th>
        <?php } ?>
            <th>Action</th>
        </tr>
        <?php
        if ($result) {
            $i=0;
            while($row = mysqli_fetch_assoc($result)){
        ?>
                <tr>
                    <td><?= ++$i;?></td>
                    <td>EP<?= $row["pid"];?></td>
                    <td><?= $row["pname"];?></td>
                    <td><?= $row["category"];?></td>
                    <td><?= $row["description"]; ?></td>
                    <td><?= $row["price"]; ?></td>
                    <td><?= $row["stock"];?></td>
                <?php if ($usertype=="SuperAdmin") { ?>
                    <td>
                        <?php 
                            // For pharmacy name display
                            $a2 = $row["pharmacy_id"];
                            $b2 = "SELECT * FROM `pharmacy` WHERE `id`='$a2'";
                            $c2 = mysqli_query($conn,$b2);
                            $d2 = mysqli_fetch_assoc($c2);
                            echo $d2['name'];
                        ?>
                    </td>
                <?php } ?>
                    <td><a href="product_update.php?id=<?= $row['pid'];?>">Edit</a>&nbsp; | <a onclick="return confirm('Are you sure you want to delete this entry?')" href="product_delete.php?id=<?= $row['pid'];?>">Delete</a></td>
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