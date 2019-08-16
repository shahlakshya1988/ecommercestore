<?php require_once "../resources/config.php"; error_reporting(0); ?>
<?php // require_once "cart.php"; ?>
<?php require_once TEMPLATE_FRONT . DS . "header.php"; ?>
<?php 
if(isset($_GET["tx"])){
    //tx=1kkls34kj23&st=Completed&amt=675&cc=USD
    //tx=3b009265bbc9d&st=Completed&amt=675&cc=USD
    report();
    // var_dump($insert->errorInfo());
    session_destroy();
}else{
    redirect("index.php");
    die();
}
?>
<?php 
/***
 * $_SESSION["product_{product_id}"] = {number_of_products}
 * $_SESSION["product_2"] = 5;
 * 5 products with product_id of 2
 */

?>
<!-- Page Content -->
<div class="container">


    <!-- /.row -->

    <div class="row">
        <h1 class="text-center">Thankyou</h1>
    </div>


    </div>
    <!--Main Content-->






</div>
<!-- /.container -->
<?php require_once TEMPLATE_FRONT . DS . "footer.php"; ?>