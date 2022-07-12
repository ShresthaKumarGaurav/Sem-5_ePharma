<?php
if (!isset($_SESSION))
{
	session_start();
}
include 'DBConnect.php';

    $result = mysqli_query($conn, "SELECT MAX(`order_no`) AS 'order_no' FROM `orders`");
    $row = mysqli_fetch_assoc($result);
    $order_no = $row['order_no'] + 1;
    $delivery_receiver = $_SESSION['delivery']['name'];
    $delivery_address = $_SESSION['delivery']['address'];
    $phone_number = $_SESSION['delivery']['phone'];
    $payment_type = $_SESSION['delivery']['payment_type'];
    $paid = $_SESSION['delivery']['paid'];
    if (isset($_SESSION['delivery']['prescription']))
    {
        $image_path = "images/prescription/".$order_no.".jpg";
        if (copy("images/prescription/tmp/".$_SESSION['username'].".jpg",$image_path))
        {
            unlink("images/prescription/tmp/".$_SESSION['username'].".jpg");
        }
    }
    $tid = $_SESSION['delivery']['tid'];
    
foreach ($_SESSION['cart'] as $key => $value)
{   $pid = $value["id"];
	$buyer = $_SESSION["username"];
    $pname = $value['name'];
    $price = $value['price'];
    $quantity = $value['quantity'];
    $total =  $price * $quantity;

    $sql = "SELECT pharmacy_id FROM product WHERE `id`='$pid'";
    
    $s=mysqli_query($conn,$sql);
    if ($s) 
    {
        $row = mysqli_fetch_assoc($s);
        $p_id=$row['pharmacy_id'];
        echo "$p_id";
         $v="SELECT name FROM pharmacy WHERE `id`='$p_id'";
         $n=mysqli_query($conn,$v);
         if ($n) 
         {   
            $r=mysqli_fetch_assoc($n);
            $nam=$r['name'];
            echo $nam;
         }
    
    }
    if (isset($_SESSION['delivery']['prescription']))
    {
        $sql = "INSERT INTO `orders` (`pid`,`buyer`,`product_name`,`seller`,`price`,`quantity`,`total_price`,`order_no`,`payment_type`,`paid`,`delivery_receiver`,`delivery_address`,`contact`,`transaction_id`,`image_path`) VALUES ('$pid','$buyer','$pname','$nam','$price','$quantity','$total','$order_no','$payment_type','$paid','$delivery_receiver','$delivery_address','$phone_number','$tid','$image_path')";
    }
    else
    {
        $sql = "INSERT INTO `orders` (`pid`,`buyer`,`product_name`,`seller`,`price`,`quantity`,`total_price`,`order_no`,`payment_type`,`paid`,`delivery_receiver`,`delivery_address`,`contact`,`transaction_id`) VALUES ('$pid','$buyer','$pname','$nam','$price','$quantity','$total','$order_no','$payment_type','$paid','$delivery_receiver','$delivery_address','$phone_number','$tid')";
    }
	
	if (mysqli_query($conn,$sql))
		{   
      header("Location: order_placed.php");
}	
    else
		echo "Sorry an error occurred. Please contact our team.";
} 
?>