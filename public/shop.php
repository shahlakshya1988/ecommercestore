<?php require_once "../resources/config.php"; ?>
<?php require_once TEMPLATE_FRONT.DS."header.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="">
            <h1>Shop</h1>
           
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Products</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">
			
           <?php get_products_in_shop_page(); ?>

           

            

        </div>
        <!-- /.row -->

        <hr>

       

    </div>
    <!-- /.container -->
<?php require_once TEMPLATE_FRONT.DS."footer.php"; ?>