<?php include 'include/navbar.php' ?>

<?php
if(isset($_COOKIE["member_login"]))
{	
	$_SESSION['username'] = $_COOKIE["member_login"];
	echo "<script>window.location='Cart.php';</script>";
	exit;
}
if(isset($_SESSION['username']))
{
	echo "<script>window.location='Cart.php';</script>"; 
	exit;
}

if(isset($_POST['login']))
{
	$u = $_POST['username'];
	$p = $_POST['password'];
	$p = md5($p);
	$sql = "SELECT * FROM `user` WHERE `username`='$u' AND `password`='$p';";
//echo $sql;
	require_once('backend/DBConnect.php');
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) 
	{
		$_SESSION['username'] = $u;
		$row = mysqli_fetch_assoc($result);
		//echo "<pre>"; print_r($row);exit;
		$_SESSION['u_id'] = $row['id'];
		if(!empty($_POST["remember_me"]))
		{
			setcookie ("member_login",$_POST["username"],time()+(60 * 60)); /* expire in 1 hour */
		}
		else
		{
			if(isset($_COOKIE["member_login"]))
			{
				setcookie ("member_login","");
			}
		}
		require_once("DBConnect.php");
		$a = $_SESSION['username'];
		$b = "SELECT * FROM `user` WHERE `username`='$a'";
		$c = mysqli_query($conn,$b);
		$d = mysqli_fetch_assoc($c);
		if ($d['verification']==1)
		{
			if ($d['usertype']=="SuperAdmin")
				{ 
					echo "<script>window.location='backend/dashboard.php';</script>";
				}
			else if ($d['usertype']=="Admin")
				{	$admin_id = $d['admin_id'];
					$a = "SELECT * FROM `pharmacy` WHERE `id`='$admin_id'";
					$b = mysqli_query($conn,$a);
					$c = mysqli_fetch_assoc($b);
					if ($c['verification']==1)
					{
						echo "<script>window.location='backend/dashboard.php';</script>";
					}
					else
					{
						echo "<p align='center'>The user has not been verified yet.";
						session_destroy();					
					}
					
				}
			else
				{ echo "<script>window.location='Cart.php';</script>"; }
		}
		else
		{ echo "<p align='center'>The user has not been verified yet,<br>please verify first<br><br>Click <a href='email_verification.php'>here</a> to verify your email</p>";
			session_destroy();
		}
				
		exit; 
}
else{
	echo "<script>alert('Username or Password Incorrect!');</script>";
	echo "<script>window.location='login.php';</script>";
	exit;
}
}
?>
 


<!DOCTYPE html>
<html>
	<head>
		<title>Log In</title>
	</head>
	<body>
		<div class="container" style="width: 60%;padding-left: 2rem;padding-right:2rem;">
			<form method="POST" class="jumbotron mt-5">
				<h4 align="left">Log In</h4><br>
				<div class="form-group">
					<label for="username">Your Username :</label>
					<input type="text" class="form-control" name="username" required>
				</div>
				<div class="form-group">
					<label for="password">Your Password:</label>
					<input type="password" class="form-control" name="password" required>
				</div><br>
				<input type="submit" class="btn btn-outline-secondary" value="Log In" name="login" style="float:right;width: 25%;">
				<p>Forgot Password ? Reset your password <a href="reset_password.php" style="text-decoration: underline;">here</a>..</p>
			</form>
			<p>Not registered yet ? <a href="#" data-toggle="modal" data-target="#modal">Register with us</a> .</p>
		</div>
		<?php include 'include/footer.php' ?>
		<div class="modal fade" id="modal">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						Which type of account do you want to create ?
					</div><hr width="100%">
					<div class="modal-body text-center">
						<a href="buyer_register.php" class="btn btn-outline-dark">Buyer Account</a>
						<a href="seller_register.php" class="btn btn-outline-dark">Seller Account</a>
					</div><hr width="100%">
					<div class="modal-footer">
					 <p class="text-right">Note: <i><u>Seller Accounts</u></i> will be verified by our team for authorization.</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>