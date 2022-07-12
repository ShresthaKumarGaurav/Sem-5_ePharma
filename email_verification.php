<?php 
include 'include/navbar.php';
if (!isset($_SESSION))
{
	session_start();
}
	if (isset($_POST['otp']))
	{	include "DBConnect.php";
		$name = $_SESSION['tempusername'];
		$sql = "SELECT * FROM `otp` WHERE `username` = '$name'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		$otp_received = $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'].$_POST['otp5'].$_POST['otp6'];
		if ($row['otpcode'] == (int) $otp_received)
		{	$time = time();
			$otptime = (int) $row['timestamp'];
			if ($time<($otptime+300))
			{
				$sql = "UPDATE user SET verification=1 WHERE username ='$name'";
				if (mysqli_query($conn, $sql))
				{	$sql = "DELETE FROM otp WHERE username = '$name'";
					mysqli_query($conn,$sql);
					session_destroy();
					echo "<script>alert('Your acount has been verified, Now u can log in');window.location='login.php';</script>";
				}
				else
					{ echo "<script>alert('Sorry an error occurred !');</script>";exit;}
			}
			else
				{ 	$sql = "DELETE FROM otp WHERE email = '$email'";
					mysqli_query($conn,$sql);
					echo "<script>alert('Sorry, your OTP code has expired time limit,\\n Request a new OTP again!');window.location='email_verification.php';</script>";
					exit;
				}
			
		}
		else
		{	
			echo "<script>alert('OTP incorrect');</script>;";
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Email verification</title>
	<link rel="stylesheet" type="text/css" href="css/argon.css">
	<style type="text/css">
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button
		{ -webkit-appearance:none; 
			margin: 0;
		}
		.otpbox
		{
			width: 14%;
			background-color: #19191924;
		}
	</style>
</head>
<body>
	<div class="d-flex justify-content-center">
		<div style="margin-top: 5%;width: 20%;">
			<form method="POST" name="otpform">
				<p class="mb-3">Enter the OTP code received in your mail</p>
				<div class="d-flex justify-content-between mb-3" >
					<input type="text" name="otp1" class="form-control text-center otpbox" maxlength="1"  required>
					<input type="text" name="otp2" class="form-control text-center otpbox" maxlength="1" required>
					<input type="text" name="otp3" class="form-control text-center otpbox" maxlength="1" required>
					<input type="text" name="otp4" class="form-control text-center otpbox" maxlength="1" required>
					<input type="text" name="otp5" class="form-control text-center otpbox" maxlength="1" required>
					<input type="text" name="otp6" class="form-control text-center otpbox" maxlength="1" required>
				</div>
				<input type="submit" class="btn btn-primary btn-block" name="otp" value="Verify.."><br>
			</form>
			Didn't get code ? <a href="mailing.php">Resend code</a><br><br>

			<p><span class="text-muted font-weight-bold">Note:</span> OTPs are valid for only <span class="text-danger">5 minutes</span> after they are sent to your email</p>
		</div>
	</div>
</body>
</html>
	