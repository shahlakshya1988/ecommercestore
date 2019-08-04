<?php 
require_once "../resources/config.php"; 
if(isset($_GET["add"])){
    $product_id = trim($_GET["add"]);
    $sel_product_query = "SELECT `product_quantity`,`product_title` FROM `products` where `product_id` = :product_id";
    $sel_product = $db->prepare($sel_product_query);
    $sel_product->execute(array(":product_id"=>$product_id));
    $result = $sel_product->fetch(PDO::FETCH_OBJ);
   //var_dump($result->product_quantity);
   if($result->product_quantity > $_SESSION["product_".$product_id]){
        $_SESSION["product_".$product_id]++;
        // var_dump($_SESSION["product_".$product_id]);
        //die();
   }else{
        setMessage("We Only Have {$result->product_quantity} of {$result->product_title} Available");
   }
   redirect("checkout.php");
   die();
    
}
if(isset($_GET["remove"])){
    $product_id = trim($_GET["remove"]);
    if($_SESSION["product_".$product_id] > 0){
        $_SESSION["product_".$product_id]--;
    }
    redirect("checkout.php");
        die();
}


if(isset($_GET["delete"])){
    $product_id = trim($_GET["delete"]);
    $_SESSION["product_".$product_id]=0;
    redirect("checkout.php");
    die();
}