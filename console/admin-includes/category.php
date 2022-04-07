<?php

if($action == 'edit'){

	$row = $categoryObj->find($id);

}

if( isset($_POST['title']) ){
  
	if($action == 'add'){
	
		$categoryObj->add( $categoryObj->request() );
		redirect( 'account.php?page=categories' );
	
	} else {
	
		$categoryObj->updateCategory($id, $categoryObj->request());
		redirect( 'account.php?page=categories' );
	
	}

}

?>

<h1>CATEGORY</h1>

	<form class="form-horizontal" <?php if($action == 'add'){ print 'id="form"'; } ?> method="post" action="" enctype="multipart/form-data">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> CATEGORY</div>
						<div class="panel-body">

								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="title" id="title" value="<?php if(isset($row)){ print $row->title; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Sort Order</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="sort_order" id="sort_order" value="<?php if(isset($row)){ print $row->sort_order; } ?>">
									</div>
								</div>								
								
								<div class="form-group">
									<label class="col-md-4 control-label">SEO Friendly URL</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="seo_url" id="seo_url" value="<?php if(isset($row)){ print $row->seo_url; } ?>">
									</div>
								</div>



								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> <?= strtoupper($action) ?> CATEGORY </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

