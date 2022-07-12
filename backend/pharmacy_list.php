<?php
require_once("DBConnect.php");
$sql = "SELECT * FROM `pharmacy` ORDER BY `name` ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy List</title>
</head>
<body>
<?php include 'include/navigation.php';?>
<div class="container" style="width: 60%;margin-left:20%;margin-right: 20%;">
    <h1>Pharmacy List</h1>
    <a href="user_add.php"><img src="images/bootstrap.jpg" height="30px">+</a>
    <table class="text-center table-bordered table-primary table-hover table-sm mb-2 ">
        <tr>
            <th>S.N.</th>
            <th>Pharmacy</th>
            <th>Registration Number</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Proprietor</th>
        </tr>
        <?php
        if ($result) {
            $i=0;
            while($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr>
                    <td><?= ++$i;?></td>
                    <td><?= $row["name"];?></td>
                    <td><?= $row["registration_number"];?></td>
                    <td><?= $row["address"]; ?></td>
                    <td><?= $row["contact"]; ?></td>
                    <td><?= $row["owner"];?></td>
                    <td><a href="pharmacy_update.php?id=<?= $row['id'];?>">Edit</a>&nbsp; | <a onclick="return confirm('Are you sure you want to delete this entry?')" href="pharmacy_delete.php?id=<?= $row['id'];?>">Delete</a></td>
                </tr>
                <?php
            }   
        } else {
            ?>
            <tr>
                <td colspan="6">No Record(s) found.</td>
            </tr>
            <?php
        }
        ?>
        <?php 
        mysqli_close($conn);
        ?>
    </table>
    <?php include 'include/footer.php';?>
</div>
</body>
</html>