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
{    $sql = "SELECT * FROM `orders` ORDER BY `order_no` ASC";
}
elseif ($usertype=="Admin")
{   $sql = "SELECT `name` FROM `pharmacy` WHERE `id`='$admin_id'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    $seller = $row['name'];
    $sql = "SELECT * FROM `orders` WHERE `seller`='$seller' ORDER BY `order_no` ASC";
}
elseif ($usertype=="Buyer")
{
    $sql = "SELECT * FROM `orders` WHERE `buyer`='$buyerid' ORDER BY `order_no` ASC";
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
    <h1>View Orders</h1>
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
            <th>Prescription</th>
            <th>Quantity</tdh>
            <th>Total Amount</th>
            <th>Placed Date</th>
            <th>Delivery Receiver</th>
            <th>Delivery address</th>
            <th>Contact</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result) {
            while($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                    <td><?= $row["order_no"];?></td>
                    <td><?= $row["pid"];?></td>
                    <td><?= $row["product_name"];?></td>
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
                    <td>
                        <?php
                            if (isset($row['image_path']))
                            {   $location = "../".$row['image_path'];
                                echo "<a href=".$location."><img src='".$location."' style='width:100px;' alt='image'></a>";
                            }
                            else
                            {
                                echo "<button class='form-control btn' disabled>None</button>";
                            }    
                        ?>
                    </td>
                    <td><?= $row['quantity']; ?></td>
                    <td>Rs.<?= $row["total_price"];?></td>
                    <td><?= $row["timestamp"];?></td>
                    <td><?= $row['delivery_receiver']; ?></td>
                    <td><?= $row['delivery_address']; ?></td>
                    <td><?= $row["contact"];?></td>
                    <td>
                        <?php if($row['completed']=="0") {?>
                            <?php  if($usertype!="Buyer"){ ?>
                                <a onclick="return confirm('Is order delivered to client?')" href="order_completed.php?id=<?= $row['order_no'];?>" class="text-success font-weight-bold" style="text-decoration: underline ;">Mark as completed</a>
                            <?php }  ?>
                            <a onclick="return confirm('Are you sure you want to delete this enitre order?')" href="order_cancel.php?id=<?= $row['order_no'];?>" class="text-danger" style="text-decoration: underline ;">Cancel Order</a>
                        <?php } elseif($row['completed']==1) {?>
                            <font class="text-black font-weight-bold">Completed</font>
                        <?php } else {?>
                            <font class="text-danger font-weight-bold">Cancelled</font>
                        <?php } ?>
                    </td>
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