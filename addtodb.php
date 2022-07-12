<?php
if (!isset($_SESSION))
{
	session_start();
}
include 'DBConnect.php';

	$_SESSION['tempemail']=$_POST['email'];
	$_SESSION['tempusername']=$_POST['username'];
	$_SESSION['name']=$_POST['first_name'];

if (isset($_POST['add_buyer']))  //For buyer
{	$username = $_POST['username'];
	$first_name = $_POST['first_name'];
	$middle_name = $_POST['middle_name'];
	$last_name = $_POST['last_name'];
	$address = $_POST['address'];
	$dob = $_POST['dob'];
	$contact = $_POST['contact'];
	$area = $_POST['area'];
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$pass = $_POST['pass'];
	$p = md5($pass);
	$repass = $_POST['repass'];
	$fullname = $first_name." ".$middle_name." ".$last_name;

		$sql = "INSERT INTO `user` (`username`,`firstname`,`middlename`,`lastname`,`district`,`dob`,`password`,`contact`,`email`,`gender`,`area`,`usertype`,`verification`) VALUES ('$username','$first_name','$middle_name','$last_name','$address','$dob','$p','$contact','$email','$gender','$area','Buyer','0')";
		if (mysqli_query($conn, $sql))
			{ $_SESSION['pager']="verify";
				header("Location: mailing.php");
			}
		else
			{ echo "<script>alert('A technical problem occured, please retry later.\\nWe apologize for the inconvinience caused');</script>"; exit; 
			}

}
else if (isset($_POST['add_seller']))  //For seller
{	$username = $_POST['username'];
	$first_name = $_POST['first_name'];
	$middle_name = $_POST['middle_name'];
	$last_name = $_POST['last_name'];
	$address = $_POST['address'];
	$dob = $_POST['dob'];
	$contact = $_POST['contact'];
	$area = $_POST['area'];
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	$pass = $_POST['pass'];
	$p = md5($pass);
	$repass = $_POST['repass'];
	$fullname = $first_name." ".$middle_name." ".$last_name;
	
	$shopname = $_POST['shopname'];
	$pannum = $_POST['pannum'];
	$pharmacy_address = $_POST['pharmacy_address'];
	$pharmacy_area = $_POST['pharmacy_area'];
	$license_path = "images/document/".$_POST['username'].'_license.jpg';
	$pan_path = "images/document/".$_POST['username'].'_pan.jpg';
	move_uploaded_file($_FILES['license']['tmp_name'], $license_path);
	move_uploaded_file($_FILES['pan']['tmp_name'], $pan_path);

	print_r($_POST);echo "<br>";
	print_r($_FILES);

	$sql = "INSERT INTO `pharmacy` (`name`,`registration_number`,`district`,`address`,`contact`,`owner`,`license`,`pan`,`verification`) VALUES ('$shopname','$pannum','$pharmacy_address','$pharmacy_area','$contact','$username','$license_path','$pan_path','0')";
	if (mysqli_query($conn, $sql)) 
		{	$sql = "SELECT * FROM pharmacy WHERE `registration_number`='$pannum'";
	$result = mysqli_query($conn, $sql);
	if ($result)
	{
		$row = mysqli_fetch_assoc($result);
		$admin_id = $row['id'];
		$sql = "INSERT INTO `user` (`username`,`firstname`,`middlename`,`lastname`,`district`,`dob`,`password`,`contact`,`email`,`gender`,`area`,`usertype`,`admin_id`,`verification`) VALUES ('$username','$first_name','$middle_name','$last_name','$address','$dob','$p','$contact','$email','$gender','$area','Admin','$admin_id','0')";
		if (mysqli_query($conn, $sql))
			{ $_SESSION['pager']="verify";
				header("Location: mailing.php");
			}
		else
			{ echo "<script>alert('A technical problem occured, please retry later.\\nWe apologize for the inconvinience caused');</script>"; exit; }

	}
	else
		{ echo "<script>alert('A technical problem occured, please retry later.\\nWe apologize for the inconvinience caused');</script>"; exit;}

	}
	else
		{ echo "<script>alert('A technical problem occured, please retry later.\\nWe apologize for the inconvinience caused');</script>";exit;
	}
}

?>