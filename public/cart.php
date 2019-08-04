<?php 
require_once "../resources/config.php"; 
if(isset($_GET["add"])){
    $product_id = trim($_GET["add"]);
    $sel_product_query = "SELECT `product_quantity`,`product_title` FROM `products` where `product_id` = :product_id";
    $sel_product = $db->prepare($sel_product_query);
    $sel_product->execute(array(":product_id"=>$product_id));
    $result = $sel_product->fetch(PDO::FETCH_OBJ);
   //var_dump($result->product_quantity);
   if($result->product_quantity < $_SESSION["product_".$product_id]){
        $_SESSION["product_".$product_id]++;
   }else{
        setMessage("We Only Have {$result->product_quantity} of {$result->product_title} Available");
   }
   redirect("checkout.php");
   die();
    
}
