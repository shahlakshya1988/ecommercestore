<?php require_once "../resources/config.php"; ?>
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
        <?php var_dump($_SESSION["product_1"]); ?>

        <form action="">
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
                    <tr>
                        <td>apple</td>
                        <td>$23</td>
                        <td>3</td>
                        <td>2</td>
                        <td>
                            <a href="cart.php?add=1">Add</a>  
                            <a href="cart.php?remove=1">Remove</a>
                            <a href="cart.php?delete=1">Delete</a>
                        </td>

                    </tr>
                </tbody>
            </table>
        </form>



        <!--  ***********CART TOTALS*************-->

        <div class="col-xs-4 pull-right ">
            <h2>Cart Totals</h2>

            <table class="table table-bordered" cellspacing="0">

                <tr class="cart-subtotal">
                    <th>Items:</th>
                    <td><span class="amount">4</span></td>
                </tr>
                <tr class="shipping">
                    <th>Shipping and Handling</th>
                    <td>Free Shipping</td>
                </tr>

                <tr class="order-total">
                    <th>Order Total</th>
                    <td><strong><span class="amount">$3444</span></strong> </td>
                </tr>


                </tbody>

            </table>

        </div><!-- CART TOTALS-->


    </div>
    <!--Main Content-->






</div>
<!-- /.container -->
<?php require_once TEMPLATE_FRONT . DS . "footer.php"; ?>