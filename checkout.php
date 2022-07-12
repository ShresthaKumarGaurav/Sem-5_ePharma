<?php 
    include 'include/navbar.php';
    if(isset($_SESSION['username']))
        {}
    else
    {
        header("location:login.php");
    }

    if (isset($_POST["updater"]))
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
    if (isset($_GET["action"]))
    {   
        $aid = $_GET["id"];
        $a = "SELECT * FROM `product` WHERE `id` = '$aid'";
        $b = mysqli_query($conn,$a);
        $c= mysqli_fetch_assoc($b);
        $q= (int) $_GET["quantity"];
        $st = (int) $c['stock'];
        $stock = $st + $q;
        $a= "UPDATE product SET stock = $stock WHERE id = $aid";
        mysqli_query($conn,$a);

        $temp = 0;
        $count = 0;
        $for_last = 0;
        foreach ($_SESSION["cart"] as $keys => $value)
        {   
            if ($value["id"] == $_GET["id"])
            {
                unset($_SESSION["cart"][$keys]);
                $temp = 1;
                $count = count($_SESSION["cart"]);
            }
            if ($temp==1 && $count!=$keys)  //for shifting following arrays forward
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
        if($for_last==1)
        { array_pop($_SESSION["cart"]); }
        
    }

    if (isset($_POST["checkout"]))
    {
        if (isset($_SESSION['username']))
        { echo "<script>window.location='order_now.php';</script>"; }
        else
        { echo "<script><alert('You must log in first');</script>"; }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
<h3 class="mt-4 mb-4 container">Shopping Cart Details</h3>
<table class="table table-bordered container">
    <tr>
        <th width="30%">Product Name</th>
        <th width="10%">Quantity</th>
        <th width="13%">Price Details</th>
        <th width="10%">Total Price</th>
        <th width="17%">Remove Item</th>
    </tr>

    <?php 
    if(!empty($_SESSION["cart"]))
    {  
        $total=0;
        foreach ($_SESSION["cart"] as $key => $value) 
        { 
            ?>  <form method="POST">
                <tr>
                    <td>
                        <?php echo $value["name"]; ?><input type="hidden" name="hidden_id" value="<?= $value["id"]; ?>" ><input type="hidden" name="hidden_name" value="<?= $value["name"]; ?>" >
                    </td>
                    <td>
                        <input type="number" name="quantity" min="10" style="width:50%;" class="rounded border-success text-center mr-2" value="<?php echo $value["quantity"]; ?>"readonly><!--<input type="submit" name="updater" value="Update" class="btn btn-sm btn-warning mr-5" >-->
                    </td>
                    <td>
                        Rs. <?php echo $value["price"]; ?><input type="hidden" name="hidden_price" value="<?= $value["price"]; ?>">
                    </td>
                    <td>
                        Rs. <?php echo number_format($value["quantity"] * $value["price"], 2); ?>
                    </td>
                    <td>
                        <a onclick="return confirm('Are you sure you want to delete this entry?')" href="checkout.php?action=delete&id=<?php echo $value["id"]; ?>&quantity=<?php echo $value["quantity"]; ?>"><span class="text-danger">Remove Item</span></a>
                    </td>
                </tr>
            </form>
            <?php
            $total = $total + $value["quantity"] * $value["price"];
        }   
        ?>
        <tr class="font-weight-bold">
            <td colspan="3" align="right">Total</td>
            <td colspan="2">Rs. <?php $_SESSION['total']=$total; echo number_format($total, 2); ?></td>
        </tr>
        <?php 
    }   
    ?>
</table>
<?php if (!empty($_SESSION['cart'])) { ?>
<form method="POST" action="delivery_session.php" enctype="multipart/form-data">
    <div class="container">
        <h1 class="mt-5 text-center">Delivery Details</h1>
        <label for="name">Deliver to:</label>
        <div class="input-group mb-1"> 
            <div class="input-group-prepend"><span class="input-group-text mb-3">Mr. / Mrs. / Miss</span></div>
            <input type="text" name="name" class="form-control" required>
        </div>
        <label for="address">Delivery Address:</label>
        <input type="text" name="address" class="form-control" required>
        <label for="phone">Cell Number : </label>
        <div class="input-group mb-1"> 
            <div class="input-group-prepend"><span class="input-group-text mb-3">+977</span></div>
            <input type="number" name="phone" min="9800000000" max="9888888888" class="form-control" required>
        </div>
        <label for="prescription">Prescription photo (Compulsory for medicines that need prescription) : </label>
        <div class="input-group mb-1"> 
            <div class="input-group-prepend"><span class="input-group-text mb-3">only .jp / .jpeg : Maximum 5MB</span></div>
            <input type="file" name="prescription" class="form-control" onchange="check_image(this)" id="prescription">
        </div>
    </div>
    <div class="row d-flex justify-content-center mt-5">
        <button type="submit" name="payment_type" value="esewa" class="btn btn-outline-dark btn-lg mr-3">Pay using eSewa</button>
        <button type="submit" name="payment_type" value="cod" class="btn btn-outline-dark btn-lg ml-3">Cash On Delivery</button>
    </div>
</form>
<?php } else echo "<p class='text-center'>No ITEMs</p>"; include 'include/footer.php' ;?>
</body>
<script type="text/javascript">
    function check_image(file)
    {
        var FileSize = file.files[0].size / 1024/1024; // in MB
        if (FileSize > 5)
        {
            alert("File size exceeded");
            document.getElementById("prescription").value = "";
        }
        else
        {
            var path = file.files[0].type;
            if (path.endsWith('jpg') || path.endsWith('jpeg'))
                { }
            else 
            {
                alert("Image extension not valid");
                document.getElementById("prescription").value = "";
            }
        }
    }
</script>
</html>