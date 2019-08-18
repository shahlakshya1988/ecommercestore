

             <div class="col-lg-12">

<h1 class="page-header">
   All Products

</h1>
<h3 class="bg-success text-center">
  <?php echo displayMessage(); ?>
</h2>
<table class="table table-hover">


    <thead>

      <tr>
           <th>Id</th>
           <th>Title</th>
           <th>Category</th>
           <th>Price</th>
           <th>Quantity</th>
      </tr>
    </thead>
    <tbody>

      <?php echo get_products_in_admin(); ?>
      


  </tbody>
</table>











                
                 


             </div>

           