<?php
function redirect($location){
	header("Location: {$location}");
	die();
} 


/** this function will display the list of the products in home page public/index.php ***/
function get_products(){
	global $db;
	$get_product_query = "SELECT * FROM `products`";
	$get_product = $db->prepare($get_product_query);
	if($get_product->execute()){
		while($row_product = $get_product->fetch(PDO::FETCH_OBJ)){
			$product_price = number_format($row_product->product_price,2);
			
			$productString = <<<EOL
			<div class="col-sm-4 col-lg-4 col-md-4">
				<div class="thumbnail">
					<img src="{$row_product->product_image}" alt="{$row_product->product_title}">
					<div class="caption">
						<h4 class="pull-right">{$product_price}</h4>
						<h4><a href="product.html">{$row_product->product_title}</a>
						</h4>
						<!-- <p> </p> -->
						<a class="btn btn-primary" target="_blank" href="http://maxoffsky.com/code-blog/laravel-shop-tutorial-1-building-a-review-system/">View Tutorial</a>
					</div>
				   
				</div>
			</div>
EOL;
echo $productString;
		 }
	}
}
/** this function will display the list of the products in home page public/index.php ***/
?>