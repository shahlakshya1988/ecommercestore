<?php 
require_once "../resources/config.php"; 
if(isset($_GET["add"])){
    $add = trim($_GET["add"]);
    $_SESSION["product_".$add]++;
    redirect("index.php");
    die();
}

?>