<?php  
    
	include 'DBConnect.php';
    $basic_query = "SELECT *,P.name AS name,P.id AS pid FROM product P LEFT JOIN  category C ON P.category=C.name";
	    $category = $_GET["category"];
    	$brand = $_GET["brand"];
        $price_min = $_GET["price_min"];
        $price_max = $_GET["price_max"];
		if ($category=="All")
		{
			if ($brand=="All")
            {
               if ($price_min==0 && $price_max==0)
                    $query = $basic_query;
               else
                    $query = $basic_query." WHERE P.price BETWEEN '$price_min' AND '$price_max'";
            }
            elseif ($brand!="All")
            {
                if ($price_min==0 && $price_max==0)
                    $query = $basic_query." WHERE P.brand='$brand'";
               else
                    $query = $basic_query." WHERE P.brand='$brand' AND P.price BETWEEN '$price_min' AND '$price_max'";
            }
		}
        elseif ($category!="All")
        {
            
            if ($brand=="All")
            {
               if ($price_min==0 && $price_max==0)
                    $query = $basic_query." WHERE P.category='$category'";
               else
                    $query = $basic_query." WHERE P.category='$category' AND P.price BETWEEN '$price_min' AND '$price_max'";
            }
            elseif ($brand!="All")
            {
                if ($price_min==0 && $price_max==0)
                    $query = $basic_query." WHERE P.category='$category' AND P.brand='$brand'";
               else
                    $query = $basic_query." WHERE P.category='$category' AND P.brand='$brand' AND P.price BETWEEN '$price_min' AND '$price_max'";
            }

        }


		$result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) > 0) 
            {
                while ($row = mysqli_fetch_array($result))
                {
                    ?>
                        <form class="text-center col-md-3" method="POST">
                            <table class="border rounded m-2 text-center">
                                <tr>
                                    <td>
                                        <a href="details.php?id=<?= $row['pid']; ?>" class="hovereffect d-flex flex-wrap align-content-end" style="height: 200px;;width: 100%;">
                                            <img src="<?php echo $row["image"]; ?>" class="img-fluid mb-2">
                                            <h2 class="overlay d-flex flex-wrap align-content-center">
                                                <?php  
                                                    echo $row["description"];
                                                ?>
                                            </h2>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $row["name"]; ?></td>
                                </tr>
                                <tr>
                                     <td class="text-danger">Price : Rs <?php echo $row["price"]; ?></td>
                                </tr>
                                <tr>
                                    <td><input type="hidden" name="hidden_id" value="<?= $row['pid']; ?>" ></td>
                                    <td><input type="hidden" name="hidden_name" value="<?= $row['name']; ?>"></td>
                                    <td><input type="hidden" name="hidden_price" value="<?= $row['price']; ?>"></td>
                                </tr>
                                <tr class="<?php if($row['stock']==0){echo "bg-warning";}else if($row['stock']<50){echo "bg-yellow";}else{echo "bg-success";} ?> rounded">
                                    <td>In stock : <input type="number" name="stock" value="<?= $row['stock'];?>" disabled style="width: 40%;text-align: center;"></td>
                                </tr>
                                <tr>
                                    <td>Quantity : &nbsp;<input type="number" name="quantity"  class="rounded border-success text-center" min="10" max="<?= $row['stock'];?>" placeholder="m.10" required style="width: 40%;"></td>
                                </tr>
                                <tr>
                                    <td><input type="submit" class="btn <?php if($row['stock']==0){echo " btn-warning ";}else {echo " btn-outline-success ";}?> btn-block mt-2" name= "add" value="Add to Cart" <?php if($row['stock']==0){echo "disabled";} ?>></td>
                                </tr>
                            </table>
                        </form>
                    <?php
                }
            }
            else
            {   ?>
                <h2 style="margin: 10%;" class="text-muted">Related Product not Found !!</h2>
                <?php 
            }
?>