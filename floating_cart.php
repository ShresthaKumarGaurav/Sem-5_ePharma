<table> 
    <?php 
    if (empty($_SESSION))
    {
        session_start();
    }
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