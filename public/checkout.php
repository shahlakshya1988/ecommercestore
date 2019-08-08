<?php require_once "../resources/config.php"; error_reporting(0); ?>
<?php require_once "cart.php"; ?>
<?php require_once TEMPLATE_FRONT . DS . "header.php"; ?>

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
        <h4 class="text-center"><?php displayMessage(); ?></h4>
        <h1>Checkout</h1>
        <?php // var_dump($_SESSION["product_1"]); ?>

        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
          <input type="hidden" name="cmd" value="_cart">
          <input type="hidden" name="business" value="lakshya1@shahlakshya1988.com">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Sub-total</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <?php cart(); ?>
                </tbody>
            </table>
            <input type="image" name="submit"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">
        </form>



        <!--  ***********CART TOTALS*************-->

        <div class="col-xs-4 pull-right ">
            <h2>Cart Totals</h2>

            <table class="table table-bordered" cellspacing="0">

                <tr class="cart-subtotal">
                    <th>Items:</th>
                    <td><span class="amount"><?php echo $_SESSION["item_count"]; ?></span></td>
                </tr>
                <tr class="shipping">
                    <th>Shipping and Handling</th>
                    <td>Free Shipping</td>
                </tr>

                <tr class="order-total">
                    <th>Order Total</th>
                    <td><strong><span class="amount">$<?php echo $_SESSION["item_total"]; ?></span></strong> </td>
                </tr>


                </tbody>

            </table>

        </div><!-- CART TOTALS-->


    </div>
    <!--Main Content-->






</div>
<!-- /.container -->
<?php require_once TEMPLATE_FRONT . DS . "footer.php"; ?>