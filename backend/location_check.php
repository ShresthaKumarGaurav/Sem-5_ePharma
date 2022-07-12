<?php 

$keyword = $_GET['area'];

include 'DBConnect.php';

$sql = "SELECT `area` FROM `location` WHERE `area`='$keyword'";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result)!=0)
	echo "<font class='text-danger font-weight-light'>Area already in database</font>";
else if ($keyword!="")
	echo "";

 ?>