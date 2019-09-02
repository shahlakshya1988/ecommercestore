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
			$product_image = "../resources/".display_image($row_product->product_image);

			$productString = <<<EOL
			<div class="col-sm-4 col-lg-4 col-md-4">
				<div class="thumbnail">
					<a href="item.php?product_id={$row_product->product_id}"><img src="{$product_image}" alt="{$row_product->product_title}"></a>
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
	$product_image = "../resources/".display_image($row_product->product_image);
	$category_product=<<<EOL
	<div class="col-md-3 col-sm-6 hero-feature">
		<div class="thumbnail">
			<img src="{$product_image}" alt="{$row_product->product_title}" class="image-responsive">
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
	$product_image = "../resources/".display_image($row_product->product_image);
	$category_product=<<<EOL
	<div class="col-md-3 col-sm-6 hero-feature">
		<div class="thumbnail">
			<img src="{$product_image}" alt="{$row_product->product_title}" class="image-responsive">
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

function display_image($picture){
	return "uploads".DS.$picture;
}

function get_products_in_admin(){
    global $db;
	//global $
    $sql="SELECT * FROM `products`";
    $get_products = $db->prepare($sql);
   $get_products->execute();
   // var_dump($get_products->errorInfo());

   $get_category_sql="SELECT * FROM `categories` where `cat_id` = :cat_id"; 
   $get_category = $db->prepare($get_category_sql); 
    while($fh_product = $get_products->fetch(PDO::FETCH_OBJ)){
        $get_category->execute(["cat_id"=>$fh_product->product_category_id]);
        $fh_category = $get_category->fetch(PDO::FETCH_OBJ);
        $delete_product = "../../resources/templates/back/delete_product.php?product_id=".$fh_product->product_id;
        $edit_product = "index.php?edit_product&id={$fh_product->product_id}";
		$productimage = "../../resources/".display_image($fh_product->product_image);
        $products=<<<EOL
        <tr>
            <td>{$fh_product->product_id}</td>
            <td>{$fh_product->product_title}<br>
                <a href="{$edit_product}"><img src="{$productimage}" alt="" style="height:100px;"></a>
            </td>
            <td>{$fh_category->cat_title}</td>
            <td>{$fh_product->product_price}</td>
            <td>{$fh_product->product_quantity}</td>
            <td> <a href="{$edit_product}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a> <a href="{$delete_product}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
EOL;
echo $products;
    }

    
}
function add_product(){
	global $allowed_image_extension;
	global $allowed_image_type;
	global $allowed_image_size;
	global $db;
	if(isset($_POST["publish"])){
		// var_dump($_FILES);
		// var_dump($_POST);

		$product_title = trim($_POST["product_title"]);
		$product_description = trim($_POST["product_description"]);
		$product_price = trim($_POST["product_price"]);
		$product_category = trim($_POST["product_category"]);
		$short_desc = trim($_POST["short_desc"]);
		$product_quantity = trim($_POST["product_quantity"]);
		
		$product_image = $_FILES["product_image"];
		$product_image_name = $_FILES["product_image"]["name"];
		$product_image_name_array  = explode(".",$product_image_name);
		$product_image_name_extension = strtolower(end($product_image_name_array));
		// var_dump($product_image_name_extension);

		$product_image_tmp_name = $_FILES["product_image"]["tmp_name"];
		$product_image_error = $_FILES["product_image"]["error"];
		$product_image_size = $_FILES["product_image"]["size"];
		$product_image_type= $_FILES["product_image"]["type"];

		$product_main_image = $_FILES["product_main_image"];
		$product_main_image_name = $_FILES["product_main_image"]["name"];
		$product_main_image_name_array = explode(".",$product_main_image_name);
		$product_main_image_extension = end($product_main_image_name_array);
		// var_dump($product_main_image_extension);

		$product_main_image_tmp_name = $_FILES["product_main_image"]["tmp_name"];
		$product_main_image_type = $_FILES["product_main_image"]["type"];
		$product_main_image_error = $_FILES["product_main_image"]["error"];
		$product_main_image_size = $_FILES["product_main_image"]["size"];

		/*** checking for image ***/
		// var_dump($allowed_image_extension);
		
		if(in_array($product_image_name_extension,$allowed_image_extension) && in_array($product_main_image_extension,$allowed_image_extension) && in_array($product_image_type,$allowed_image_type) && in_array($product_main_image_type,$allowed_image_type) && $product_main_image_error == 0 && $product_image_error == 0 ){
			$product_image_final_name = uniqid("",true).".{$product_image_name_extension}";
			$product_main_image_final_name = uniqid("",true).".{$product_main_image_extension}";
			//var_dump(UPLOAD_DIR.DS.$product_image_final_name);
			if(move_uploaded_file($product_image_tmp_name, UPLOAD_DIR.DS.$product_image_final_name) && move_uploaded_file($product_main_image_tmp_name, UPLOAD_DIR.DS.$product_main_image_final_name)){
				if(!empty(trim($product_title)) && !empty(trim($product_description)) && !empty(trim($product_price)) && $product_price>0 && !empty(trim($short_desc)) && !empty(trim($product_quantity)) && $product_quantity>0 ){
					$insert_query = "INSERT INTO `products`(`product_id`,`product_title`,`product_category_id`,`product_price`,`product_description`,`short_desc`,`product_image`,`product_main_image`,`product_quantity`) values (:product_id,:product_title,:product_category_id,:product_price,:product_description,:short_desc,:product_image,:product_main_image,:product_quantity)";
					$insert = $db->prepare($insert_query);
					$insert->execute(array(
						":product_id"=>NULL,
						":product_title"=>$product_title,
						":product_category_id"=>$product_category,
						":product_price"=>$product_price,
						":product_description"=>$product_description,
						":short_desc"=>$short_desc,
						":product_image"=>$product_image_final_name,
						":product_main_image"=>$product_main_image_final_name,
						":product_quantity"=>$product_quantity
					));
					//var_dump($insert->errorInfo());
					//var_dump($insert->rowCount());
					if($insert->rowCount()){
						setMessage("New Product With The ID :: {$db->lastInsertId()} Added Successfully");
						redirect("index.php?products");
					}

				}


			}
			


		}
		/*** checking for image ***/

	}
	if(isset($_POST["draft"])){

	}
}

function edit_product(){
	global $db;
	global $allowed_image_size;
	global $allowed_image_type;
	global $allowed_image_extension;
	
	if(isset($_POST["update"])){
		// echo "<pre>",print_r($_POST),"</pre>";
		$product_title = trim($_POST["product_title"]);
		$product_description = trim($_POST["product_description"]);
		$short_desc = trim($_POST["short_desc"]);
		$product_price = trim($_POST["product_price"]);
		$product_quantity = trim($_POST["product_quantity"]);
		$product_category = trim($_POST["product_category"]);
		$product_image = $_FILES["product_image"];
		$product_main_image = $_FILES["product_main_image"];
		$product_id = trim($_GET["id"]);
		
		// $product_image_final_name="";
		$img_name = $_FILES["product_image"]["name"];
		$img_size = $_FILES["product_image"]["size"];
		$img_tmp_name = $_FILES["product_image"]["tmp_name"];
		$img_errors = $_FILES["product_image"]["error"];
		$img_type = $_FILES["product_image"]["type"];

		$img_array = explode(".",$img_name);
		$img_extension = strtolower(end($img_array));

		if(in_array($img_type, $allowed_image_type) && in_array($img_extension, $allowed_image_extension) && $img_errors == 0){
			$image_final_name= uniqid('',true).".{$img_extension}";
			if(move_uploaded_file($img_tmp_name, UPLOAD_DIR.DS.$image_final_name)){
				$update_product_img_sql="UPDATE `products` SET `product_image` = :product_image where `product_id` = :product_id LIMIT 1";
				$update_product = $db->prepare($update_product_img_sql);
				$update_product->execute([
					":product_image"=>$image_final_name,
					":product_id"=>$product_id
				]);

			}
		}

		// $product_main_image_final_name="";
		$img_name = $_FILES["product_main_image"]["name"];
		$img_size = $_FILES["product_main_image"]["size"];
		$img_tmp_name = $_FILES["product_main_image"]["tmp_name"];
		$img_errors = $_FILES["product_main_image"]["error"];
		$img_type = $_FILES["product_main_image"]["type"];
		$img_array = explode(".",$img_name);
		$img_extension = strtolower(end($img_array));

		if(in_array($img_type, $allowed_image_type) && in_array($img_extension, $allowed_image_extension) && $img_errors == 0){
			$image_final_name= uniqid('',true).".{$img_extension}";
			if(move_uploaded_file($img_tmp_name, UPLOAD_DIR.DS.$image_final_name)){
				$update_product_img_sql="UPDATE `products` SET `product_main_image` = :product_main_image where `product_id` = :product_id LIMIT 1";
				$update_product = $db->prepare($update_product_img_sql);
				$update_product->execute([
					":product_main_image"=>$image_final_name,
					":product_id"=>$product_id
				]);

			}
		}

		$update_otherdata_sql="UPDATE `products` SET `product_title` = :product_title,
								`product_description` = :product_description, 
								`short_desc` = :short_desc,
								`product_price` = :product_price,
								`product_quantity` = :product_quantity,
								`product_category_id` = :product_category_id
								where `product_id` = :product_id LIMIT 1
								";
		$update_otherdata= $db->prepare($update_otherdata_sql);
		$update_otherdata->execute([
			":product_id"=>$product_id,
			":product_title"=>$product_title,
			":product_description"=>$product_description,
			":product_price"=>$product_price,
			":product_quantity"=>$product_quantity,
			":product_category_id"=>$product_category,
			":short_desc"=>$short_desc

		]);
		// echo "<pre>",print_r($_POST),"</pre>";
// var_dump($update_otherdata->errorInfo());
//die();


		setMessage("Product #{$product_id} Has Been Updated Successfully");
		redirect("index.php?products");
		
	}
	
}

function get_categories_add_product($product_category_id=null){
	global $db;
	$get_categories_sql="SELECT * FROM `categories`";
	$get_categories = $db->prepare($get_categories_sql);
	$get_categories->execute();
	while($fh_category = $get_categories->fetch(PDO::FETCH_OBJ)){
		$selected_string = ($product_category_id == $fh_category->cat_id) ? "selected" : "";
		$select_category=<<<EOL
		<option value="{$fh_category->cat_id}" {$selected_string}>{$fh_category->cat_title}</option>
EOL;
		echo $select_category;
	}
}
/************** BACK END FUNCTIONS *****************************/

/***** LIST CATEGORIES ADMIN ****/
function showCategoriesInAdmin(){
	global $db;
	$get_product_categories_sql = "SELECT * FROM `categories`";
	$get_product_categories = $db->prepare($get_product_categories_sql);
	$get_product_categories->execute();
	while($fh_product_categories = $get_product_categories->fetch(PDO::FETCH_OBJ)){
		$categories = <<<EOF
		<tr>
            <td>{$fh_product_categories->cat_id}</td>
            <td>{$fh_product_categories->cat_title}</td>
            <td><a href="index.php?categories&del={$fh_product_categories->cat_id}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
        </tr>
EOF;
echo $categories;
	}
}

function manage_categories(){
	global $db;
	if(isset($_POST["add_categories"])){
		$cat_title = trim($_POST["category_title"]);
		if($cat_title!=''){
			$cat_sql = "INSERT INTO `categories` (`cat_id`,`cat_title`) values(:cat_id,:cat_title)";
			$insert_cat = $db->prepare($cat_sql);
			$insert_cat->execute([
				":cat_id"=>null,
				":cat_title"=>$cat_title
			]);
			$last_cat_id = $db->lastInsertId();
		}
		setMessage("<div class='bg-success'>Category With {$cat_title}, #{$last_cat_id} Inserted</div>");
		redirect("index.php?categories");
	}
}

function delete_admin_category(){
	global $db;
	if(isset($_GET["del"])){
		$cat_id = trim($_GET["del"]);
		$cat_sql="DELETE FROM `categories` WHERE `cat_id` = :cat_id LIMIT 1";
		$del_cat = $db->prepare($cat_sql);
		$del_cat->execute([
			":cat_id" => $cat_id
		]);
		//var_dump($del_cat->errorInfo()); die();
		setMessage("<div class='bg-danger'>Category With #{$cat_id} is Removed</div>");
		redirect("index.php?categories");
	}
}
/***** LIST CATEGORIES ADMIN ****/


/**** listing of users ****/
function list_admin_users(){
	global $db;
	$list_users_sql = "SELECT * FROM `users`";
	$list_users = $db->prepare($list_users_sql);	
	$list_users->execute();
	while($fh_list_users = $list_users->fetch(PDO::FETCH_OBJ)){
        $image_path = "../../resources/".display_image($fh_list_users->photo);
		$userString= <<<EOL
		<tr>
		    <td>$fh_list_users->user_id</td>
		    <td><img src="{$image_path}" height="150"></td>
		    <td>$fh_list_users->username</td>
            <td>$fh_list_users->email</td>
            <td><a href="index.php?edit_user&edit_id={$fh_list_users->user_id}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></a></td>
		    <td><a href="index.php?users&del_user={$fh_list_users->user_id}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
		</tr>
EOL;
echo $userString;
	}
}
/**** listing of users ****/
/***** DELETING THE USER */
function deleteUser(){
    global $db;
    if(isset($_GET["del_user"])){
        $user_id = trim($_GET["del_user"]);
        $delete_user_sql="DELETE FROM `users` where `user_id` = :user_id ";
        $delete_user = $db->prepare($delete_user_sql);
        $delete_user->execute([
            "user_id"=>$user_id
        ]);
        if($delete_user->rowCount()){
            setMessage("<p class='bg-success'>User Has Been Succesfully Deleted</p>");
            redirect("index.php?users");
        }
    }
}
/***** DELETING THE USER */

/************* adding user */
function add_user(){
    global $db;
    global $allowed_image_extension;
    global $allowed_image_size;
    global $allowed_image_type;

    if(isset($_POST["submituser"])){
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $email = trim($_POST["email"]);

        $image_name = $_FILES["file"]["name"];
        $image_tmp_name = $_FILES["file"]["tmp_name"];
        $image_size = $_FILES["file"]["size"];
        $image_error = $_FILES["file"]["error"];
        $image_type = $_FILES["file"]["type"];
        $image_name_array = explode(".",$image_name);
        $image_extension = end($image_name_array);
        //var_dump(in_array($image_type,$allowed_image_type) && in_array($image_extension,$allowed_image_extension) && $image_error==0);
        //die();
        if(in_array($image_type,$allowed_image_type) && in_array($image_extension,$allowed_image_extension) && $image_error==0){
            $image_final_name = uniqid("",true).".{$image_extension}";
            $image_path=UPLOAD_DIR.DS.$image_final_name;
            //var_dump(move_uploaded_file($image_tmp_name,$image_path)); die();
            if(move_uploaded_file($image_tmp_name,$image_path)){
                
                $insert_sql = "INSERT INTO `users` (`user_id`, `username`, `password`, `email`,`photo`) value (:user_id,:username,:password,:email,:image_final_name)";
                $insert_user = $db->prepare($insert_sql);
                $insert_user->execute([
                    ":user_id"=>null,
                    ":username"=>$username,
                    ":password"=>$password,
                    ":email"=>$email,
                    ":image_final_name"=>$image_final_name
                ]);

            }

        }else{

            $insert_sql = "INSERT INTO `users` (`user_id`, `username`, `password`, `email`) value (:user_id,:username,:password,:email)";
            $insert_user = $db->prepare($insert_sql);
            $insert_user->execute([
                ":user_id"=>null,
                ":username"=>$username,
                ":password"=>$password,
                ":email"=>$email
            ]);
        }

      
        $lastInsertId = $db->lastInsertId();
        setMessage("<p class='bg-success'>User with id #{$lastInsertId} Has Been Successfully Created</p>");
        redirect("index.php?users");
    }

}
function edit_user(){
    global $db;
    global $allowed_image_size;
    global $allowed_image_extension;
    global $allowed_image_type;

    if(isset($_POST["submitEditUser"])){
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        $email = trim($_POST["email"]);
        $user_id = trim($_GET["edit_id"]);
        $image_name = $_FILES["file"]["name"];
        $image_tmp_name = $_FILES["file"]["tmp_name"];
        $image_size = $_FILES["file"]["size"];
        $image_error = $_FILES["file"]["error"];
        $image_type = $_FILES["file"]["type"];
        $image_name_array = explode(".",$image_name);
        $image_extension = end($image_name_array);
        //var_dump(in_array($image_type,$allowed_image_type) && in_array($image_extension,$allowed_image_extension) && $image_error==0);
        //die();
        if(in_array($image_type,$allowed_image_type) && in_array($image_extension,$allowed_image_extension) && $image_error==0){
            $image_final_name = uniqid("",true).".{$image_extension}";
            $image_path=UPLOAD_DIR.DS.$image_final_name;
            //var_dump(move_uploaded_file($image_tmp_name,$image_path)); die();
            if(move_uploaded_file($image_tmp_name,$image_path)){
                $update_photo_sql="UPDATE `users` SET `photo` = :image_final_name where `user_id` = :user_id";
                $update_photo= $db->prepare($update_photo_sql);
                $update_photo->execute(
                    [
                        ":image_final_name"=>$image_final_name,
                        ":user_id"=>$user_id
                    ]
                );
            }
        }



        $update_sql = "UPDATE users SET `username` = :username, `password` = :password, `email` = :email where `user_id` = :user_id";
        $update_user= $db->prepare($update_sql);
        $update_user->execute([
            ":user_id"=>$user_id,
            ":username"=>$username,
            ":password"=>$password,
            ":email"=>$email
        ]);

        setMessage("<p class='bg-success'>User with id #{$user_id} Has Been Updated Created</p>");
        redirect("index.php?users");
    }
}
/************* adding user */
