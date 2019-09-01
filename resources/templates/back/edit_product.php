<?php edit_product(); 
if(isset($_GET["id"])){
  //getting product 
  $product_id = trim($_GET["id"]);
  $get_product_sql = "SELECT * FROM `products` where `product_id` = :product_id";
  $get_product = $db->prepare($get_product_sql);
  $get_product->bindParam(":product_id",$product_id);
  $get_product->execute();
  $fh_product = $get_product->fetch(PDO::FETCH_OBJ);
  // var_dump($fh_product);
  $product_title = $fh_product->product_title;
  $product_category_id = $fh_product->product_category_id;
  $product_description = $fh_product->product_description;
  $short_desc = $fh_product->short_desc;
  $product_image = $fh_product->product_image;
  $product_main_image = $fh_product->product_main_image; 
  $product_quantity = $fh_product->product_quantity;
  $product_price = $fh_product->product_price;
 
}

?>
<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Edit Product

</h1>
</div>
               


<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

  <div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_title" class="form-control" value="<?php echo $product_title; ?>">
    </div>


    <div class="form-group">
           <label for="product_description">Product Description</label>
      <textarea name="product_description" id="product_description" cols="30" rows="10" class="form-control"><?php echo $product_description ?></textarea>
    </div>
    <div class="form-group">
           <label for="short_desc">Short Description</label>
      <textarea name="short_desc" id="short_desc" cols="30" rows="10" class="form-control"><?php echo $short_desc; ?></textarea>
    </div>



    <div class="form-group row">

      <div class="col-xs-6">
        <label for="product_price">Product Price</label>
        <input type="number" name="product_price" id="product_price" class="form-control" size="60" value="<?php echo $product_price; ?>">
      </div>
      <div class="col-xs-6">
        <label for="product_quantity">Product Quantity</label>
        <input type="number" name="product_quantity" id="product_quantity" class="form-control" size="60" value="<?php echo $product_quantity; ?>" >
      </div>
    </div>




    
    

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="update" class="btn btn-primary btn-lg" value="Update">
    </div>


     <!-- Product Categories-->

    <div class="form-group">
         <label for="product_category">Product Category</label>
          <hr>
        <select name="product_category" id="product_category" class="form-control">
            <option value="">Select Category</option>
            <?php get_categories_add_product($product_category_id); ?>
        </select>


</div>





    <!-- Product Brands-->


   <?php /* <div class="form-group">
      <label for="product-title">Product Brand</label>
         <select name="product_brand" id="" class="form-control">
            <option value="">Select Brand</option>
         </select>
    </div> */ ?>


<!-- Product Tags -->


   <?php /* <div class="form-group">
          <label for="product-title">Product Keywords</label>
          <hr>
        <input type="text" name="product_tags" class="form-control">
    </div> */ ?>

    <!-- Product Image -->
    <div class="form-group">
        <label for="product_image">Product Image</label>
        <input type="file"  name="product_image" id="product_image">
        <br>
        <img src="../../resources/<?php  echo display_image($product_image); ?>" alt="" height="150">
      
    </div>
    <div class="form-group">
        <label for="product_main_image">Product Main Image</label>
        <input type="file"  name="product_main_image" id="product_main_image">
       <br>
        <img src="../../resources/<?php  echo display_image($product_main_image); ?>" alt="" height="150">
    </div>



</aside><!--SIDEBAR-->


    
</form>



                



            </div>
           