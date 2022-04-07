<?php

ob_start();

require __DIR__.'/../includes/config.php';

if( ! $user->auth() ){

	redirect( 'login', 'You must be logged in to view the account section', 'e' );

}

if( $user->auth()->user_role_id == 1  ){
	
	redirect( '../login.php', 'You are not authourised to view that page.', 'e' );

}



if(empty($_GET['page'])){ redirect('account.php?page=home'); }

$page = $_GET['page'];

if(isset($_GET['id'])){ $id = $_GET['id']; }
if(isset($_GET['action'])){ $action = $_GET['action']; }

if( isset($_GET['get']) ){

	$results = [];

	foreach($_SESSION as $key => $session){

		$results[$key] = $session;

	}


print json_encode($results); exit;

}

?>

<?php include(dirname(__FILE__).'/header.php'); ?>

<div class="container-fluid" style="padding-left:5%;padding-right:5%">

<?php require __DIR__.'/../includes/flash-messages.php'; ?>

		<?php

		switch($_GET['page']){


			case 'change-password':
			include('../includes/change-password.php');
			break;

			case 'products':
			include('admin-includes/products.php');
			break;

			case 'product':
			include('admin-includes/product.php');
			break;

			case 'categories':
			include('admin-includes/categories.php');
			break;

			case 'category':
			include('admin-includes/category.php');
			break;

			case 'orders':
			include('admin-includes/orders.php');
			break;

			case 'order':
			include('admin-includes/order.php');
			break;

			case 'error':
			include('admin-includes/error.php');
			break;

			default:
			include('admin-includes/home.php');

		}

		?>

</div>


<?php require __DIR__.'/footer.php'; ?>
