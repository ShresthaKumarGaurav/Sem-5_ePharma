<?php
include 'DBConnect.php';
 $sql="INSERT into sales(product_id,p_name,quantity,sold_by,ordered_by) values ('$pid','$name','$quantity','$nam','$u')  ";
$result=mysqli_query($conn,$sql);


?>