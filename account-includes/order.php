<?php

if(!isset($_GET['id']) || ( isset($_GET['id']) && $_GET['id'] == '' ) ){

	return redirect( 'account.php?page=home', 'There was an error with your page URL', 'e' );

}

$id = $_GET['id'];

include('console/admin-includes/order.php');