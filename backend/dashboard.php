<?php
include 'include/navigation.php';
// echo $_COOKIE["member_login"];exit;
if(empty($_SESSION)) // if the session not yet started
   session_start();

if(!isset($_SESSION['username'])) { 
  echo "<script>window.location='../login.php';</script>";
  exit;
}

else {
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
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <style type="text/css">
    img{height: auto;width: 100%;margin-bottom: 5px;}
  </style>
</head>
<body>
    <div class="container-fluid">
      <div class="jumbotron mt--3" style="width: 60%;margin-left:20%;margin-right: 20%;">
      <font size="6" class="text-monospace">Admin Panel
        <?php if($d['usertype']=="SuperAdmin") { ?>
          <a href="unverified_pharmacy.php" class="btn btn-outline-dark btn-sm">Unverified Pharmacies</a>
        <?php } ?>
      </font>
<div class="row d-flex jusitfy-content-center text-center">
      <?php if($d['usertype']=="SuperAdmin")
            { 
      ?>
        <a href="user_list.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/user_list.png"><br>List Users</a>
        <a href="user_add.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/user_add.png"><br>Add User</a>
        <a href="pharmacy_list.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/pharmacy_list.png" class="mb-3 mt-2"><br>List Pharmacy</a>
      <?php } 
        if (($d['usertype']=="SuperAdmin") || $d['usertype']=="Admin" )
        {
      ?>
      <a href="product_list.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/product_list.png"><br>List Products</a>
      <a href="product_add.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/product_add.png"><br>Add Product</a>
      <a href="category_list.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/category_list.png"><br>List Category</a>
      <a href="category_add.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/category_add.png" class="p-3"><br>Add Category</a>
      <a href="brand_list.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/category_list.png"><br>List Brands</a>
      <a href="brand_add.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/category_add.png"><br>Add Brand</a>
      <?php } ?>
      <a href="area_add.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/address.png" class="p-1"><br>Add Area</a>
      <a href="order_list.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/delivery.png"><br>View Orders</a>
      <a href="sales_list.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/sales.png" class="mt-3
        "><br>View Sales</a>
      <a href="../index.php" class="col-sm-6 col-md-4 col-lg-3"><img src="images/null.png"><br>Visit Frontend</a>
</div>
  </div>
      <?php include 'include/footer.php' ?>
    </div>

</body>
</html>