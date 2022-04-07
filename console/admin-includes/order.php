<?php

use App\Product;
use App\Order;
use App\OrderItem;

$productObj = new Product( $databaseObj );
$orderObj = new Order($databaseObj, $user);
$orderItemObj = new OrderItem($databaseObj);

$isAdmin = $user->auth()->user_role_id == 2 ? true : false;
	
	$row = $orderObj->find($id);
	
	if( $row->user_id != $user->auth()->id && ! $isAdmin ){
	
		/* Make sure order belongs to the customer */

		redirect( 'account.php?page=home', 'You are not authourised to view that page!', 'e' );

	}
	
	$user_row = $user->find($row->user_id);
	
	$orderItemObj->setOrderItems( $id );
	$query = $orderItemObj->getOrderItems();
	
	if( isset($_POST['status']) && $isAdmin & isset($id) ){

		$orderObj->updateStatus( $id, $_POST['status']);
		
		redirect( 'account.php?page=orders&status=New', 'The order status has been changed' );
	
	}

?>


					<form class="form-horizontal" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading"><?php if(!$isAdmin){ ?><a href="account?page=orders"><i class="fa fa-chevron-left"></i> BACK</a> | <?php } ?>VIEW ORDER</div>
						<div class="panel-body">
						
						<?php  if( $isAdmin ){  ?>								
						
								<div class="form-group">
									<label class="col-md-4 control-label">Status</label>
									<div class="col-md-6">
									<select class="form-control" name="status">
									<option value="New" <?php if(isset($row) && $row->status == 'New'){ print 'selected'; } ?>>New</option>
									<option value="Completed" <?php if(isset($row) && $row->status == 'Completed'){ print 'selected'; } ?>>Completed</option>
									<option value="Dispatched" <?php if(isset($row) && $row->status == 'Dispatched'){ print 'selected'; } ?>>Dispatched</option>
									<option value="Pending" <?php if(isset($row) && $row->status == 'Pending'){ print 'selected'; } ?>>Pending</option>
									<option value="Cancelled" <?php if(isset($row) && $row->status == 'Cancelled'){ print 'selected'; } ?>>Cancelled</option>
									</select>
									</div>
								</div>
								
						
						<?php } else { ?>
						
								<div class="form-group">
									<label class="col-md-4 control-label">Status</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print $row->status; } ?>
									</div>
								</div>
						
						<?php }  ?>
						
						
								<div class="form-group">
									<label class="col-md-4 control-label">Order Number</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print $row->order_number; } ?>
									</div>
								</div>
								
						
								<div class="form-group">
									<label class="col-md-4 control-label">Order Date</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print date('d/m/Y H:i', strtotime($row->created_at)); } ?>
									</div>
								</div>

						
								
								<div class="form-group">
									<label class="col-md-4 control-label">Shipping</label>
									<div class="col-md-6 pt-7">
										£<?= $row->shipping ?>
									</div>
								</div>								
								
								<div class="form-group">
									<label class="col-md-4 control-label">Total Cost</label>
									<div class="col-md-6 pt-7">
										£<?= $row->total_cost ?>
									</div>
								</div>


								<?php if($isAdmin){ ?>

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary mb-10"> EDIT STATUS <i class="fa fa-edit"></i></button>
									</div>
								</div>
								
								<?php } ?>
							
						</div>
					</div>
		
		
				</form>	

<?php

	$row = $user->find($row->user_id);

?>


						<div class="panel panel-default form-horizontal">
						<div class="panel-heading">CUSTOMER DETAILS</div>
						<div class="panel-body">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Customer Name</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print ucwords($row->first_name).' '.ucwords($row->last_name); } ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Address</label>
									<div class="col-md-6 pt-7">
<?php if(isset($row)){ print ucwords($row->address_1); } if(isset($row->address_2) && $row->address_2 != ''){ print ', '.ucwords($row->address_2); } print ', '.ucwords($row->town).', '.strtoupper($row->postcode); if(isset($row->country)){ print ', '.strtoupper($row->country); } ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Email</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print strtolower($row->email); } ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Phone</label>
									<div class="col-md-6 pt-7">
										<?php if(isset($row)){ print $row->phone; } ?>
									</div>
								</div>
							
						</div>
						</div>
				


						<div class="panel panel-default form-horizontal">
						<div class="panel-heading">ORDER DETAILS</div>
						<div class="panel-body">
						
						<?php $i = 0; foreach($query as $row){ ?>
						
							<?php if($i > 0){ print "<hr />"; } ?>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Product</label>
									<div class="col-md-6 pt-7">
										<?= $row->title ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Quantity</label>
									<div class="col-md-6 pt-7">
										<?= $row->quantity ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Individual Price</label>
									<div class="col-md-6 pt-7">
										<?= $row->price ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Image</label>
									<div class="col-md-6 pt-7">
										<?php
										
										$product = $productObj->find($row->product_id);
										
										$images = json_decode($product->images, true);
										
										?>
										
										<img width="150" src="<?= DOMAIN ?>/product-images/<?= $images[0] ?>">
										
									</div>
								</div>								

								
							<?php $i++; } ?>
							
						</div>
						</div>