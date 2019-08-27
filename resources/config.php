<?php
ob_start();
if(session_status() == PHP_SESSION_NONE){
	session_start();
}
defined("DS") ? NULL : define("DS",DIRECTORY_SEPARATOR);
defined("TEMPLATE_FRONT") ? NULL : define("TEMPLATE_FRONT",__DIR__.DS."templates".DS."front");
defined("TEMPLATE_BACK") ? NULL : define("TEMPLATE_BACK",__DIR__.DS."templates".DS."back");
defined("UPLOAD_DIR") ? NULL : define("UPLOAD_DIR",__DIR__.DS."uploads"); ;
defined("DBNAME") ? NULL : define("DBNAME","ecommercestore");
defined("DBHOST") ? NULL : define("DBHOST","localhost");
defined("DBUSER") ? NULL : define("DBUSER","root");
defined("DBPASS") ? NULL : define("DBPASS","");
try{
	$dsn = "mysql:host=".DBHOST.";dbname=".DBNAME;
	$db = new pdo($dsn,DBUSER,DBPASS);
}catch(Exception $e){
	echo $e->getMessage();
	die();
}

/*** IMAGE CHECK ARRAY ***/
$allowed_image_extension = ["jpg","gif","png","jpeg"];
$allowed_image_type =["image/jpg","image/png","image/gif","image/jpeg"];
$allowed_image_size = 10485760; //10mb
// var_dump($allowed_image_extension);
// var_dump($allowed_image_type);
/*** IMAGE CHECK ARRAY ***/
require "functions.php";
require_once "cart.php";
?>
