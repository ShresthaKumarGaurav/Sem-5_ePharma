<?php
$key = @$_GET['id'];
if (!isset($key)) {
	header('Location: sales_list.php');
}
 
require_once('DBConnect.php');
$sql = "DELETE FROM `sales` WHERE id='$key';";

if (mysqli_query($conn, $sql)) {
    // echo "Record deleted successfully";
    header('Location: sales_list.php');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}