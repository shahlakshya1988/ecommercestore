<?php
require_once "config.php";
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
    redirect("../public/checkout.php");
    die();
}
if (isset($_GET["remove"])) {
    $product_id = trim($_GET["remove"]);
    if ($_SESSION["product_" . $product_id] > 0) {
        $_SESSION["product_" . $product_id]--;
    }
    redirect("../public/checkout.php");
    die();
}


if (isset($_GET["delete"])) {
    $product_id = trim($_GET["delete"]);
    $_SESSION["product_" . $product_id] = 0;
    redirect("../public/checkout.php");
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
    $count = 1;
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
                    $item_count+=$value;
                    $subtotal = number_format($subtotal,2);
					$product_image = "../resources/".display_image($row->product_image);
                    $products = <<<EOL
                    <tr>
                        <td>{$row->product_title} <br>
						<img src="{$product_image}" height="100px;" />
                     
                        <input type="hidden" name="item_name_{$count}" value="{$row->product_title}">
                         <input type="hidden" name="item_number_{$count}" value="{$row->product_id}">
                          <input type="hidden" name="quantity_{$count}" value="{$value}">
                         <input type="hidden" name="amount_{$count}" value="{$subtotal}">
                      

                        </td>
                        <td>&#36;{$row->product_price}</td>
                        <td>{$value}</td>
                        <td>&#36;{$subtotal}</td>
                        <td>
                            <a href="../resources/cart.php?add={$row->product_id}" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>  
                            <a href="../resources/cart.php?remove={$row->product_id}" class="btn btn-warning"><span class="glyphicon glyphicon-minus"></span></a>
                            <a href="../resources/cart.php?delete={$row->product_id}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                        </td>
                    </tr>
EOL;
                    echo $products;

                } // while ($row = $query->fetch(PDO::FETCH_OBJ)) 
                 $count++;
            } // if ($value > 0) 
        } //if (substr($key, 0, 8) == "product_")
        
    } //foreach ($_SESSION as $key => $value) 

    $_SESSION["item_total"]=$total;
    $_SESSION["item_count"]=$item_count;
}


function show_paypal(){
    // var_dump($_SESSION["item_count"]);
    if(isset($_SESSION["item_count"]) && $_SESSION["item_count"]>0){
    $paypal_button=<<<EOF
    <input type="image" name="submit"
       src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
       alt="PayPal - The safer, easier way to pay online">
EOF;
    }
    return $paypal_button;
}


function process_trasactions(){
    global $db;
    $amount = $_GET["amt"];
    $currency = $_GET["cc"];
    $trasaction = $_GET["tx"];
    $status = $_GET["st"];
    $insert_query = "INSERT INTO `orders`(`order_id`,`order_amount`,`order_transaction`,`order_status`,`order_currency`) values (NULL,:order_amount,:order_transaction,:order_status,:order_currency)";
    $insert = $db->prepare($insert_query);
    $insert->bindParam(":order_amount",$amount);
    $insert->bindParam(":order_transaction",$trasaction);
    $insert->bindParam(":order_status",$status);
    $insert->bindParam(":order_currency",$currency);
    $insert->execute();
    $lastOrderId = $db->lastInsertId();
    $total = 0;
    $item_quantity = 0;
   
    $sql = "SELECT * FROM `products` where `product_id` = :product_id";
    $query = $db->prepare($sql);
    foreach($_SESSION as $key => $value){
        if($value>0){
            if(substr($key,0,8) == "product_"){
                $explode_key = explode("_", $key);
                $temp_product_id = $explode_key[1];
                $query->bindParam(":product_id",$temp_product_id);
                $query->execute();
                $insert_sql = "INSERT INTO `reports` (`product_id`,`order_id`,`product_price`,`product_quantity`,`product_title`) values (:product_id,:order_id,:product_price,:product_quantity,:product_title) ";
                $insert_query = $db->prepare($insert_sql);
                while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                    $subtotal = $value * $row->product_price;
                    $total+=$subtotal;
                    $item_quantity+=$value;
                    $subtotal = number_format($subtotal,2);

                    $product_quantity  = $value;
                    $product_id = $temp_product_id;
                    $product_title = $row->product_title;
                    $insert_query->execute([":product_id"=>$product_id,":product_price"=>$subtotal,":product_quantity"=>$product_quantity,":order_id"=>$lastOrderId,":product_title"=>$product_title]);
                    var_dump($insert_query->errorInfo());
                    
                }
            }
        }
    }
}