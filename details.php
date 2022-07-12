<?php 
	include 'include/navbar.php';
    if (isset($_POST["update"]))
    {
            $item_array = array(
                    'id' => $_POST["hidden_id"],
                    'name' => $_POST["hidden_name"],
                    'price' => $_POST["hidden_price"],
                    'quantity' => $_POST["quantity"],
                );
            $index = array_search($_POST['hidden_id'],array_column($_SESSION["cart"],"id"));
            $_SESSION["cart"][$index] = $item_array;
    }
    if (isset($_POST["add"]))
    {
        if (isset($_SESSION["cart"]))
        {
            $item_array_id = array_column($_SESSION["cart"],"id");
            $item_array = array(
                    'id' => $_POST["hidden_id"],
                    'name' => $_POST["hidden_name"],
                    'price' => $_POST["hidden_price"],
                    'quantity' => $_POST["quantity"],
                );
            if (!in_array($_POST["hidden_id"],$item_array_id))
            { 
                array_push($_SESSION["cart"],$item_array);
                sort($_SESSION["cart"]);
            }
            else
            {
                $index = array_search($_POST['hidden_id'],array_column($_SESSION["cart"],"id"));
                $_SESSION["cart"][$index]['quantity'] += $item_array['quantity'];
            }
        }
        else
        {
            $item_array = array(
                'id' => $_POST["hidden_id"],
                'name' => $_POST["hidden_name"],
                'price' => $_POST["hidden_price"],
                'quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;
        }
    }
    if (isset($_POST["remove"]))
    {   $check_deleted = 0;
        $count = 0;
        $for_last = 0;
        $initial_array_count = count($_SESSION["cart"]);
        foreach ($_SESSION["cart"] as $keys => $value)
        {   
            if ($value["id"] == $_POST["hidden_id"])
            {
                unset($_SESSION["cart"][$keys]);
                $check_deleted = 1;
                $count = count($_SESSION["cart"]);
            }
            if ($check_deleted==1 && $count!=$keys)  //for shifting following arrays forward // $count is used for preventing offset [inevitable]
            {   $nxt = $keys ;
                $nxt++;
                $for_last = 1;                      
                $_SESSION["cart"][$keys]["id"] = $_SESSION["cart"][$nxt]["id"];
                $_SESSION["cart"][$keys]["name"] = $_SESSION["cart"][$nxt]["name"];
                $_SESSION["cart"][$keys]["price"] = $_SESSION["cart"][$nxt]["price"];
                $_SESSION["cart"][$keys]["quantity"] = $_SESSION["cart"][$nxt]["quantity"];
            }
        }
        sort($_SESSION["cart"]);
        if($for_last==1)            //$for_last is used to avoid array_pop iff last_session_value was deleted 
        { array_pop($_SESSION["cart"]); }
        
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Product Details</title>
</head>
<body>
	<div class="row">
		
	<div class="col-sm-9">
		<!-- Description Table -->
        <?php
        	$detail_id = $_GET['id'];
        	$result = mysqli_query($conn,"SELECT * FROM product WHERE `id`='$detail_id'");
        	$row = mysqli_fetch_assoc($result);
        ?>
        
		<form class="text-center m-3" method="POST">
			<div class="row">
				<div class="col-sm-6">
            	   <img src="<?php echo $row["image"]; ?>" class="img-thumbnail img-fluid mb-2">
            	</div>
                <div class="col-sm-6">
                    <p class="font-weight-bold" style="font-size: 30px;"><?php echo $row["name"]; ?></p>
	                <p class="text-danger"style="font-size: 30px;">Price : Rs <?php echo $row["price"]; ?></p>
	                <p class="text-primary font-weight-bold"style="font-size: 30px;">Category : <?php echo $row["category"]; ?></p>
	                <p class="text-black font-weight-bold"style="font-size: 30px;">
	                	Description : <br>
	                	<?php 
	                		$cat = $row['category'];
	                		$other = mysqli_query($conn,"SELECT description FROM category WHERE name = '$cat'");
	                		$other2 = mysqli_fetch_assoc($other);
	                		echo $other2['description'];
	                	?>
	                </p>
	                <p class="text-warning font-weight-bold"style="font-size: 30px;">
	                	Seller : <br>
	                	<?php 
	                		$ph_id = $row['pharmacy_id'];
	                		$other3 = mysqli_query($conn,"SELECT name FROM pharmacy WHERE id = '$ph_id'");
	                		$other4 = mysqli_fetch_assoc($other3);
	                		echo $other4['name'];
	                	?>
	                </p>
	                <input type="hidden" name="hidden_id" value="<?= $row['id']; ?>">
	                <input type="hidden" name="hidden_name" value="<?= $row['name']; ?>">
	                <input type="hidden" name="hidden_price" value="<?= $row['price']; ?>">
	                <p>Quantity : &nbsp;<input type="number" name="quantity" style="width:30%;" class="rounded border-success text-center" min="10" placeholder="m.10" required></p>
	                <p><input type="submit" class="btn btn-outline-success btn-block mt-2" name= "add" value="Add to Cart"></p>
                </div>	
			</div>
        </form>
	</div>
	<div class="col-sm-3 p-5">
		<!--  For Floating_Cart-->
        <ul style="list-style-type: none;min-width: 11%;background-color:rgb(255, 255, 255);overflow: auto;;" class="rounded">
          <li style="background-color: #4CAF50;color: white;padding: 3%;">Shopping Cart <br><font size="2%">( minimum order of <b>Rs.500</b>)</font></li>
          <li>
            <table> 
                <?php 
                if(!empty($_SESSION["cart"]))
                {  
                    $total=0;
                    foreach ($_SESSION["cart"] as $key => $value) 
                    { 
                        ?>

                        <form method="POST">
                            <tr class="text-center">
                                <td style="font-size:90%;text-align: left;"><?= $value["name"]; ?><input type="hidden" name="hidden_name" value="<?= $value['name']?>"><input type="hidden" name="hidden_price" value="<?= $value['price']?>"><input type="hidden" name="hidden_id" value="<?= $value['id']?>"></td>
                                <td><input type="number" name="quantity" style="width:50px;" class="rounded border-success text-center" min="10" value="<?= $value["quantity"]; ?>" required></td>
                                <td><input type="submit" name="update" value="Update" class="btn btn-sm btn-warning"></td>
                                <td><input type="submit" name="remove" value="Remove" class="btn btn-sm btn-danger"></td>
                            </tr>
                        </form>
                        <?php
                        $total = $total + $value["quantity"] * $value["price"];
                    }   ?>
                    <tr class="text-right">
                        <td colspan="4"><h4 class="mr-3 mt-2"> Total Amount<br>Rs. <?php echo number_format($total, 2); }else{echo "Cart Empty";}?></h4></td>
                    </tr>
                </table>
            
        </li>
        <li><a href="checkout.php" class="btn btn-block btn-outline-warning">Checkout</a></li>
        </ul>
	</div>
</div>
</body>
</html>