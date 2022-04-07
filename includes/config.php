<?php

session_start();

require __DIR__. '/../vendor/autoload.php';

define('DOMAIN', 'http://localhost/ecommerce');
define('COMPANY_NAME', 'ECOMMERCE DEMO');
define('SALT', 'CJzPjG7InubiaSH92U6VYhM14ZNrrFdpoDyWxflTe0kcL5m3XsKAH8qREwvgQtOB');
define('SESSION', 'NWZdfRut39VyQrPIFKoa6XCg01M2jiSTGw7HLkHB8ArU5Ymx4lJDvbhszOpceqnE');
date_default_timezone_set('Europe/London');
define('DT', date('Y-m-d H:i:s'));
define('FILE', basename($_SERVER['SCRIPT_NAME']));

$databaseObj = new App\Helpers\Db;

$user = new App\User($databaseObj);

if( isset( $_SESSION['user_id'] ) ){

	$user->setUserId( $_SESSION['user_id'] );

}


if( ! isset( $_COOKIE['unique'] ) ){

	$uniqueid = uniqid('', true);
	setcookie('unique', $uniqueid, time()+15724800, '/');
	$user->setUniqueId( $uniqueid );
	
}else{

	$user->setUniqueId( $_COOKIE['unique'] );

}


$cartObj = new App\Cart( $user, $databaseObj );
$cartObj->setCartItems();
$cart_items = $cartObj->getCartItems();
$cartObj->setCountItems( $cart_items );
$count_cart_items = $cartObj->getCountItems();

$categoryObj = new App\Category( $databaseObj );
$categoryObj->setCategories();
$categories = $categoryObj->getCategories();


function redirect($url, $message = null, $type = null){

	if($message){

		$message = $type == 'e' ? App\Helpers\Tools::error($message) : App\Helpers\Tools::flash($message);

	}

header('Location: '.$url); exit;

}



$url = $_SERVER['REQUEST_URI'];
$slug = explode('/', $_SERVER['REQUEST_URI']);
$slug = $slug[count($slug)-1];


