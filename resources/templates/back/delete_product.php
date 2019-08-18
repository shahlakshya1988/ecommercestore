<?php
require_once "../../config.php";
if(isset($_GET["product_id"])){
    $product_id = trim($_GET["product_id"]);
    $sql="DELETE FROM `products` where `product_id` = :product_id";
    $delete_product = $db->prepare($sql);
    $delete_product->execute(array(":product_id"=>$product_id));
    setMessage("Product Has Been Deleted");
} 
redirect("../../../public/admin/index.php?products");
die();
?>