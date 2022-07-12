<?php
include 'include/navigation.php';
include "DBConnect.php";

// For extracting admin id from username
$a = $_SESSION['username'];             
$b = "SELECT * FROM `user` WHERE `username`='$a'";
$c = mysqli_query($conn,$b);
$d = mysqli_fetch_assoc($c);
$buyerid = $d['username'];
$admin_id = $d['admin_id'];
$usertype =  $d['usertype'];

// Limiting Access to Owned Products Only
if ($usertype=="SuperAdmin")
{    $sql = "SELECT * FROM `sales` ORDER BY `pname` ASC";
}
elseif ($usertype=="Admin")
{   $sql = "SELECT `name` FROM `pharmacy` WHERE `id`='$admin_id'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $seller = $row['name'];
    $sql = "SELECT * FROM `sales` WHERE `seller`='$seller' ORDER BY `pname` ASC";
}
elseif ($usertype=="Buyer")
{
    $sql = "SELECT * FROM `sales` WHERE `buyer`='$buyerid' ORDER BY `pname` ASC";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<div class="container" style="width: 60%;margin-left:16%;margin-right: 20%;">
    <h1>View Sales</h1>
    <table class="text-center table-bordered table-primary table-hover table-sm mb-2 ">
        <tr>
            <th>Order ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <?php if($usertype!="Buyer") {?>
                <th>Order By</th>
            <?php } ?>
            <?php if($usertype!="Admin") {?>
                <th>Sold By</th>
            <?php } ?>
            <th>Quantity</tdh>
            <th>Total Amount</th>
            <th>Placed Date</th>
        </tr>
        <?php
        if ($result) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                    <td><?= $row["id"];?></td>
                    <td><?= $row["pid"];?></td>
                    <td><?= $row["pname"];?></td>
                <?php if($usertype!="Buyer")
                        {
                            echo "<td>".$row['buyer']."</td>";
                        }
                ?>
                 <?php if($usertype!="Admin")
                        {
                            echo "<td>".$row['seller']."</td>";
                        }
                ?>
                    <td><?= $row['quantity']; ?></td>
                    <td>Rs.<?= $row["total"];?></td>
                    <td><?= $row["timestamp"];?></td>
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
    </table>
    <?php include 'include/footer.php';?>
</div>
</body>
</html>