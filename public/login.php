<?php require_once "../resources/config.php"; ?>
<?php require_once TEMPLATE_FRONT.DS."header.php"; ?>
    <!-- Page Content -->
    <div class="container">

      <header>
            <h1 class="text-center">Login</h1>
            <h3 class="text-center"><?php displayMessage(); ?></h3>
        <div class="col-sm-4 col-sm-offset-5">
            <form class="" action="" method="post" enctype="multipart/form-data">
                <?php login_user(); ?>
                <div class="form-group"><label for="username">
                    username<input type="text" name="username" id="username" class="form-control" required></label>
                </div>
                 <div class="form-group"><label for="password">
                    Password<input type="password" name="password" id="password" class="form-control" required></label>
                </div>

                <div class="form-group">
                  <input type="submit" name="submit" class="btn btn-primary" >
                </div>
            </form>
        </div>


    </header>


        </div>

    </div>
    <!-- /.container -->
<?php require_once TEMPLATE_FRONT.DS."footer.php"; ?>
