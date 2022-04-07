<?php

require __DIR__.'/includes/config.php';

use App\Order;
use App\OrderItem;

$orderObj = new Order($databaseObj, $user);
$orderItemObj = new OrderItem($databaseObj);


if(isset($_SESSION['shipping'])){

	$cartObj->setShipping( $_SESSION['shipping'] );

}


if( isset($_POST['first_name']) ){
	
	if( $user->auth() ){
	
		/* Remove password and email from required fields if logged in */
	
		$rules = [ 'first_name' => 'required' , 'last_name' => 'required' ];
		$user->setRules($rules);
	
	}
	

	/* Validate checkout form */

	if( ! $user->validate() ){
	
		redirect( $_SERVER['HTTP_REFERER'] );
	
	}
	
	
	/* Get all customer field posts */
	
	$request = $user->request();
	
	
	if( ! $user->auth() ){
	
		/* If not logged in, swap the password for bcrypted password */
		
		$request['password'] = password_hash($request['password'], PASSWORD_DEFAULT);

		/* Add the user */
	
		$user = $user->add( $request );
	
	}else{
	
		/* If logged in, update the user */
	
		$user = $user->updateUser( $user->auth()->id , $request );
	
	}
	


	/* Reset $request array */
	
	$request = array();


	/* Set order values using cart items array set in config file */

	$cartObj->setSubTotal( $cart_items );

	$request['shipping'] = $cartObj->getShipping();
	$request['user_id'] = $user->id;
	$request['total_cost'] = number_format( $cartObj->total(), 2 );

	/* Add the order */

	$order = $orderObj->add($request);
	
	/* Update the order with the order number */
	
	$order_number = $order->id + 100000;
	
	$orderObj->updateRow('orders', ['order_number' => $order_number ], 'id = :id  ', [ 'id' => $order->id ] );
	
	
	/* Reset $request array */
	
	$request = array();
	
	/* Add the order items */
	
	foreach( $cart_items as $cart_item ){
	
		$request['order_id'] = $order->id;
		$request['product_id'] = $cart_item->product_id;
		$request['quantity'] = $cart_item->quantity;
		$request['price'] = $cart_item->cart_price;
		$request['title'] = $cart_item->title;
		
		$orderItemObj->add( $request );
		
	}
	
	exit('Order Complete');

}



$meta_title = COMPANY_NAME.' | Checkout';
include('header.php');

?>

	<div class="container mb-0 mt-30" style="">
			<div class="col-md-4 hidden-xs hidden-sm" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
			<div class="col-md-4 text-center">  <h1 class="mt-10"><i class="fa fa-shopping-basket"></i> CHECKOUT</h1> </div>
			<div class="col-md-4" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
	</div>

<form id="form" action="" method="post">

	<?php if( count( App\Helpers\Validation::errors() ) ){   ?>

	<div class="container mt-10 mb-30">
	
<?php require __DIR__.'/includes/flash-messages.php'; ?>
	
	</div>
	
	<?php } ?>


	<div class="container">

		<?php if( ! $user->auth() ){ ?>
	
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
			    <label for="email">* Email</label>
                                <input placeholder="* Email Address" type="text" class="form-control" name="email" id="email" value="">
                            </div>
                        </div>


                            <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="email">* Password</label>
                                    <input type="password" class="form-control" name="password" id="password" value="">
                                </div>
                            </div>


                    </div>
		    
		<?php } ?>

                    <h4 style="color:#333333">DELIVERY ADDRESS</h4>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <input placeholder="* First Name" type="text" class="form-control" name="first_name" id="first_name" value="<?= $user->auth()->first_name ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input placeholder="* Last Name" type="text" class="form-control" name="last_name" id="last_name" value="<?= $user->auth()->last_name ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input placeholder="Phone" type="text" class="form-control" name="phone" id="phone" value="<?= $user->auth()->phone ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">

                                <input placeholder="Address 1" type="text" class="form-control" name="address_1" id="address_1" value="<?= $user->auth()->address_1 ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input placeholder="Address 2" type="text" class="form-control" name="address_2" id="address_2" value="<?= $user->auth()->address_2 ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input placeholder="Town" type="text" class="form-control" name="town" id="town" value="<?= $user->auth()->town ?? '' ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input placeholder="Postcode" type="text" class="form-control" name="postcode" id="postcode" value="<?= $user->auth()->postcode ?? '' ?>">
                            </div>
                        </div>
			
			
			<br /><br />
                       




                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-default submit-button full-width" style="max-width: 300px;float: right;"> PAYMENT </button>
<br /><br /><br />
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


</form>
    

<?php include('footer.php'); ?>