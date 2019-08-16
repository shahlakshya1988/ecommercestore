<?php

function setMessage($msg){
	if(!empty($msg)){
		$_SESSION["message"] = $msg;
	}else{
		$msg="";
	}
}

function displayMessage(){
	if(isset($_SESSION["message"])){
		echo $_SESSION["message"];
		unset($_SESSION["message"]);
	}
}


function redirect($location){
	header("Location: {$location}");
	die();
}


/************** FRONT END FUNCTIONS *****************************/

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
					<a href="item.php?product_id={$row_product->product_id}"><img src="{$row_product->product_image}" alt="{$row_product->product_title}"></a>
					<div class="caption">
						<h4 class="pull-right">&#36;{$product_price}</h4>
						<h4><a href="item.php?product_id={$row_product->product_id}">{$row_product->product_title}</a>
						</h4>
						<!-- <p> </p> -->
						<a class="btn btn-primary"  href="../resources/cart.php?add={$row_product->product_id}">Add To Cart</a>
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

function get_products_in_cat_page($cat_id){
	global $db;
	$get_products_query = "SELECT * FROM `products` where `product_category_id` = :product_category_id";
	$get_products = $db->prepare($get_products_query);
	//print_r($db->errorInfo());
	$get_products->execute(array(":product_category_id"=>$cat_id));

	while($row_product = $get_products->fetch(PDO::FETCH_OBJ)):
	$category_product=<<<EOL
	<div class="col-md-3 col-sm-6 hero-feature">
		<div class="thumbnail">
			<img src="{$row_product->product_image}" alt="{$row_product->product_title}" class="image-responsive">
			<div class="caption">
				<h3>{$row_product->product_title}</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				<p>
					<a href="../resources/cart.php?add={$row_product->product_id}" class="btn btn-primary">Add To Card!</a> <a href="item.php?product_id={$row_product->product_id}" class="btn btn-default">More Info</a>
				</p>
			</div>
		</div>
	</div>
EOL;
echo $category_product;
	endwhile;

}



function get_products_in_shop_page(){
	global $db;
	$get_products_query = "SELECT * FROM `products`";
	$get_products = $db->prepare($get_products_query);
	//print_r($db->errorInfo());
	$get_products->execute();

	while($row_product = $get_products->fetch(PDO::FETCH_OBJ)):
	$category_product=<<<EOL
	<div class="col-md-3 col-sm-6 hero-feature">
		<div class="thumbnail">
			<img src="{$row_product->product_image}" alt="{$row_product->product_title}" class="image-responsive">
			<div class="caption">
				<h3>{$row_product->product_title}</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
				<p>
                <a href="../resources/cart.php?add={$row_product->product_id}" class="btn btn-primary">Add To Card!</a> <a href="item.php?product_id={$row_product->product_id}" class="btn btn-default">More Info</a>
				</p>
			</div>
		</div>
	</div>
EOL;
echo $category_product;
	endwhile;

}

function login_user(){
	global $db;
	if(isset($_POST["submit"])){
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$sel_user_query = "SELECT * FROM `users` where `username` = :username and `password` = :password";
		$sel_user = $db->prepare($sel_user_query);
		$sel_user->execute(array(":username"=>$username,":password"=>$password));
		if($sel_user->rowCount()){
			$_SESSION["username"] = $username;
			setMessage("Welcome Admin, {$username}");
			redirect("admin/index.php");
			die();
		}else{
			setMessage("Please Enter Proper Username and Password");
			redirect("login.php");
			die();
		}
	}
}


function sendMessage(){
    if(isset($_POST["submit"])){
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $subject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);
        $headers="From: {$name} {$email}";
        $to = "shahlakshya1988@gmail.com";
        $result = mail($to,$subject,$message,$headers);
        if(!$result){
            // echo "Error";
            setMessage("Sorry We Are Unable To Send Your Message");
        }else{
            // echo "Send";
            setMessage("Your Message Has Been Successfully Delivered");            
        }
        redirect("contact.php");
        die();

    }
}
/************** FRONT END FUNCTIONS *****************************/



/************** BACK END FUNCTIONS *****************************/
function display_orders(){
	global $db;
	$sql="SELECT * FROM `orders`";
	$get_orders = $db->prepare($sql);
	$get_orders->execute();
	while($row = $get_orders->fetch(PDO::FETCH_OBJ)){
		$delete_order = "../../resources/templates/back/delete_order.php?order_id=".$row->order_id;
		$order_tr = <<<ORDER
		<tr>
			<td>{$row->order_id}</td>
			<td>{$row->order_amount}</td>
			<td>{$row->order_transaction}</td>
			<td>{$row->order_currency}</td>
			<td>{$row->order_status}</td>
			<td><a class="btn btn-danger" href="{$delete_order}"><span class="glyphicon glyphicon-remove"></span></a></td>
		</tr>
ORDER;
echo $order_tr;
	}
}
/************** BACK END FUNCTIONS *****************************/
