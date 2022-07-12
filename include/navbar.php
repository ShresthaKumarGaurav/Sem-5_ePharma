<?php session_start(); ?>
<link rel="icon" href="images/favicon.png" type="image/png">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/argon.css">
<div class="navbar">
	<a href="index.php" class="logo" style="text-decoration: none;">ePharma
		<?php
		 	include "backend/DBConnect.php";
			if (isset($_SESSION['username'])) 
			{	$t = $_SESSION['username'];
				$sql = "SELECT `firstname` FROM `user` WHERE `username`='$t' AND `verification` = '1'";
	        	$query = mysqli_query($conn,$sql);
	        	$result = mysqli_fetch_assoc($query);
				echo "welcomes you, "."<span class='text-dark font-weight-bold'>".$result['firstname']."</span>";
			}
		?>
	</a>
	<ul class="nav">
		<li><a href="index.php">Home</a></li> 
		<li><a href="about_us.php">About Us</a></li>
		<li><a href="cart.php">Products</a></li>
		<li><a href="contact_us.php">Contact Us</a></li>
		<li><a href="checkout.php">My Cart</a></li>
		<li><?php 
			    if(isset($_SESSION['username']))
			    {   
			        echo  "<a href='backend/dashboard.php'>Dashboard</a><a href='backend/logout.php'>Logout</a>";
			    }
			    else  
			    { echo "<a href='login.php'>Login</a>"; } 
			?>  
		</li>
	</ul>     
</div>