<?php 
require_once "../../resources/config.php"; 
require_once TEMPLATE_BACK.DS."header.php";
?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

               <?php 
               if( $_SERVER["REQUEST_URI"] == "/ecommercestore/public/admin/" || $_SERVER["REQUEST_URI"] == "/ecommercestore/public/admin/index.php" ){
                    require_once TEMPLATE_BACK.DS."admin_content.php";
               }

               if(isset($_GET["orders"])){
                    require_once TEMPLATE_BACK.DS."orders.php";
               }
               ?>

                

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php require_once TEMPLATE_BACK.DS."footer.php" ?>
