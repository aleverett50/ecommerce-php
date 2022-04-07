<?php

use App\Product;
$productObj = new Product( $databaseObj );

$productObj->setProducts( $page = 'admin' );

$query = $productObj->getProducts();

if(isset($action)){

	$productObj->updateRow('products', ['deleted_at' => DT ], 'id = :id  ', [ 'id' => $id ] );
	redirect( $_SERVER['HTTP_REFERER'], 'The product was deleted' );

}


?>

<h1>PRODUCTS</h1>



<?php

if( count($query) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Title</strong></td><td><strong>SEO Friendly URL</strong></td><td><strong>Category</strong></td><td width="270px"><strong>Action</strong></td></tr>

	<?php

	foreach( $query as $row ){
	
	$categories_list = '';
	$category_json = json_decode($row->category_id);
	foreach($category_json as $category_id){
		$categories_list .= '['.$categoryObj->find($category_id)->title.']<br />';

	}

	print '<tr><td>'.$row->title.'</td><td>/'.$row->seo_url.'</td><td>'.$categories_list.'</td><td><a class="btn btn-primary" href="account.php?page=product&action=edit&id='.$row->id.'">Edit <i class="fa fa-edit"></i></a> <a onclick="return confirm(\'Are you sure you want to delete this product?\')" class="btn btn-primary" href="account.php?page=products&action=delete&id='.$row->id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';

	}

	?>

	</table>

</div>

<?php

} else { print "<p>There are currently no ".$page." for that request. <br /><br /><br /><br /><br /><br /><br /><br /></p>"; }

?>