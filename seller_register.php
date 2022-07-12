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
	<title>Register as a Pharmacy</title>
	<style type="text/css">
		input
		{ text-align: center; }
	</style>
</head>
<body>
	<form method="POST" class="container jumbotron form-group" action="addtodb.php" style="width: 70%;padding: 2rem;" onsubmit="return verify_password()" name="abc" enctype="multipart/form-data">
		<h1 style="font-family: sans-serif;" class="mt-3">Seller Registration Form</h1>
		<p>Please fill in this form to become an <u class="text-muted">ePharma</u> seller.</p>
		<h3 class="text-center">Owner Details</h3>
		<hr class="mt-0">
		
		<div class="input-group">
			<label for="username" class="input-group-prepend mr-sm-3">Owner Name :<sup> *</sup></label>
			<input type="text"  class="form-control form-control-sm mb-1" minlength="3" placeholder="First Name*" name="first_name" required>
			<input type="text" class="form-control form-control-sm mb-1" minlength="3" placeholder="Middle Name" name="middle_name">
			<input type="text" class="form-control form-control-sm mb-1" minlength="3" placeholder="Last Name*" name="last_name" required>
		</div><br>
		<div class="input-group">
			<label for="dob">Date of birth : <sup> *</sup></label>&nbsp;&nbsp;
			<input type="date" name="dob" id="dob" class="form-control form-control-sm ml-3" style="max-width: 20%;" required>
		</div><br>
		<select name="address" class="custom-select mb-3">
			<option disabled selected>-- District --</option>
			<option>Kathmandu</option>
			<option>Lalitpur</option>
			<option>Bhaktapur</option>
		</select>
		<select name="area" class="custom-select mb-3">
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
			<div class="input-group-append"><span class="input-group-text form-control form-control-sm mb-3">Example: admin@yahoo.com</span></div>
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
		
		<hr>
		<br>Required Documents : <br>
		<ul type="square">
			<li>Shop license photo</li>
			<li>Shop PAN photo</li>
		</ul>
		<h3 class="text-center">Pharmacy Shop Details</h3>
		<hr class="mt-0">
		<!--For ShopName-->
		<label for="shopname">Pharmacy Name : <sup> *</sup></label>
		<input type="text" name="shopname" class="form-control mb-3"required>
		<label for="regnum">PAN NO : <sup> *</sup><font class="spinner-border spinner-border-sm text-primary" id="spin_this2" style="display: none;float: right;"></font><font id="remark2" class="ml-2"></font></label>
		<input type="number" name="pannum" class="form-control mb-3" required id="for_focus2" onkeyup="rn_check()">
		<select name="pharmacy_address" class="custom-select mb-3">
			<option disabled selected>-- District --</option>
			<option>Kathmandu</option>
			<option>Lalitpur</option>
			<option>Bhaktapur</option>
		</select>
		<select name="pharmacy_area" class="custom-select mb-3">
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
		Upload your pharmacy license photo here :: jpg/jpeg only :: Maximum size 5MB <br>
	    	<input type="file" class="custom-file-input" id="licensephoto" name="license" onchange="check_license(this)" required><br>
	    Upload your pharmacy pan photo here :: jpg/jpeg only :: Maximum size 5MB <br>
	    	<input type="file" class="custom-file-input" id="panphoto" name="pan" onchange="check_pan(this)" required>
	
		<br><input  type="submit" name="add_seller" class="btn btn-outline-success" value="Register Now" style="float: right;">
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
	function rn_check()
	{	
		document.getElementById("spin_this2").style.display="block";
		var x = document.forms["abc"]["pannum"].value;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
		 { if (this.readyState == 4 && this.status == 200)
		    { document.getElementById("spin_this2").style.display="none";
		      document.getElementById("remark2").innerHTML = this.responseText;   
		  	}
		};
		xmlhttp.open("GET","rn_check.php?rn="+x,true);
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
		else if (document.getElementById("remark2").innerText=="RN not available")
		{
			document.getElementById("for_focus2").focus();
			return false;
		}
		else if (x != y)
		{
			alert("Passwords don't match, please verify");
			return false;
		}
	}
	function check_license(file)
	{
		var FileSize = file.files[0].size / 1024/1024; // in MB
	    if (FileSize > 5)
	    {
	        alert("File size exceeded");
	        document.getElementById("licensephoto").value = "";
	    }
	    else
	    {
	    	var path = file.files[0].type;
	    	if (path.endsWith('jpg') || path.endsWith('jpeg'))
	    		{ }
	    	else 
	    	{
	    		alert("Image extension not valid");
	        	document.getElementById("licensephoto").value = "";
	    	}
	    }
	}
	function check_pan(file)
	{
		var FileSize = file.files[0].size / 1024/1024; // in MB
	    if (FileSize > 5)
	    {
	        alert("File size exceeded");
	        document.getElementById("panphoto").value = "";
	    }
	    else
	    {
	    	var path = file.files[0].type;
	    	if (path.endsWith('jpg') || path.endsWith('jpeg'))
	    		{ }
	    	else 
	    	{
	    		alert("Image extension not valid");
	        	document.getElementById("panphoto").value = "";
	    	}
	    }
	} 
</script>
</html>