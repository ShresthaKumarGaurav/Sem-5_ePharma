<?php
if (isset($_POST['add'])) {
	// echo "Nepal";exit();
	$name = $_POST['name'];
	$description = $_POST['description'];
			$sql = "INSERT INTO `category` (`name`,`description`) VALUES ('$name','$description')";
		require_once("DBConnect.php");
		if (mysqli_query($conn, $sql)) {
		    // echo "New record created successfully.";
		    header('Location: category_list.php');
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
		<h1>Add Category</h1>
		<form action="" method="POST" name="drug">
			<table class="table-sm mb-2">
				<tr>
					<td>Category Name : </td>
					<td><input type="text" name="name" class="form-control form-control-sm" required></td>
				</tr>
				<tr>
					<td>Description : </td>
					<td><textarea class="form-control form-control-sm" rows="5" name="description"></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td class="text-center"><button type="submit" name="add" class="btn btn-success btn-block">Add</button></td>
				</tr>
			</table>
		</form>
		<?php include 'include/footer.php';?>
	</div>
</body>
</html>