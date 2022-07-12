<?php
if (!isset($_SESSION))
{
	session_start();
}
	$_SESSION['delivery']['name'] = $_POST['name'];
	$_SESSION['delivery']['address'] = $_POST['address'];
	$_SESSION['delivery']['phone'] = $_POST['phone'];
	$_SESSION['delivery']['payment_type'] = $_POST['payment_type'];
	if (isset($_FILES))
	{
		$_SESSION['delivery']['prescription']=1;
		move_uploaded_file($_FILES['prescription']['tmp_name'], "images/prescription/tmp/".$_SESSION['username'].".jpg");
	}
	
	if ($_POST['payment_type']=="esewa")
	{	
?>	
		<html>
			<head></head>
			    <body>
			    <form action="https://uat.esewa.com.np/epay/main" method="POST" id="abc">
			    	<input value="<?= $_SESSION['total']; ?>" name="tAmt" type="hidden">
			    	<input value="<?= $_SESSION['total']; ?>" name="amt" type="hidden">
			    	<input value="0" name="txAmt" type="hidden">
			    	<input value="0" name="psc" type="hidden">
			    	<input value="0" name="pdc" type="hidden">
			    	<input value="EPAYTEST" name="scd" type="hidden">
			    	<input value="<?= rand(); ?>" name="pid" type="hidden">
			    	<input value="http://localhost/epharma/esewa_success.php?q=su" type="hidden" name="su">
			    	<input value="http://localhost/epharma/checkout.php?q=fu" type="hidden" name="fu">
			    </form>
			    <script type="text/javascript">
					document.getElementById("abc").submit();
				</script>
			</body>
			</html> 
<?php	
	}
	else if ($_POST['payment_type']=="cod")
	{	$_SESSION['delivery']['paid']=0;
		$_SESSION['delivery']['tid'] = "null";
		header("Location: addtoorders.php");
	}
	else
	{	echo "Error..";
		exit();
	}
?>