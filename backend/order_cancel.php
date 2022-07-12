<?php
$id = $_GET['id'];

require_once('DBConnect.php');
$sql = "UPDATE `orders` SET `completed`=2 WHERE `order_no`='$id';";

if (mysqli_query($conn, $sql))
{
    $sql = "SELECT * FROM `orders` WHERE `order_no` = '$id'";
    $result = mysqli_query($conn,$sql);
    while ($row = mysqli_fetch_assoc($result))
    {	$pid = $row['pid'];
    	$quantity = $row['quantity'];
    	$a0 = "SELECT `stock` FROM `product` WHERE `id` = '$pid'";
    	$a1 = mysqli_query($conn,$a0);
    	$a2 = mysqli_fetch_assoc($a1);
    	$quantity += $a2['stock'];
    	$b0 = "UPDATE `product` SET `stock` = '$quantity' WHERE `id`='$pid'";
    	$b1 = mysqli_query($conn,$b0);
    }
    header('Location: order_list.php');
} 
else
{
    echo "Error deleting record: " . mysqli_error($conn);
}