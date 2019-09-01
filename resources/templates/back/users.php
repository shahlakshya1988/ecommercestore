<?php deleteUser(); ?>


<div class="col-lg-12">


    <h1 class="page-header">
        Users

    </h1>
    <?php displayMessage(); ?>

    <a href="add_user.php" class="btn btn-primary">Add User</a>


    <div class="col-md-12">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Photo</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php list_admin_users(); ?>
            </tbody>
        </table>
        <!--End of Table-->


    </div>











</div>