<?php require_once "../resources/config.php"; ?>
<?php require_once TEMPLATE_FRONT . DS . "header.php"; ?>
<!-- Page Content -->
<div class="container">

    <div class="row">
        <!-- categories goes here [sidenav] -->
        <?php require_once TEMPLATE_FRONT . DS . "sidenav.php"; ?>
        <!-- categories goes here [sidenav] -->


        <div class="col-md-9">

            <div class="row carousel-holder">
                <div class="col-md-12">
                    <!-- CAROSAL -->
                    <?php require_once TEMPLATE_FRONT . DS . "slider.php"; ?>
                    <!-- CAROSAL -->
                </div>

            </div>

            <div class="row">
                <?php
                get_products();
                ?>









                <?php /* <div class="col-sm-4 col-lg-4 col-md-4">
                        <h4><a href="#">Like this template?</a>
                        </h4>
                        <p>If you like this template, then check out <a target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">this tutorial</a> on how to build a working review system for your online store!</p>
                        <a class="btn btn-primary" target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">View Tutorial</a>
                    </div> */ ?>

            </div>
            <!-- div.row -->
        </div>

    </div>

</div>
<!-- /.container -->
<?php require_once TEMPLATE_FRONT . DS . "footer.php"; ?>