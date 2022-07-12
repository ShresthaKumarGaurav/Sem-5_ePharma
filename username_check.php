<?php 

$keyword = $_GET['username'];

include 'DBConnect.php';

$sql = "SELECT `username` FROM `user` WHERE `username`='$keyword'";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result)!=0)
	echo "<font class='text-danger font-weight-light'>Username not available</font>";
else if ($keyword!="")
	echo "<font class='text-success font-weight-light'>Username available</font>";

 ?>