<?php

use App\Product;

$productObj = new Product( $databaseObj );

$row = $productObj->getRowByFieldNotDeleted('seo_url', $slug);

if( isset($_POST['product_id']) ){

	$_POST['cart_price'] = $row->price;

	$cartObj->add( $cartObj->request() );
	
	redirect($_SERVER['HTTP_REFERER'], 'The product has been added to your basket');

}

$meta_title =  COMPANY_NAME . ' | '.$row->title;

require('header.php');


?>

	<?php if( count(App\Helpers\Validation::errors()) || count(App\Helpers\Tools::flashes()) ){   ?>

	<div class="container mt-30">

<?php require __DIR__.'/includes/flash-messages.php'; ?>

	</div>

	<?php } ?>


    <div  class="container mt-10 mb-60">
        <div class="row justify-content-center">
            <div class="col-sm-11 pl-1 pr-1">
            <ul class="breadcrumb mb-10 hidden-xs">
                <li><a href="<?= DOMAIN ?>/"><i class="fa fa-home"></i> Home</a></li>
                <li><?= $row->title ?></li>
            </ul>
            </div>
	    
	<div class="row">

	<div class="col-sm-7">
	
	<?php
	
	$images = json_decode($row->images, true);
	
	?>
	
	<img alt="" class="img-responsive" src="../product-images/<?= $images[0] ?>">
	
	</div>
   
            <div class="col-sm-5 left-block-padding">

                        <form action="" method="post">
                            <input type="hidden" name="product_id" value="<?= $row->id ?>" />


                        <div class="row  pl-15 pr-15 ">
                            <h1 class="" style="font-size: 26px;font-weight: 500 !important;" id="name"><?= $row->title ?></h1>
                            <p style="font-weight: 600 !important;">

                                <?= '£'.$row->price ?> <br /><br />


                            <select name="quantity" class="form-control mb-10" style="max-width: 100px;border-radius: 5px;padding: 10px;height: 40px !important;">

                                <option value="1">QTY - 1</option>
                                <?php
                                $max = $row->qty_available > 10 ? 10 : $row->qty_available;
                                for($i = 2; $i < $max +1; $i++){

                                    print '<option value="'.$i.'">'.$i.'</option>';

                                }

                                ?>

                            </select>
                            <button type="submit" style="border: none;background: #e1ceb0;max-width: 225px;width:100%;padding: 4.5px;height: 50px">ADD TO CART</button>
			
			</form>

		</div>
		
		
	</div>
	
	
</div>



 <?php require('footer.php'); ?>