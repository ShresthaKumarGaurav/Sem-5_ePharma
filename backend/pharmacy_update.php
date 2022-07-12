<?php
$id = @$_GET['id'];
if (!isset($id)) {
	header('Location: pharmacy_list.php');
}
require_once("DBConnect.php");
$sql = "SELECT * FROM `pharmacy` WHERE `id`='$id'";
$result = mysqli_query($conn, $sql);
$prev_data = mysqli_fetch_assoc($result);
if (isset($_POST['updater'])) {
	$name = $_POST['name'];
	$address = $_POST['address'];
	$contact = $_POST['contact'];
	$owner = $_POST['owner'];
	$sql = "UPDATE `pharmacy` SET `name`='$name',`address`='$address',`contact`='$contact',`owner`='$owner' WHERE `id`='$id';";
require_once("DBConnect.php");
if (mysqli_query($conn, $sql)) {
    // echo "Record updated successfully";
    header('Location: pharmacy_list.php');
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
mysqli_close($conn);
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
<h1>Update Pharmacy #EP<?= $prev_data['id'];?></h1>
<form action="" method="POST" name="pharmacy">
<table class="table-responsive-sm">
	<tr>
		<td>Pharmacy Name : </td>
		<td><input type="text" name="name" class="form-control form-control-sm mb-2" required value="<?= $prev_data['name'];?>"></td>
	</tr>
	<tr>
		<td>Registration Number : </td>
		<td><input type="number" name="reg" class="form-control form-control-sm mb-2" required value="<?= $prev_data['registration_number'];?>" disabled></td>
	</tr>
	<tr>
		<td>Address : </td>
		<td><input type="text" name="address" class="form-control form-control-sm mb-2" required value="<?= $prev_data['address'];?>"></td>
	</tr>
	<tr>
		<td>Contact : </td>
		<td><input type="text" name="contact" class="form-control form-control-sm mb-2" value="<?= $prev_data['contact'];?>" required pattern="[6-9]{2}[0-9]{8}"></td>
		<td>Format : 9812345678</td>
	</tr>
	<tr>
		<td>Proprietor : </td>
		<td><input type="text" name="owner" class="form-control form-control-sm mb-2" required value="<?= $prev_data['owner'];?>"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><button type="submit" name="updater" class="btn btn-success btn-block mb-3">Update</button></td>
	</tr>
</table>
</form>
	<?php include 'include/footer.php';?>
	</div>
</body>
</html>