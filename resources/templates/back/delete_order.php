<?php
require_once "../../config.php";
if(isset($_GET["order_id"])){
    $order_id = trim($_GET["order_id"]);
    $sql="DELETE FROM `orders` where `order_id` = :order_id";
    $delete_order = $db->prepare($sql);
    $delete_order->execute(array(":order_id"=>$order_id));
    setMessage("Order Has Been Deleted");
} 
redirect("../../../public/admin/index.php?orders");
die();
?>