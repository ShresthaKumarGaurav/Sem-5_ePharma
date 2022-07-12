<?php
include 'DBConnect.php';
if (isset($_POST['verify']))
{   $phid = $_POST['phid'];
    $sql = "UPDATE `pharmacy` SET `verification`=1 WHERE `id` = '$phid'";
    if (mysqli_query($conn,$sql)) 
    {
        echo "<script>alert('Validated');</script>";
    }
    else
        echo "<script>alert('Couldn't Validated');</script>";
}
    $sql = "SELECT * FROM `pharmacy` WHERE `verification` = 0";
    $result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Unverified Pharmacy</title>
</head>
<body>
<?php include 'include/navigation.php';?>
<div class="container" style="width: 60%;margin-left:20%;margin-right: 20%;">
    <h1>Pharmacy that need verification</h1>
    <table class="text-center table-bordered table-primary table-hover table-sm mb-2 ">
        <tr>
            <th>S.N.</th>
            <th>Pharmacy</th>
            <th>Registration Number</th>
            <th>License</th>
            <th>PAN</th>
            <th>Address</th>
            <th>Contact</th>
            <th>Proprietor</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result) {
            $i=0;
            while($row = mysqli_fetch_assoc($result)) {
        ?>  <form method="POST" onsubmit="return confirm('Are you sure you wanna validate this seller ? \n \n This CAN NOT be undone.')">
                <tr>
                    <td><input type="hidden" name="phid" value="<?= $row['id']; ?>"></td>
                </tr>
                <tr>
                    <td><?= ++$i;?></td>
                    <td><?= $row["name"];?></td>
                    <td><?= $row["registration_number"];?></td>
                    <td>
                    <?php
                        $location = "../".$row['license'];
                        echo "<a href=".$location."><img src='".$location."' style='width:100px;' alt='image'></a>";
                    ?> 
                    </td>
                    <td>
                    <?php
                        $location = "../".$row['pan'];
                        echo "<a href=".$location."><img src='".$location."' style='width:100px;' alt='image'></a>";
                    ?> 
                    </td>
                    <td><?= $row["address"]; ?></td>
                    <td><?= $row["contact"]; ?></td>
                    <td><?= $row["owner"];?></td>
                    <td><input type="submit" name="verify" value="Validate" class="btn btn-primary"></td>
                </tr>
            </form>
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