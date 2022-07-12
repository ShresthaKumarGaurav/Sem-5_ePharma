<?php 
include 'include/navbar.php';
include 'DBConnect.php';
	if (isset($_POST['reload']))
	{
		$_SESSION['tempemail'] = $_POST['email'];
		$email = $_SESSION['tempemail'];
		$result = mysqli_query($conn,"SELECT `username`,`firstname` FROM `user` WHERE `email` = '$email'");
		$row = mysqli_fetch_assoc($result);
		$_SESSION['tempusername'] = $row['username'];
		$_SESSION['name'] = $row['firstname'];
		$_SESSION['pager']="resetpassword";
		header("Location: mailing.php");
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Reset Password</title>
	<link rel="stylesheet" type="text/css" href="css/argon.css">
</head>
<body>
	<div class="d-flex justify-content-center">
		<div style="margin-top: 5%;width: 20%;">
			<form method="POST" name="resetpassword" class="text-center">
				Your Email address:<br><br>
				<input type="email" name="email" class="form-control"><br>
				<input type="submit" class="btn btn-primary btn-block" name="reload" value="Reset password now"><br>
			</form>
		</div>
	</div>
</body>
</html>
	