<?php
$id = @$_GET['id'];
if (!isset($id)) {
	header('Location: product_list.php');
}
require_once('DBConnect.php');
$sql = "DELETE FROM `product` WHERE id='$id';";

if (mysqli_query($conn, $sql)) {
    // echo "Record deleted successfully";
    header('Location: product_list.php');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}