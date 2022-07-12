<?php
$user_id = $_GET['id'];
if (!isset($user_id)) {
	header('Location: user_list.php');
}
include 'DBConnect.php';
$sql = "SELECT * FROM `user` WHERE `id`='$user_id'";
$result = mysqli_query($conn, $sql);
$prev_data = mysqli_fetch_assoc($result);
if (isset($_POST['updater'])) {
	$user_id = $_GET['id'];
	// echo "$user_id";exit();
	$fn = $_POST['firstname'];
	$mn = $_POST['middlename'];
	$ln = $_POST['lastname'];
	echo "<script>alert(".$fn.")</script>";
	$dob = $_POST['dob'];
	$gender = $_POST['gender'];
	$e = $_POST['email'];
	$district = $_POST['district'];
	$area = $_POST['area'];
	$c = $_POST['contact'];
	$p = $_POST['pass'];
	$re_p = $_POST['repass'];
	$p=md5($p);
			$sql = "UPDATE `user` SET `firstname`='$fn',`middlename`='$mn',`lastname`='$ln',`dob`='$dob',`gender`='$gender', `email`='$e', `area`='$area', `contact`='$c', `password`='$p' WHERE `id`='$user_id';";
			// echo $sql;exit;
		if (mysqli_query($conn, $sql)) {
		    // echo "Record updated successfully";
		    header('Location: user_list.php');
		} else {
		    echo "Error updating record: " . mysqli_error($conn);
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php include 'include/navigation.php';?>
<div class="container" style="width: 60%;margin-left:20%;margin-right: 20%;">
<h1>Update User #<?= $prev_data['id'];?></h1>
<form method="POST" name="abc" onsubmit="return verify()">
	<table class="table-sm mb-2">
		<tr>
			<td>Username : </td>
			<td><input type="text" name="username" class="form-control form-control-sm" value="<?= $prev_data['username']; ?>" disabled></td>
			<td><div class="d-flex flex-wrap align-content-center">
				<font class="spinner-border spinner-border-sm text-primary" id="spin_this" style="display: none;"></font>
				<font id="remark" class="ml-2"></font>
			</div>
		</td>
	</tr>
	<tr>
		<td>Full Name : </td>
		<td><input type="text" name="firstname" value="<?= $prev_data['firstname']; ?>" class="form-control form-control-sm" required></td>
		<td><input type="text" name="middlename" value="<?= $prev_data['middlename']; ?>" class="form-control form-control-sm"></td>
		<td><input type="text" name="lastname" value="<?= $prev_data['lastname']; ?>" class="form-control form-control-sm" required></td>
	</tr>
	<tr>
		<td>Date of birth : </td>
		<td><input type="date" name="dob" value="<?= $prev_data['dob']; ?>" class="form-control form-control-sm" required></td>
	</tr>
	<tr>
		<td><label for="gender" class="mb-3">Gender : &nbsp;</label></td>
		<td>
			<div class="custom-control custom-radio custom-control-inline">
				<input type="radio" class="custom-control-input" name="gender" id="customRadio" value="male" required <?php if($prev_data['gender']=="male") {?> checked <?php } ?>>
				<label class="custom-control-label" for="customRadio" >Male</label>
			</div>
			<div class="custom-control custom-radio custom-control-inline">
				<input type="radio" class="custom-control-input" id="customRadio2" name="gender" value="female"<?php if($prev_data['gender']=="female") {?> checked <?php } ?>>
				<label class="custom-control-label" for="customRadio2">Female</label>
			</div>
			<div class="custom-control custom-radio custom-control-inline">
				<input type="radio" class="custom-control-input" id="customRadio3" name="gender" value="other" <?php if($prev_data['gender']=="self") {?> checked <?php } ?>>
				<label class="custom-control-label" for="customRadio3">Self</label>
			</div>
		</td>
	</tr>
	<tr>
		<td>Email : </td>
		<td><input type="email" name="email" class="form-control form-control-sm" value="<?= $prev_data['email']; ?>" required minlength="10"></td>
	</tr>
	<tr>
		<td>District : </td>
		<td>
			<select name="district" class="custom-select mb-3" required>
				<option <?php if ($prev_data['district']=="Kathmandu" ) {?> selected  <?php } ?>>Kathmandu</option>
				<option <?php if ($prev_data['district']=="Lalitpur" ) {?> selected  <?php } ?>>Lalitpur</option>
				<option <?php if ($prev_data['district']=="Bhaktapur" ) {?> selected  <?php } ?>>Bhaktapur</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Area : </td>
		<td>
			<select name="area" class="form-control form-control-sm" required>
				<?php
				$sql = "SELECT `area` FROM `location` ORDER BY `area` ASC";
				$result = mysqli_query($conn,$sql);
				while($name= mysqli_fetch_assoc($result))
				{
				?>
					<option <?php if($name['area']==$prev_data['area']) { ?>selected <?php } ?>><?= $name['area']; ?></option>
				<?php
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Contact : </td>
		<td><input type="tel" name="contact" class="form-control form-control-sm" pattern="9[6-9]{1}[0-9]{8}"  value="<?= $prev_data['contact']; ?>" required></td>
		<td>Format : 9812345678</td>
	</tr>
	<tr>
		<td>User Type : </td>
		<td>
			<select name="usertype" class="custom-select mb-3" required disabled>
				<option <?php if ($prev_data['usertype']=="SuperAdmin" ) {?> selected  <?php } ?>>SuperAdmin</option>
				<option <?php if ($prev_data['usertype']=="Admin" ) {?> selected  <?php } ?>>Admin</option>
				<option <?php if ($prev_data['usertype']=="Buyer" ) {?> selected  <?php } ?>>Buyer</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Password : </td>
		<td><input type="password" name="pass" class="form-control form-control-sm" required></td>
	</tr>
	<tr>
		<td>Confirm Password : </td>
		<td><input type="password" name="repass" class="form-control form-control-sm" required></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="text-center"><input type="submit" name="updater" class="btn btn-success btn-block" value="Update"></td>
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
		if (x != y)
		{
			alert("Passwords don't match, please verify");
			return false;
		}
	}
</script>
</html>