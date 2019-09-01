<?php delete_admin_category(); manage_categories(); ?>   

<h1 class="page-header">
  Product Categories

</h1>


<div class="col-md-4">
    
    <form action="" method="post">
    
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" class="form-control" name="category_title" required>
        </div>

        <div class="form-group">            
            <input type="submit" class="btn btn-primary" name="add_categories" value="Add Category">
        </div>      


    </form>


</div>


<div class="col-md-8">
   <?php echo displayMessage(); ?>
    <table class="table">
            <thead>

        <tr>
            <th>id</th>
            <th>Title</th>
            <th>Action</th>
        </tr>
            </thead>


    <tbody>
        <?php showCategoriesInAdmin(); ?>
    </tbody>

        </table>

</div>



                











