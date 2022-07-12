<?php
$id = @$_GET['id'];
if (!isset($id)) {
	header('Location: product_list.php');
}
require_once("DBConnect.php");
$sql = "SELECT * FROM `product` WHERE `id`='$id'";
$result = mysqli_query($conn, $sql);
$prev_data = mysqli_fetch_assoc($result);
if (isset($_POST['updater'])) {
	$name = $_POST['name'];
	$category = $_POST['category'];
	$price = $_POST['price'];
	$brand = $_POST['brand'];
	$stock = $_POST['stock'];
	$seller = $_POST['pharmacy'];
	$sql = "UPDATE `product` SET `name`='$name',`price`='$price',`category`='$category',`brand`='$brand',`stock`='$stock',`pharmacy_id`='$seller' WHERE `id`='$id';";
require_once("DBConnect.php");
if (mysqli_query($conn, $sql)) {
    // echo "Record updated successfully";
    header('Location: product_list.php');
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
<h1>Update Product #EP<?= $prev_data['id'];?></h1>
<form action="" method="POST" name="drug">
<table class="table-responsive-sm">
	<tr>
		<td>Product Code : </td>
		<td><input type="text" name="id" class="form-control form-control-sm mb-2" required value="<?= $prev_data['id'];?>" readonly></td>
	</tr>
	<tr>
		<td>Product Name : </td>
		<td><input type="text" name="name" class="form-control form-control-sm mb-2" required value="<?= $prev_data['name'];?>"></td>
	</tr>
	<tr>
		<td>Category : </td>
		<td><select name="category" class="custom-select mb-3" required>
				<?php 
					$sql = "SELECT * FROM category";
					$result = mysqli_query($conn,$sql);
					while ($row = mysqli_fetch_assoc($result))
					{
				?>
					<option <?php if($row['name']==$prev_data['category']) { ?> selected <?php } ?>><?= $row['name'] ?></option>
				<?php 
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Price : </td>
		<td><input type="number" name="price" class="form-control form-control-sm mb-2" min="5" required value="<?= $prev_data['price'];?>"></td>
	</tr>
	<tr>
		<td>Brand : </td>
		<td>
			<select name="brand" class="custom-select mb-3" required>
				<?php 
					$sql = "SELECT * FROM brand";
					$result = mysqli_query($conn,$sql);
					while ($row = mysqli_fetch_assoc($result))
					{
				?>
					<option <?php if($row['name']==$prev_data['brand']) { ?> selected <?php } ?>><?= $row['name'] ?></option>
				<?php 
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Stock : </td>
		<td><input type="number" name="stock" class="form-control form-control-sm mb-2" required min="1" placeholder="min. 1" value="<?= $prev_data['stock'];?>"></td>
	</tr>
	<tr>
		<td>Sold By : </td>
		<td>
			<?php 	
				$admin_id = $prev_data['pharmacy_id'];
				$usertype =  $d['usertype'];
	            $b2 = "SELECT * FROM `pharmacy` WHERE `id`='$admin_id'";
	            $c2 = mysqli_query($conn,$b2);
	            $d2 = mysqli_fetch_assoc($c2);
			?>
			<input type="text" name="pharmacy" class="form-control form-control-sm mb-2" required <?php if($usertype=='Admin'||$usertype=='SuperAdmin'){?>value="<?= $d2['name'];?>" <?php } ?>readonly >
			<?php ?>
		</td>
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