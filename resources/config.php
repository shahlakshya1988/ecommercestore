<?php 
ob_start();
if(session_status() == PHP_SESSION_NONE){
	session_start();
}
defined("DS") ? NULL : define("DS",DIRECTORY_SEPARATOR);
defined("TEMPLATE_FRONT") ? NULL : define("TEMPLATE_FRONT",__DIR__.DS."templates".DS."front");
defined("TEMPLATE_BACK") ? NULL : define("TEMPLATE_BACK",__DIR__.DS."templates".DS."back");
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
require "functions.php";
?>
