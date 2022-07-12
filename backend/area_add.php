<?php
	include 'include/navigation.php';
	if(empty($_SESSION)) // if the session not yet started
   session_start();
include 'DBConnect.php';
if(!isset($_SESSION['username']))
{ 
  echo "<script>window.location='../login.php';</script>";
  exit;
}

else
{
    $a = $_SESSION['username'];
    $b = "SELECT * FROM `user` WHERE `username`='$a'";
    $c = mysqli_query($conn,$b);
    $d = mysqli_fetch_assoc($c);
    if ($d['verification']==1)
      { }
    else 
      { echo "<script>alert('Account needs to be verified first..');</script>";
        header('Location: ../email_verification.php');
      }
}
if (isset($_POST['add']))
{	$area = ucfirst($_POST['area']);
	$sql = "INSERT INTO location (`area`) VALUES ('$area')";
	if (mysqli_query($conn,$sql))
	{
		echo "<script>alert('Added into database.');</script>";
		header('Location: dashboard.php');
	}
	else
	{
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="POST" name="abc" onsubmit="return verify()">
		<table class="container mt-5" style="width:auto;margin-left: 35%;">
			<tr>
				<th colspan="2">Add the area name below..</th>
				<th></th>
				<th></th>
			</tr>
			<tr>
				<td></td>
				<td colspan="2"><input type="text" name="area" class="form-control form-control-sm" autofocus onkeyup="check_db()" id="for_focus"></td>
				<td><div id="spin_this" style="display: none;"></div>
				<div id="remark"></div></td>
			</tr>
			<tr>
				<td> </td>
				<td> </td>
				<td> <input type="submit" name="add" value="Add" class="btn btn-success btn-block btn-sm" style="width: 50%;float: right;"></td>
			</tr>
		</table>
	</form>
</body>
<script type="text/javascript">
	function check_db()
	{	
		document.getElementById("spin_this").style.display="block";
		var x = document.forms["abc"]["area"].value;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function()
		 { if (this.readyState == 4 && this.status == 200)
		    { document.getElementById("spin_this").style.display="none";
		      document.getElementById("remark").innerHTML = this.responseText;
		  	}
		};
		xmlhttp.open("GET","location_check.php?area="+x,true);
		xmlhttp.send();
	}
	function verify()
	{
		if (document.getElementById("remark").innerText=="Area already in database")
			{ 	alert('Already in database');
				document.getElementById("for_focus").focus();
				return false;
			}
	}
</script>
</html>