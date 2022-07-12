<?php
session_start();
$_SESSION['delivery']['paid']=1;
$_SESSION['delivery']['tid'] = $_GET['refId'];
header("Location: addtoorders.php");
?>