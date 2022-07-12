<?php
	include 'include/navbar.php';
	unset($_SESSION['cart']);
	unset($_SESSION['delivery']);
	unset($_SESSION['total']);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="container">
		<h1 class="mt-5 rounded bg-primary text-center text-white p-2">Your Order has been placed successfully.</h1>
		<a href="index.php" class="btn btn-outline-success btn-block mt-3">Explore more .. </a>
	</div>
	<?php include 'include/footer.php'; ?>
</body>
</html>