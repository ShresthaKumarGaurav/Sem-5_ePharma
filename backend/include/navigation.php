<?php 
if(empty($_SESSION))
  {   
    session_start();
    if(isset($_COOKIE["member_login"]))
    { 
      $_SESSION['username'] = $_COOKIE["member_login"];
      echo "<script>window.location='Cart.php';</script>";
      exit;
    }
  }
if(!isset($_SESSION['username'])) { 
  echo "<script>window.location='../login.php';</script>";
  exit;
}
?>

<link rel="icon" href="../images/favicon.png" type="image/png">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../css/argon.css?v=1.2.0">
<style type="text/css">
  .nav-item
  { margin-bottom: 5px; }
  .container{margin-left: 15%;}

        th,td
        { padding-top: 2px;
            padding-bottom: 2px;
        }
        li a {
          display: block;
          color: #000;
          padding: 8px 16px;
          text-decoration: none;
        }

        li a.active {
          background-color: #4CAF50;
          color: white;
        }

        li a:hover:not(.active) {
          background-color: gray;
          border-radius: 25px;
          color: black;
        }
</style>
<nav class="navbar navbar-vertical bg-gradient-gray-dark navbar-expand-sm navbar-light bg-white" style="width:20%;color: white;">
        <p class="text-center mt-2">Accessing as : <?php echo ucwords($_SESSION['username']."<br>"); 
          require_once("DBConnect.php");
          $a = $_SESSION['username'];
          $b = "SELECT * FROM `user` WHERE `username`='$a'";
          $c = mysqli_query($conn,$b);
          $d = mysqli_fetch_assoc($c);
          echo "<font class='text-light'>UserType : ".$d['usertype']."</font>";
          ?>
        </p>
    <div class="navbar-inner mt--4">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">
              <i class="ni ni-tv-2 text-primary"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
        <?php if($d['usertype']=="SuperAdmin"){ ?>
          <li class="nav-item">
            <a class="nav-link " href="user_list.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">List User</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="user_add.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">Add User</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="pharmacy_list.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">List Pharmacy</span>
            </a>
          </li>
        <?php } if (($d['usertype']=="SuperAdmin") || $d['usertype']=="Admin" )
        {?>
          <li class="nav-item">
            <a class="nav-link " href="product_list.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">List Product</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="product_add.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">Add Product</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="category_list.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">List Category</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="category_add.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">Add Category</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="brand_list.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">List Brand</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="brand_add.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">Add Brand</span>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a class="nav-link " href="area_add.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">Add Area</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="order_list.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">View Orders</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="sales_list.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">View Sales</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="../index.php">
              <i class="ni ni-bullet-list-67"></i>
              <span class="nav-link-text text-white">Visit Frontend</span>
            </a>
          </li>
          <hr class="my-3">
            <a class="nav-link" href="logout.php">
              <i class="ni ni-key-25 text-info ml--2"></i>
              <span class="nav-link-text text-muted ml-5">Log Out</span>
            </a>
      </div>
    </div>
</nav>
<!--
<ul style="list-style-type: none;margin-top: 35%;padding: 0;width: 15%;background-color:rgb(255, 255, 255);position: fixed;min-height:200px;overflow: auto;margin-left: 83%;" class="rounded bg-gradient-green">
          <li><a class="active" href="#">Widget</a></li>
</ul>
-->