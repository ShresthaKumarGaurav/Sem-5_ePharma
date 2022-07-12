<?php
$id = @$_GET['id'];
if (!isset($id)) {
	header('Location: brand_list.php');
}
require_once("DBConnect.php");
$sql = "SELECT * FROM `brand` WHERE `id`='$id'";
$result = mysqli_query($conn, $sql);
$prev_data = mysqli_fetch_assoc($result);
if (isset($_POST['updater'])) {
	$name = $_POST['name'];
	$about = $_POST['about'];
	$sql = "UPDATE `brand` SET `name`='$name',`about`='$about' WHERE `id`='$id';";
require_once("DBConnect.php");
if (mysqli_query($conn, $sql)) {
    // echo "Record updated successfully";
    header('Location: brand_list.php');
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
<h1>Update Brand #EP<?= $prev_data['id'];?></h1>
<form action="" method="POST">
<table class="table-responsive-sm">
	<tr>
		<td>Brand Name : </td>
		<td><input type="text" name="name" class="form-control form-control-sm mb-2" required value="<?= $prev_data['name'];?>"></td>
	</tr>
	<tr>
		<td>Brand Details : </td>
		<td><textarea name="about" class="form-control form-control-sm mb-2" required><?= $prev_data['about'];?></textarea></td>
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