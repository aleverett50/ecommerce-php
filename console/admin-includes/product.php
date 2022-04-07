<?php

use App\Product;
$productObj = new Product( $databaseObj );


if($action == 'edit'){

	$row = $productObj->find($id);
	$categoriesArray = json_decode($row->category_id, true);
	$currentImages = json_decode($row->images, true);
	
}

if( isset($_POST['title']) ){

	if($action == 'add'){
	
		$_POST['category_id'] = json_encode($_POST['category_id']);
	
		$productObj->add( $productObj->request() );
		
		redirect( 'account.php?page=products' );
	
	} else {
	
		/* Check any uploaded files are valid first */
	
		$allowedFiles = ['image/jpeg', 'image/png'];
		
		if( ! $productObj->checkValidFiles( $_FILES , $allowedFiles ) ){
			
			redirect( $_SERVER['HTTP_REFERER'], 'You tried to upload an invalid file', 'e' );
		
		}
		
		$images = [];
		
		for($i = 1; $i < 3; $i++){
		
			if( $_FILES['file-'.$i]['size'] > 0 ){
			
				$ext = explode(".", $_FILES['file-'.$i]['name']);
				$ext = $ext[sizeof($ext)-1];
			
				$fileName = $i.'-'.time().'.'.$ext;
				
				/* If there is s new image, put it in the image array */
				
				$images[] = $fileName;
			
				move_uploaded_file($_FILES['file-'.$i]['tmp_name'], '../product-images/'.$fileName);

			
			}else{
			
				$currentImages[$i-1] = isset($currentImages[$i-1]) ? $currentImages[$i-1] : '';
				
				/* If no new image use current image field */
			
				$images[] = $currentImages[$i-1];
			
			}
		
		}
		

		$_POST['category_id'] = json_encode($_POST['category_id']);
		$_POST['images'] = json_encode($images);

		$productObj->updateProduct( $id, $productObj->request() );
		
		redirect( 'account.php?page=products' );
	
	}

}

?>

<script>

$(function(){

	$.get('account.php?page=product&action=add&get=sessions', function(data){
		
		var data = jQuery.parseJSON(data);
		
		$('#form input[type=text], #form input[type=email], #form textarea').each(function(){
			
			if (typeof data[this.id] !== 'undefined') {
			
				$('#' + this.id).val(data[this.id]);
				
			}
		
		});
		
		$('#form select').each(function(){
		
			$('#' + this.id + ' option[value='+data[this.id]+']').prop('selected', true);
		
		});

	});

});

</script>

<h1>PRODUCT</h1>


	<form enctype="multipart/form-data" <?php if($action == 'add'){ print 'id="form"'; } ?> class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?= strtoupper($action) ?> PRODUCT</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Title</label>
									<div class="col-md-6">
									<input autocomplete="off" type="text" class="form-control" name="title" id="title" value="<?php if(isset($row)){ print $row->title; } ?>">
									</div>
								</div>							
								
								<div class="form-group">
									<label class="col-md-4 control-label">Product URL</label>
									<div class="col-md-6">
									<input autocomplete="off" type="text" class="form-control" name="seo_url" id="seo_url" value="<?php if(isset($row)){ print $row->seo_url; } ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label"></label>
									<div class="col-md-6">
										<p>eg. your-product-name</p>
										<p>This should have a dash in between each word, no spaces</p>
									</div>
								</div>
								

								<div class="form-group">
									<label class="col-md-4 control-label">* Category</label>
									<div class="col-md-6" style="padding-top: 6px !important;">


										<?php
										
										foreach($categories as $category){
										
											$checked = isset($categoriesArray) && in_array($category->id, $categoriesArray) ? 'checked' : '';
										
											print '<input class="category_checkbox" autocomplete="off"  '.$checked.' id="category-'.$category->id.'" type="checkbox" name="category_id[]" value="'.$category->id.'"> <label style="margin-right:10px" for="category-'.$category->id.'">'.$category->title.' </label> ';
										
										}
										
										?>
										
										<br /><br />
						
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Price</label>
									<div class="col-md-6">
									<input autocomplete="off" type="text" class="form-control" name="price" id="price" value="<?php if(isset($row)){ print $row->price; } ?>">
									</div>
								</div>
								

								<div class="form-group">
									<label class="col-md-4 control-label">Special Offer Price</label>
									<div class="col-md-6">
									<input autocomplete="off" placeholder="Leave blank if not special offer" type="text" class="form-control" name="special_offer_price" id="special_offer_price" value="<?php if(isset($row)){ print $row->special_offer_price; } ?>">
									</div>
								</div>

								
								<div class="form-group">
									<label class="col-md-4 control-label">Description</label>
									<div class="col-md-6">
										
				<textarea class="form-control" rows="5" name="description" id="description"><?php  if(isset($row)){ print $row->description; } elseif(isset($_SESSION['description'])){ print $_SESSION['description']; } ?></textarea>
										
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="col-md-4 control-label">Image 1</label>
									<div class="col-md-6">
										
										<input class="form-control" name="file-1" type="file" />
										
										<?php
										
										if( isset( $currentImages[0] ) && $currentImages[0] != '' ){  ?>
										
										<br />
										<img width="100" src="../product-images/<?= $currentImages[0] ?>">
										<br /><br />
										
										<?php } ?>
										
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Image 2</label>
									<div class="col-md-6">
										
										<input class="form-control" name="file-2" type="file" />
										
										<?php
										
										if( isset( $currentImages[1] ) && $currentImages[1] != '' ){  ?>
										
										<br />
										<img width="100" src="../product-images/<?= $currentImages[1] ?>">
											
										<?php } ?>
										
									</div>
								</div>

<br /><br />
								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button <?php if($action == 'add'){ ?> id="submitButton" type="button" <?php } else { ?> type="submit" <?php } ?> class="btn btn-primary"> <?= strtoupper($action) ?> PRODUCT </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>		

