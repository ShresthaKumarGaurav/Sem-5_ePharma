<?php 
include "include/navbar.php";

if (isset($_POST['change']))
{	include "DBconnect.php";
	$username = $_SESSION['tempusername'];
	$password=$_POST['new_password'];
	$sql = "SELECT * FROM `otp` WHERE `username`='$username'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);

	if ($_POST['otp_received']==$row['otpcode'])
	{
		$time = time();
		$otptime = (int) $row['timestamp'];
			if ($time<($otptime+300))
			{
				$sql = "UPDATE `user` SET `password`='$password' WHERE `username` = '$username'";
				if (mysqli_query($conn,$sql))
				{	$sql = "DELETE FROM `otp` WHERE `username` = '$username'";
					mysqli_query($conn,$sql);
					session_destroy();
					echo "<script>alert('Password changed successfully.');window.location='login.php';</script>";
				}
				else
					{ echo "<script>alert('Password couldn't be changed.');</script>";
					}
			}
			else
				{ $sql = "DELETE FROM `otp` WHERE `username` = '$username'";
					mysqli_query($conn,$sql);
					echo "<script>alert('Sorry, your OTP code has expired time limit,\\n Request a new OTP again!');</script>";
				}
	}
	else
	{	
		echo "<script>alert('OTP incorrect');</script>";
	}
}
 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>Change Account Password</title>
	<link rel="stylesheet" type="text/css" href="css/argon.css">
</head>
<body>
	<form method="POST" name="resetpass" class="d-flex justify-content-center" onsubmit="return verify_password()">
		<div class="p-3 rounded text-center" style="width: 30%;" >
			<div class="form-group">
				<label for="otp_received">Enter the OTP code received in your mail</label>
				<input type="number" name="otp_received" class="form-control" placeholder="Please refer your email inbox" size="6" required>
			</div>
			<div class="form-group">
				<label for="new_password">Type new password</label>
			<input type="password" name="new_password" class="form-control" minlength="8" required>
			</div>
			<div class="form-group">
				<label for="renew_password">Type new password again</label>
			<input type="password" name="renew_password" class="form-control" minlength="8" required>
			</div>
			<input type="submit" class="btn btn-success btn-block" name="change" value="Change Password"><br><br>
			<p class="d-flex justify-content-center">Didn't get code ? <a href="mailing.php">Resend code</a></p>
		</div>
	</form>
	<?php include 'include/footer.php' ?>
</body>
<script>
	function verify_password()
	{
		var x = document.forms["resetpass"]["new_password"].value;
		var y = document.forms["resetpass"]["renew_password"].value;
		if (x != y)
		{
			alert("Passwords don't match, please verify");
			return false;
		}
		else
		{	return true;	
		}
	}
</script>
</html>