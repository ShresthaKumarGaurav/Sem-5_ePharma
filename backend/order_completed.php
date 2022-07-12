<?php
$id = $_GET['id'];

require_once('DBConnect.php');
$sql = "UPDATE `orders` SET `completed`=1,`paid`=1 WHERE `order_no`='$id';";

if (mysqli_query($conn, $sql))
{	
	$result= mysqli_query($conn,"SELECT * FROM `orders` WHERE `order_no`='$id'");
	while ($row = mysqli_fetch_assoc($result))
	{
		$pid = $row['pid'];
		$pname = $row['product_name'];
		$quantity =  $row['quantity'];
		$seller = $row['seller'];
		$buyer = $row['buyer'];
		$total = $row['total_price'];
		mysqli_query($conn,"INSERT INTO `sales` (`pid`,`pname`,`quantity`,`seller`,`buyer`,`total`) VALUES ('$pid','$pname','$quantity','$seller','$buyer','$total')");
	}

    header('Location: order_list.php');
}
else{
    echo "Error deleting record: " . mysqli_error($conn);
}