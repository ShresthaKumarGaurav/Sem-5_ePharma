<?php 
    include 'include/navbar.php';
    include 'DBConnect.php';
    /*
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

            $aid = $_POST["hidden_id"];
            $a = "SELECT * FROM `product` WHERE `id` = '$aid'";
            $b = mysqli_query($conn,$a);
            $c= mysqli_fetch_assoc($b);
            $q= (int) $_POST["quantity"];
            $st = (int) $c['stock'];
            $stock = $st - $q;
            $a= "UPDATE product SET stock = $stock WHERE id = $aid";
                mysqli_query($conn,$a);
    }
    */
    if (isset($_POST["add"]))
    {   $stock = 0;
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

                $aid = $_POST["hidden_id"];
                $a = "SELECT * FROM `product` WHERE `id` = '$aid'";
                $b = mysqli_query($conn,$a);
                $c= mysqli_fetch_assoc($b);
                $q= (int) $_POST["quantity"];
                $st = (int) $c['stock'];
                $stock = $st - $q;
                $a= "UPDATE product SET stock = $stock WHERE id = $aid";
                mysqli_query($conn,$a);
            }
            else
            {
                $index = array_search($_POST['hidden_id'],array_column($_SESSION["cart"],"id"));
                $_SESSION["cart"][$index]['quantity'] += $item_array['quantity'];

                $aid = $_POST["hidden_id"];
                $a = "SELECT * FROM `product` WHERE `id` = '$aid'";
                $b = mysqli_query($conn,$a);
                $c= mysqli_fetch_assoc($b);
                $q= (int) $_POST["quantity"];
                $st = (int) $c['stock'];
                $stock = $st - $q;
                $a= "UPDATE product SET stock = $stock WHERE id = $aid";
                mysqli_query($conn,$a);
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
    {   

        $aid = $_POST["hidden_id"];
        $a = "SELECT * FROM `product` WHERE `id` = '$aid'";
        $b = mysqli_query($conn,$a);
        $c= mysqli_fetch_assoc($b);
        $q= (int) $_POST["quantity"];
        $st = (int) $c['stock'];
        $stock = $st + $q;
        $a= "UPDATE product SET stock = $stock WHERE id = $aid";
        mysqli_query($conn,$a);


        $check_deleted = 0;
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
    <title>Our Current Products</title>
</head>
<body>
      
    <div class="container-fluid">

        <!--  For Floating_Menu-->
      <ul style="list-style-type: none;margin-top: .5%;padding: 0;width: 15%;background-color:rgb(255, 255, 255);position: fixed;min-height: 50%;overflow: auto;" class="rounded">
        <li style="background-color: #4CAF50;color: white;padding: 3%;">Customize Product Search</li>
        <li>  <form onsubmit="return false;">
                    <div>Category</div>
                    <select id="category_filter" class="form-control form-control-sm">
                        <option selected>All</option>
                        <?php
                        $query = "SELECT name FROM category ORDER BY name ASC";
                        $statement = mysqli_query($conn,$query);
                        while($row = mysqli_fetch_array($statement))
                        {
                        ?>
                            <option><?php echo $row['name']; ?></option>
                        <?php } ?>
                    </select>
                    <div>Brand</div>
                    <select id="brand_filter" class="form-control form-control-sm">
                        <option selected>All</option>
                        <?php
                        $query = "SELECT name FROM brand ORDER BY name ASC";
                        $statement = mysqli_query($conn,$query);
                        while($row = mysqli_fetch_array($statement))
                        {
                        ?>
                            <option><?php echo $row['name']; ?></option>
                        <?php } ?>
                    </select>
                    <div>Price</div>
                    <input type="number" class="form-control-md rounded border-info text-center" id="price_minimum" placeholder="Min" min="0" value="" style="max-width: 30%;"> 
                    <span class="ml-1 mr-1">TO</span> 
                    <input type="number" class="form-control-md rounded border-info text-center" id="price_maximum" placeholder="Max" min="5" value="" style="max-width: 30%;">
                    <div class="d-flex justify-content-between mt-4">
                        <button type="reset" class="btn btn-secondary" onclick="filtercall();">Reset</button>
                        <button type="submit" class="btn btn-info filter_this" onclick="filtercall()">Find</button>
                    </div>
                </form>
        </li>
        </ul>

        <!--  For Floating_Cart-->
        <ul style="list-style-type: none;margin-top: .5%;padding: 0;min-width: 11%;background-color:rgb(255, 255, 255);position: fixed;overflow: auto;margin-left: 82%;" class="rounded">
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
                                <td><input type="number" name="quantity" style="width:50px;" class="rounded border-success text-center" min="10" value="<?= $value["quantity"]; ?>" required readonly></td>
                                <!--<td><input type="submit" name="update" value="Update" class="btn btn-sm btn-warning"></td>-->
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

        <!-- For product listing -->
        <div style="margin:.5% 19% 2% 19%;">
            <span class="d-flex">
                <h1 class="text-danger">Products</h1>&nbsp;<!--
                <input type="text" class="form-control-sm mt-1" value="AVAILABLE PRODUCTS" disabled>
                <h5 class="ml-auto mt-2">Enter Keyword :&nbsp;</h5>
                <input type="Search" name="search" placeholder="Search" class="form-control-sm mt-1" size="35%">-->
            </span>
            <div class="row mt-2" id="Plist">
                                                <!-- Products are listed by this section-->
            </div>
        </div>
        <?php include 'include/footer.php' ?>
    </div>

    <script>
        filtercall();
        function filtercall()
        {   var category_name = $("#category_filter").val();
            var brand_name = $("#brand_filter").val();           
            var price_min = Number($("#price_minimum").val());
            var price_max = Number($("#price_maximum").val());
            

            var con;
            if (price_min>price_max)
                { alert("Minimum price exceeds Maximum Price \n Please check again..");
                  exit(0);
                }
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200)
                { document.getElementById("Plist").innerHTML = this.responseText;}
            };
            xmlhttp.open("GET","filter.php?category="+category_name+"&brand="+brand_name+"&price_min="+price_min+"&price_max="+price_max,true);
            xmlhttp.send();
        }

    </script>

</body>
</html>
