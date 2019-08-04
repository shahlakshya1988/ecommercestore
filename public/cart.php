<?php
require_once "../resources/config.php";
if (isset($_GET["add"])) {
    $product_id = trim($_GET["add"]);
    $sel_product_query = "SELECT `product_quantity`,`product_title` FROM `products` where `product_id` = :product_id";
    $sel_product = $db->prepare($sel_product_query);
    $sel_product->execute(array(":product_id" => $product_id));
    $result = $sel_product->fetch(PDO::FETCH_OBJ);
    //var_dump($result->product_quantity);
    if ($result->product_quantity > $_SESSION["product_" . $product_id]) {
        $_SESSION["product_" . $product_id]++;
        // var_dump($_SESSION["product_".$product_id]);
        //die();
    } else {
        setMessage("We Only Have {$result->product_quantity} of {$result->product_title} Available");
    }
    redirect("checkout.php");
    die();
}
if (isset($_GET["remove"])) {
    $product_id = trim($_GET["remove"]);
    if ($_SESSION["product_" . $product_id] > 0) {
        $_SESSION["product_" . $product_id]--;
    }
    redirect("checkout.php");
    die();
}


if (isset($_GET["delete"])) {
    $product_id = trim($_GET["delete"]);
    $_SESSION["product_" . $product_id] = 0;
    redirect("checkout.php");
    die();
}


function cart()
{
    global $db;
    $product_id_array = array();
    unset($product_id_array);
    $total = 0;
    $item_count=0;
    
    $sql = "SELECT * FROM `products` where `product_id`=:product_id ";
    $query = $db->prepare($sql);
    foreach ($_SESSION as $key => $value) {
        if (substr($key, 0, 8) == "product_") {
            //var_dump("Hello");
            $explode_key = explode("_", $key);
            $temp_product_id = $explode_key[1];
           
            if ($value > 0) {            
            
             $query->execute(array(":product_id"=>$temp_product_id));
            
                while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                    $subtotal = $value * $row->product_price;
                    $total+=$subtotal;
                    $item_count++;
                    $subtotal = number_format($subtotal,2);
                    $products = <<<EOL
                    <tr>
                        <td>{$row->product_title}</td>
                        <td>&#36;{$row->product_price}</td>
                        <td>{$value}</td>
                        <td>&#36;{$subtotal}</td>
                        <td>
                            <a href="cart.php?add={$row->product_id}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>  
                            <a href="cart.php?remove={$row->product_id}" class="btn btn-warning"><span class="glyphicon glyphicon-minus"></span></a>
                            <a href="cart.php?delete={$row->product_id}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
            EOL;
                    echo $products;
                } // while ($row = $query->fetch(PDO::FETCH_OBJ)) 
            } // if ($value > 0) 
        } //if (substr($key, 0, 8) == "product_")
    } //foreach ($_SESSION as $key => $value) 

    $_SESSION["item_total"]=$total;
    $_SESSION["item_count"]=$item_count;
}
