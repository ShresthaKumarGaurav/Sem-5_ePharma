<?php
$id = @$_GET['id'];
if (!isset($id)) {
	header('Location: brand_list.php');
}
require_once('DBConnect.php');
$sql = "DELETE FROM `brand` WHERE id='$id';";

if (mysqli_query($conn, $sql)) {
    // echo "Record deleted successfully";
    header('Location: brand_list.php');
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}