<?php edit_user();
if (isset($_GET["edit_id"])) {
    $user_id = trim($_GET["edit_id"]);
    $get_user_sql = "SELECT * FROM `users` where `user_id` = :user_id";
    $get_user = $db->prepare($get_user_sql);
    $get_user->execute([
        ":user_id" => $user_id
    ]);
    $fh_user = $get_user->fetch(PDO::FETCH_OBJ);

    $username = $fh_user->username;
    $email = $fh_user->email;
    $password = $fh_user->password;
    $photo = "../../resources/" . display_image($fh_user->photo);
}

?>
<h1 class="page-header">
    Edit User
    <small>Edwin</small>
</h1>

<div class="col-md-6 user_image_box">

    <a href="#" data-toggle="modal" data-target="#photo-library"><img class="img-responsive" src="<?php echo $photo; ?>" alt=""></a>

</div>


<form action="" method="post" enctype="multipart/form-data">




    <div class="col-md-6">

        <div class="form-group">

            <input type="file" name="file" class="form-control">

        </div>


        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">

        </div>
        <div class="form-group">
            <label for="username">Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">

        </div>

        <?php /* <div class="form-group">
                                <label for="first name">First Name</label>
                            <input type="text" name="first_name" class="form-control"  >
                               
                           </div>

                            <div class="form-group">
                                <label for="last name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" >
                               
                           </div> */ ?>


        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">

        </div>

        <div class="form-group">

            <!-- <a id="user-id" class="btn btn-danger" href="">Delete</a> -->

            <input type="submit" name="submitEditUser" class="btn btn-primary pull-right" value="Update">

        </div>




    </div>



</form>