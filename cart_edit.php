
<?php
if (!isset($_SESSION))
{
   session_start();
}
    if (isset($_POST["mode"]=="update"))
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
    if (isset($_POST["mode"]=="add"))
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
    if (isset($_POST["mode"]=="remove"))
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