<?php include 'include/navbar.php' ?>

<?php
if(isset($_COOKIE["member_login"]))
{	
	$_SESSION['username'] = $_COOKIE["member_login"];	
}
if(isset($_SESSION['username']))
{
	echo "<script>window.location='Cart.php';</script>";
	exit;
}
?>

<!DOCTYPE html>
<html><head>
	<title>Register as Customer !!</title>
	<style type="text/css">
		input
		{ text-align: center;}
		}
	</style>
</head>
<body>
	<form method="POST" class="container jumbotron form-group" action="addtodb.php" style="width: 70%;padding: 2rem;" onsubmit="return verify_password()" name="abc">
		<h1 style="font-family: sans-serif;" class="mt-3">Buyer Registration Form</h1>
		<p>This is a one time process.</p>
		<hr>
		<!--For UserName-->
		<div class="input-group">
			<label for="username" class="input-group-prepend mr-sm-3">Your Name :<sup> *</sup></label>
			<input type="text"  class="form-control form-control-sm mb-1" minlength="3" placeholder="First Name*" name="first_name" required>
			<input type="text" class="form-control form-control-sm mb-1" minlength="3" placeholder="Middle Name" name="middle_name">
			<input type="text" class="form-control form-control-sm mb-1" minlength="3" placeholder="Last Name*" name="last_name" required>
		</div><br>
		<div class="input-group">
			<label for="dob">Date of birth : <sup> *</sup></label>&nbsp;&nbsp;
			<input type="date" name="dob" id="dob" class="form-control form-control-sm ml-3" style="max-width: 20%;" required>
		</div><br>
		<select name="address" class="custom-select mb-3 ">
			<option disabled selected>-- District --</option>
			<option>Kathmandu</option>
			<option>Lalitpur</option>
			<option>Bhaktapur</option>
		</select>
		<select name="area" class="custom-select mb-3 ">
			<option disabled selected>-- Neighbourhood --</option>
			<?php
				$query = "SELECT * FROM `location` ORDER BY `area` ASC";
				$result = mysqli_query($conn,$query);
				while ($row = mysqli_fetch_array($result))
				{
					echo "<option>".$row['area']."</option>";
				}
			?>
		</select>
		<!--For Contact-->
		<label for="contact" class="mr-sm-3">Contact Information :<sup> *</sup></label>
		<input type="number" name="contact" class="form-control form-control-sm mb-3" min="9800000000" max="9888888888" required>
		<!--For Email-->
		<label for="email" class="mr-sm-3">Email :<sup> *</sup></label>
		<div class="input-group input-group-sm mb-1"> 
			<input type="email" name="email" class="form-control" minlength="10" required>
			<div class="input-group-append"><span class="input-group-text mb-3">Example: admin@yahoo.com</span></div>
		</div>
		<!--For Gender-->
		<label for="gender" class="mb-3">Gender : &nbsp;</label>
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" class="custom-control-input" name="gender" id="customRadio" value="male">
			<label class="custom-control-label" for="customRadio">Male</label>
		</div>
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" class="custom-control-input" id="customRadio2" name="gender" value="female">
			<label class="custom-control-label" for="customRadio2">Female</label>
		</div>
		<div class="custom-control custom-radio custom-control-inline">
			<input type="radio" class="custom-control-input" id="customRadio3" name="gender" value="other">
			<label class="custom-control-label" for="customRadio3">Other</label>
		</div><br>
	    <label for="username" class="mr-sm-3">Username :<sup> *</sup><font class="spinner-border spinner-border-sm text-primary" id="spin_this" style="display: none;float: right;"></font><font id="remark" class="ml-2"></font></label>
	    <input type="text" name="username" class="form-control form-control-sm text-center" minlength="8" required placeholder="Remember this for future use" id="for_focus" onkeyup="username_check()" pattern="^[a-zA-Z0-9]+$">
			
		<label for="password" class="mr-sm-3 mt-2">Enter password :<sup> *</sup></label>
		<input type="password" name="pass" class="form-control form-control-sm mb-1" minlength="8" required>
		<label for="re-password" class="mr-sm-3">Re-enter password :<sup> *</sup></label>
		<input type="password" name="repass" class="form-control form-control-sm mb-1" minlength="8" required>
		
		<br><input  type="submit" name="add_buyer" class="btn btn-outline-success" value="Register Now" style="float: right;">
		<p>Already have an account? <a href="login.php">Log In</a> .</p>
	</form>
	<?php include 'include/footer.php' ?>
</body>
<script>
	function username_check()
	{	
		document.getElementById("spin_this").style.display="block";
		var x = document.forms["abc"]["username"].value;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
		 { if (this.readyState == 4 && this.status == 200)
		    { document.getElementById("spin_this").style.display="none";
		      document.getElementById("remark").innerHTML = this.responseText;   
		  	}
		};
		xmlhttp.open("GET","username_check.php?username="+x,true);
		xmlhttp.send();
	}
	function verify_password() {
		var x = document.forms["abc"]["pass"].value;
		var y = document.forms["abc"]["repass"].value;
		if (document.getElementById("remark").innerText=="Username not available")
		{
			document.getElementById("for_focus").focus();
			return false;
		}
		else if (x != y)
		{
			alert("Passwords don't match, please verify");
			return false;
		}
	}
</script>
</html>