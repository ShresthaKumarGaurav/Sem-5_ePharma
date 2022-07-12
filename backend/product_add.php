<?php
if (isset($_POST['add_drug']))
{	include 'DBConnect.php';
	// echo "Nepal";exit();
	$result = mysqli_query($conn, "SELECT Max(`id`) AS code FROM product");  // Product code
	$row = mysqli_fetch_assoc($result);
	$pcode = $row['code']+1;

	$name = $_POST['name'];
	$category = $_POST['category'];
	$price = $_POST['price'];
	$brand = $_POST['brand'];
	$stock = $_POST['stock'];
	$image_path = "images/product/".$pcode.".jpg";
	print_r($_FILES);
	move_uploaded_file($_FILES['image']['tmp_name'], "../".$image_path);

	$seller = $_POST['pharmacy'];
	$sql = "SELECT `id` FROM `pharmacy` WHERE `name`='$seller'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$seller_id = $row['id'];
	$sql = "INSERT INTO `product` (`image`,`name`,`category`,`price`,`brand`,`stock`,`pharmacy_id`) VALUES ('$image_path','$name','$category','$price','$brand','$stock','$seller_id')";
	if (mysqli_query($conn, $sql))
	{
	    // echo "New record created successfully.";
	    header('Location: product_list.php');
	} 
	else
	{
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
		<h1>Add Product</h1>
		<form action="" method="POST" name="drug" enctype="multipart/form-data">
			<table class="table-sm mb-2">
				
				<tr>
					<td>Product Name : </td>
					<td><input type="text" name="name" class="form-control form-control-sm" required></td>
				</tr>
				<tr>
					<td>Category : </td>
					<td>
						<select name="category" class="form-control form-control-sm" required>
							<option disabled selected></option>
							<?php
								$sql = "SELECT `name` FROM `category` ORDER BY `name` ASC";
								$result = mysqli_query($conn,$sql);
								while($name= mysqli_fetch_assoc($result))
								{
							?>
								<option><?= $name['name']; ?></option>
								<?php

								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Price / piece : </td>
					<td><input type="number" name="price" class="form-control form-control-sm" min="5" required></td>
				</tr>
				<tr>
					<td>Brand : </td>
					<td>
						<select name="brand" class="form-control form-control-sm" required>
							<option disabled selected></option>
							<?php
								$sql = "SELECT `name` FROM `brand` ORDER BY `name` ASC";
								$result = mysqli_query($conn,$sql);
								while($name= mysqli_fetch_assoc($result))
								{
							?>
								<option><?= $name['name']; ?></option>
								<?php

								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Stock : </td>
					<td><input type="number" name="stock" class="form-control form-control-sm" required min="10" placeholder="min. 10"></td>
				</tr>
				<tr>
					<td>Seller : </td>
					<td>
						<?php 	
							$a = $_SESSION['username'];             
							$b = "SELECT * FROM `user` WHERE `username`='$a'";
							$c = mysqli_query($conn,$b);
							$d = mysqli_fetch_assoc($c);
							$admin_id = $d['admin_id'];
							$usertype =  $d['usertype'];
	                        $b2 = "SELECT * FROM `pharmacy` WHERE `id`='$admin_id'";
	                        $c2 = mysqli_query($conn,$b2);
	                        $d2 = mysqli_fetch_assoc($c2);
						?>
						<select name="pharmacy" class="form-control form-control-sm" required <?php if($usertype=="Admin") { ?>readonly <?php } ?>>
							<option selected disabled></option>
							<?php
							$sql = "SELECT `name` FROM `pharmacy` ORDER BY `name` ASC";
							$result = mysqli_query($conn,$sql);
							while($name= mysqli_fetch_assoc($result))
							{
							?>
								<option <?php if($name['name']==$d2['name']) { ?>selected <?php } elseif($usertype=="Admin") {?>disabled <?php } ?>><?= $name['name']; ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr rowspan=""2>
					<td>Product Image : <br>( Max 5MB .jpg / .jpeg )</td>
					<td><input type="file" id="image" name="image" class="form-control form-control" required onchange="check_image(this)"></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td class="text-center"><button type="submit" name="add_drug" class="btn btn-success btn-block">Add</button></td>
				</tr>
			</table>
		</form>
		<?php include 'include/footer.php';?>
	</div>
</body>
<script type="text/javascript">
	function check_image(file)
	{
		var FileSize = file.files[0].size / 1024/1024; // in MB
	    if (FileSize > 5)
	    {
	        alert("File size exceeded");
	        document.getElementById("image").value = "";
	    }
	    else
	    {
	    	var path = file.files[0].type;
	    	if (path.endsWith('jpg') || path.endsWith('jpeg'))
	    		{ }
	    	else 
	    	{
	    		alert("Image extension not valid");
	        	document.getElementById("image").value = "";
	    	}
	    }
	}
</script>
</html>