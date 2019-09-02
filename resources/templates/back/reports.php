<?php delete_reports(); ?>
<div class="col-lg-12">

    <h1 class="page-header">
        All Reports

    </h1>
    <h3 class="bg-success text-center">
        <?php echo displayMessage(); ?>
        </h2>
        <table class="table table-hover">


            <thead>

                <tr>
                    <th>Id</th>
                    <th>Order Id</th>
                    <th>Product Title</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php echo get_reports_in_admin(); ?>



            </tbody>
        </table>















</div>