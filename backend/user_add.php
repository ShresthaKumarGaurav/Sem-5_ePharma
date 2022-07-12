<?php 
if(empty($_SESSION))
  {   
    session_start();
    if(isset($_COOKIE["member_login"]))
    { 
      $_SESSION['username'] = $_COOKIE["member_login"];
      echo "<script>window.location='Cart.php';</script>";
      exit;
    }
  }

if (isset($_POST['add_user']))
{	include 'DBConnect.php';
	$un = $_POST['username'];
	$fn = $_POST['firstname'];
	$mn = $_POST['middlename'];
	$ln = $_POST['lastname'];
	$dob = $_POST['dob'];
	$gender = $_POST['gender'];
	$e = $_POST['email'];
	$district = $_POST['district'];
	$area = $_POST['area'];
	$c = $_POST['contact'];
	$ut = $_POST['usertype'];
	$p = $_POST['pass'];
	$re_p = $_POST['repass'];
	$admin_id=0;
		$sql = 
		$result = mysqli_query($conn,$sql);
	if (mysqli_num_rows($result)!=0)
	{	echo "<script>alert('Username not available');</script>";
		exit(0);
	}

	if ($ut=="Admin")
	{
		$pharmacy_name=$_POST['pharmacy_name'];
		$registration_number=$_POST['registration_number'];
		$pharmacy_address=$_POST['pharmacy_address'];
		$pharmacy_contact=$_POST['pharmacy_contact'];
			$sql = "SELECT `id` FROM `pharmacy` WHERE `registration_number`='$registration_number'";
			$result = mysqli_query($conn,$sql);
			if (mysqli_num_rows($result)!=0)
			{	echo "<script>alert('Pharmacy already regstered);</script>";
				exit(0);
			}
			$sql = "INSERT INTO `pharmacy` (`name`,`registration_number`,`address`,`contact`,`owner`,`verification`) VALUES ('$pharmacy_name','$registration_number','$pharmacy_address','$pharmacy_contact','$un','1')";
			if (mysqli_query($conn,$sql))
				{
					$sql = "SELECT `id` FROM `pharmacy` WHERE `registration_number`='$registration_number'";
					$result = mysqli_query($conn,$sql);
					$row = mysqli_fetch_assoc($result);
					$admin_id = $row['id'];
				}
			else
				{ echo "<p style='margin-left:2%;'>Couldn't add user..You may retry again later</p>";exit();}

	}

	// echo 'U: '.$u.', E: '.$e.', P: '.$p;exit;
			$sql = "INSERT INTO `user` (`username`,`firstname`,`middlename`,`lastname`,`dob`,`gender`,`email`,`district`,`area`,`contact`,`usertype`,`password`,`admin_id`,`verification`) VALUES ('$un','$fn','$mn','$ln','$dob','$gender','$e','$district','$area','$c','$ut','$p','$admin_id','1')";
		if (mysqli_query($conn, $sql)) {
		    // echo "New record created successfully.";
		    header('Location: user_list.php');
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
}
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body id="body">
	<?php include 'include/navigation.php';?>
	<div class="container" style="width: 60%;margin-left:20%;margin-right: 20%;">
		<h1 class="mt-3">Add User</h1><hr>
		<form method="POST" onsubmit="return verify()" name="abc">
			<table class="table-sm mb-2">
				<tr>
					<td>Username : </td>
					<td><input type="text" name="username" class="form-control form-control-sm" placeholder="alphanumeric only" required autofocus minlength="8" id="for_focus" onkeyup="username_check()" pattern="^[a-zA-Z0-9]+$"></td>
					<td><div class="d-flex flex-wrap align-content-center">
							<font class="spinner-border spinner-border-sm text-primary" id="spin_this" style="display: none;"></font>
							<font id="remark" class="ml-2"></font>
						</div>
					</td>
				</tr>
				<tr>
					<td>Full Name : </td>
					<td><input type="text" name="firstname" placeholder="First Name" class="form-control form-control-sm" required></td>
					<td><input type="text" name="middlename" placeholder="Middle Name" class="form-control form-control-sm"></td>
					<td><input type="text" name="lastname" placeholder="Last Name" class="form-control form-control-sm" required></td>
				</tr>
				<tr>
					<td>Date of birth : </td>
					<td><input type="date" name="dob" id="dob" class="form-control form-control-sm" required></td>
				</tr>
				<tr>
					<td><label for="gender" class="mb-3">Gender : &nbsp;</label></td>
					<td>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" name="gender" id="customRadio" value="male" required>
							<label class="custom-control-label" for="customRadio">Male</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="customRadio2" name="gender" value="female">
							<label class="custom-control-label" for="customRadio2">Female</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="customRadio3" name="gender" value="other">
							<label class="custom-control-label" for="customRadio3">Self</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>Email : </td>
					<td><input type="email" name="email" class="form-control form-control-sm" required minlength="10"></td>
				</tr>
				<tr>
					<td>District : </td>
					<td>
						<select name="district" class="custom-select form-control-md mb-3" required>
							<option disabled selected></option>
							<option>Kathmandu</option>
							<option>Lalitpur</option>
							<option>Bhaktapur</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Area : </td>
					<td>
						<select name="area" class="form-control form-control-sm" required>
							<option disabled selected></option>
							<?php
								$sql = "SELECT `area` FROM `location` ORDER BY `area` ASC";
								$result = mysqli_query($conn,$sql);
								while($name= mysqli_fetch_assoc($result))
								{
							?>
								<option><?= $name['area']; ?></option>
								<?php

								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Contact : </td>
					<td><input type="tel" name="contact" class="form-control form-control-sm" pattern="9[6-9]{1}[0-9]{8}" required></td>
					<td>Format : 9812345678</td>
				</tr>
				<tr>
					<td>User Type : </td>
					<td>
						<select name="usertype" class="custom-select mb-3" required onchange="additional(this.value)">
						<option selected disabled></option>
						<option>SuperAdmin</option>
						<option>Admin</option>
						<option>Buyer</option>
					</select>
					</td>
				</tr>
				<tr id="admin_only1" style="display: none;">
					<td>Pharmacy Name : </td>
					<td><input type="text" name="pharmacy_name" class="form-control form-control-sm mb-2" value="0" required></td>
				</tr>
				<tr id="admin_only2" style="display: none;">
					<td>Registration Number : </td>
					<td><input type="number" name="registration_number" class="form-control form-control-sm" required minlength="8" id="for_focus2" onkeyup="rn_check()" value="0"></td>
					<td><div class="d-flex flex-wrap align-content-center">
							<font class="spinner-border spinner-border-sm text-primary" id="spin_this2" style="display: none;"></font>
							<font id="remark2" class="ml-2"></font>
						</div>
					</td>
				</tr>
				<tr id="admin_only3" style="display: none;">
					<td>Pharmacy Address</td>
					<td><input type="text" name="pharmacy_address" class="form-control form-control-sm" value="null" required></td>
				</tr>
				<tr id="admin_only4" style="display: none;">
					<td>Pharmacy Contact : </td>
					<td><input type="tel" name="pharmacy_contact" class="form-control form-control-sm" pattern="01-[4-5]{2}[0-9]{5}" value="01-5555555" required></td>
					<td>Format : 01-5512345</td>
				</tr>
				<tr>
					<td>Password : </td>
					<td><input type="password" name="pass" class="form-control form-control-sm" required></td>
				</tr>
				<tr>
					<td>Confirm Password : </td>
					<td><input type="password" name="repass" class="form-control form-control-sm" required></td>
				</tr>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td class="text-center"><input type="submit" name="add_user" class="btn btn-success btn-block" value="Add"></td>
				</tr>
			</table>
		</form>
		<?php include 'include/footer.php';?>
	</div>
</body>
<script>
	function verify()
	{
		var x = document.forms["abc"]["pass"].value;
		var y = document.forms["abc"]["repass"].value;
		if (document.getElementById("remark").innerText=="Username not available")
		{
			document.getElementById("for_focus").focus();
			return false;
		}
		else if (document.getElementById("remark2").innerText=="Already registered")
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
	function additional(ut)
	{
		if (ut=="Admin")
		{	document.getElementById("admin_only1").style.display="table-row";
			document.getElementById("admin_only2").style.display="table-row";
			document.getElementById("admin_only3").style.display="table-row";
			document.getElementById("admin_only4").style.display="table-row";
			document.getElementById("admin_only5").style.display="table-row";
		}
		else
		{	document.getElementById("admin_only1").style.display="none";
			document.getElementById("admin_only2").style.display="none";
			document.getElementById("admin_only3").style.display="none";
			document.getElementById("admin_only4").style.display="none";
			document.getElementById("admin_only5").style.display="none";
		}
	}
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
		xmlhttp.open("GET","../username_check.php?username="+x,true);
		xmlhttp.send();
	}
	function rn_check()
	{	
		document.getElementById("spin_this2").style.display="block";
		var x = document.forms["abc"]["registration_number"].value;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
		 { if (this.readyState == 4 && this.status == 200)
		    { document.getElementById("spin_this2").style.display="none";
		      document.getElementById("remark2").innerHTML = this.responseText;   
		  	}
		};
		xmlhttp.open("GET","../rn_check.php?rn="+x,true);
		xmlhttp.send();
	}
</script>
</html>