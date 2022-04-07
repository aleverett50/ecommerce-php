<?php

require __DIR__.'/includes/config.php';

if(strstr($url, 'product/')){

	/* If viewing a product details page */

	include('product-details-page.php');
	exit;

}else{

	/* If viewing a category page */

	$category_row = $categoryObj->getRowByFieldNotDeleted('seo_url', $slug);
	
	if( $category_row ){

		include('product-list.php');
		exit;

	}

}

/* If no matches show 404 page */

include('404.php');
