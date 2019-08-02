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
					<a href="item.php?id={$row_product->product_id}"><img src="{$row_product->product_image}" alt="{$row_product->product_title}"></a>
					<div class="caption">
						<h4 class="pull-right">&#36;{$product_price}</h4>
						<h4><a href="item.php?id={$row_product->product_id}">{$row_product->product_title}</a>
						</h4>
						<!-- <p> </p> -->
						<a class="btn btn-primary" target="_blank" href="#">Add To Cart</a>
					</div>
				   
				</div>
			</div>
EOL;
echo $productString;
		 }
	}
}
/** this function will display the list of the products in home page public/index.php ***/

/***** fetching the categories for home page public/index.php ****/
function get_categories(){
	global $db;
	$select_category_query="SELECT * FROM `categories`";
	$select_category = $db->prepare($select_category_query);
	if($select_category->execute()){
		while($row_category = $select_category->fetch(PDO::FETCH_OBJ)){
			echo "<a href=\"category.php?cat_id={$row_category->cat_id}\" class=\"list-group-item\">{$row_category->cat_title}</a>";
		}
	} //if($select_category->execute())
}
/***** fetching the categories for home page public/index.php ****/

?>