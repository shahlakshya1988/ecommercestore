
        <div class="col-md-12">
            <div class="row">
                <h1 class="page-header">
                All Orders

                </h1>
            </div>

            <div class="row">
                <div class="col-lg-12 bg-success text-center">
                    <?php displayMessage();?>
                </div>
                <table class="table table-hover">
                    <thead>

                        <tr>
                            <th>Id</th>
                            <th>Amount</th>
                            <th>Trasaction</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo display_orders(); ?>

                    </tbody>
                </table>
            </div>
            <!-- div.row -->

        </div>
        