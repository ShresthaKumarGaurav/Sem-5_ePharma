<?php 

$keyword = $_GET['rn'];

include 'DBConnect.php';

$sql = "SELECT `registration_number` FROM `pharmacy` WHERE `registration_number`='$keyword'";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result)!=0)
	echo "<font class='text-danger font-weight-light'>RN not available</font>";
else if ($keyword!="")
	echo "<font class='text-success font-weight-light'>RN available</font>";

 ?>