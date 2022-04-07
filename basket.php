<?php

require __DIR__.'/includes/config.php';

use App\Product;
$productObj = new Product( $databaseObj );


if(isset($_POST['cart_id'])){

	unset($_SESSION['shipping']);
	
	$cartObj->updateCart( $_POST['cart_id'], $_POST['quantity'] );
	
	redirect( $_SERVER['HTTP_REFERER'], 'The basket has been updated');

}


if(isset($_GET['delete'])){

	unset($_SESSION['shipping']);
	
	$cartObj->delete($_GET['delete']);
	
	redirect( $_SERVER['HTTP_REFERER'], 'The item has been deleted');

}

if(isset($_POST['shipping'])){	
	
	$_SESSION['shipping'] = $_POST['shipping'];
	
	redirect( $_SERVER['HTTP_REFERER'], 'Shipping has been updated' );

}



if(isset($_SESSION['shipping'])){

	$cartObj->setShipping( $_SESSION['shipping'] );

}


$shipping = $cartObj->getShipping();

$cartObj->setSubTotal($cart_items);

$meta_title = COMPANY_NAME.' | Shopping Basket';

require 'header.php';

?>

<script>

$(function(){

	$('#shipping').change(function(){
		
		let price = $(this).find(":selected").val();

            $('#shipping-form').submit();
	
	});


});

</script>

	<div class="container mb-0 mt-30">
			<div class="col-md-4 hidden-xs hidden-sm" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
			<div class="col-md-4 text-center">  <h1 class="mt-10"><i class="fa fa-shopping-basket"></i> SHOPPING BASKET</h1> </div>
			<div class="col-md-4" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
	</div>
	
	<?php if( count(App\Helpers\Validation::errors()) || count(App\Helpers\Tools::flashes()) ){   ?>

	<div class="container mt-10">
	
<?php require __DIR__.'/includes/flash-messages.php'; ?>
	
	</div>
	
	<?php } ?>

<div class="container pt-30 pb-50">

<?php if( ! $count_cart_items ){ ?>

<div class="panel panel-default">
<div class="panel-heading"><i class="fa fa-shopping-basket"></i> SHOPPING BASKET</div>
	<div class="panel-body">

<p>Your shopping basket is currently empty.</p>

</div>
</div>

<?php } else { ?>

					<div class="panel panel-default">
					<div class="panel-heading"><i class="fa fa-shopping-basket"></i> SHOPPING BASKET</div>
						<div class="panel-body">

	<div class="row mb-10 hidden-xs hidden-sm">
	
		<div class="col-md-1"> <strong>Product</strong> </div>
		<div class="col-md-1 col-md-offset-6"> <strong>Price</strong> </div>
		<div class="col-md-1"> <strong>Quantity</strong> </div>
		<div class="col-md-1"> <strong>Total</strong> </div>
	
	</div>
							
							<?php foreach( $cart_items as $row ){ 
							
							$product = $productObj->find($row->product_id);
										
							$images = json_decode($product->images, true);
				
							?>

	<div class="row mb-10">
	
		<div class="col-md-1 col-xs-3 col-sm-3">  <img src="product-images/<?= $images[0] ?>" alt="" class="img-responsive" /> </div>
		<div class="col-md-6 col-xs-6 col-sm-6">  

			<?= $row->title ?><br />

		</div>
		
		<form action="" method="post">
		
		<input type="hidden" name="cart_id" value="<?= $row->cart_id ?>">
		
		<div class="col-xs-3 visible-xs visible-sm">  <span class="symbol">£</span><span class="price" data-price=""><?= number_format($row->quantity * $row->cart_price, 2) ?></span> </div>
	 	
		<div class="col-md-1 hidden-xs hidden-sm"> <span class="symbol">£</span><span class="price" data-price="<?= $row->cart_price ?>"><?= $row->cart_price ?></span>  </div>
		
		<div class="col-xs-12 visible-xs visible-sm mt-10">Qty:</div>
		
		<div class="col-md-1 col-xs-3 col-sm-3">  <input style="border-radius:0" type="number" class="form-control text-center" name="quantity" value="<?= $row->quantity ?>"> </div>
		<div class="col-md-1 hidden-xs hidden-sm">  <span class="symbol">£</span><span class="price" data-price=""><?= number_format($row->quantity * $row->cart_price, 2) ?></span> </div>
		<div class="col-xs-6 visible-xs visible-sm"></div>
		<div class="col-md-2 col-xs-9 col-sm-9 text-right">
		
			<button title="Update" type="submit" class="btn btn-default btn-sm"><i class="fas fa-sync"></i></button>
			<a class="btn btn-default btn-sm white" title="Remove" href="basket.php?delete=<?= $row->cart_id ?>"><i class="fas fa-trash"></i></a>
		
		</div>
		
		</form>
	
	</div>
	

	<hr />
	
	<?php } ?>

	
	
	<div class="row"> 
	<div class="col-md-6"> 
	
		<div class="row">
		
			<div class="col-md-12">

				
				<form action="" method="post" id="shipping-form">
				<select class="form-control mb-20" name="shipping" id="shipping">
				
					<option value="" disabled>Please Select Your Shipping Method</option>

			<option value="3.99" <?php if($shipping == '3.99'){ print 'selected'; } ?>>£3.99 - Standard 2-3 Days Delivery – UK Only</option>
			<option value="6.99" <?php if($shipping == '6.99'){ print 'selected'; } ?>>£6.99 – Tracked Next Day Delivery – UK Only</option>
			<option value="5.99" <?php if($shipping == '5.99'){ print 'selected'; } ?>>£5.99 – Delivery Outside The UK</option>
			<option value="0.00" <?php if($shipping == '0.00'){ print 'selected'; } ?>>Free shipping - Order is over &pound;20.00</option>

				
				</select>

				</form>	


				
			</div>
		

		
		
		</div>
		
	
	</div> 
	
	<div class="col-md-6 text-right mb-10"><strong>Sub Total <span class="symbol">£</span><span class="price" data-price=""><?= number_format($cartObj->getSubTotal(), 2) ?></span></strong></div> 
	

	
	<?php if( $shipping == 'FREE' ){ $shipping = '0.00'; } ?>

	<div class="col-md-6"></div> 
	<div class="col-md-6 text-right mb-10"><strong>Shipping <span class="symbol">£</span><span class="price" data-price=""><?= number_format($shipping, 2) ?></span></strong></div> 

	<div class="col-md-6"></div> 
	<div class="col-md-6 text-right mb-10"><strong>Total <span class="symbol">£</span><span class="price" data-price=""><?= number_format($cartObj->total(), 2) ?></span></strong></div> 
	</div>
	
	<div class="col-md-6 pull-left col-xs-12 pr-0 pl-0 mt-20 visible-md visible-lg">
	
	<a href="<?= DOMAIN ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i> CONTINUE SHOPPING</a>
	
	</div>
	
	<div class="col-md-6 col-xs-12 pr-0 pl-0 mt-20">
	
	<a href="checkout" class="btn btn-default pull-right">CHECKOUT <i class="fa fa-chevron-right"></i></a>
	
	</div>
	
	</div>
	
	</div>

<?php } ?>



</div>



<?php require 'footer.php'; ?>