<?php

use App\Order;
$orderObj = new Order($databaseObj, $user);

if( ! isset($_GET['status']) ){
	redirect( 'account.php?page=orders&status=New' );
}


$isAdmin = $user->auth()->user_role_id == 2 ? true : false;


if( $isAdmin ){

	if( isset($_GET['search']) ){

		$orderObj->setSearchedOrders( $_GET['search'] );

	}else{

		$orderObj->setOrders( $_GET['status'] );

	}

}else{

	$orderObj->setCustomerOrders( $user->auth()->id );	

}


$query = $orderObj->getOrders();

if( $isAdmin ){

?>



<div class="row">

	<div class="col-md-2 col-xs-6">

<form id="status_form" action="" method="get"> <input type="hidden" name="page" value="orders"> <select class="form-control" id="status" name="status"> <option value="New" <?php if($_GET['status'] == 'New'){ print 'selected'; } ?>>New Orders</option> <option value="Completed" <?php if($_GET['status'] == 'Completed'){ print 'selected'; } ?>>Completed Orders</option> <option value="Dispatched" <?php if($_GET['status'] == 'Dispatched'){ print 'selected'; } ?>>Dispatched Orders</option> <option value="Pending" <?php if($_GET['status'] == 'Pending'){ print 'selected'; } ?>>Pending Orders (not paid)</option> <option value="Cancelled" <?php if($_GET['status'] == 'Cancelled'){ print 'selected'; } ?>>Cancelled Orders</option> </select> </form>

	</div>

	<form action="" method="get">

<div class="col-md-3 col-xs-6 mb-10"> <input type="hidden" name="page" value="orders"> <input type="hidden" name="status" value="<?= $_GET['status'] ?>"> <input placeholder="order number, surname ..." type="text" name="search" class="form-control" value="<?php if(isset($_GET['search'])){ print $_GET['search']; } ?>">  	</div>

	<div class="col-md-2 col-xs-12">  <button type="submit" class="btn btn-primary">SEARCH</button>   </div>

	</form>

</div>



<br />

<?php } ?>


<?php

if( count($query) ){

?>

<div class="table-responsive">

	<table class="table table-striped table-hover">

	<tr><td><strong>Date</strong></td><?php if( $_GET['status'] == 'Dispatched' &&  $isAdmin  ){ ?><td><strong>Date Dispatched</strong></td><?php } ?><?php if( $isAdmin ){ ?><td><strong>Customer</strong></td><?php } ?><td><strong>Status</strong></td><td><strong>Order Number</strong></td><td><strong>Total</strong></td><td width="250"><strong>Action</strong></td></tr>

	<?php

	foreach( $query as $row ){

	$status = $row->status;
	$cost = $row->total_cost;

		if(  $isAdmin  ){

			$name = ucwords($row->first_name).' '.ucwords($row->last_name);


			if(isset($_GET['status']) && $_GET['status'] == 'Dispatched' ){

			print '<tr><td>'.date('d/m/Y H:i', strtotime($row->order_date)).'</td><td>'.date('d/m/Y H:i', strtotime($row->dispatched_date)).'</td><td>'.$name.'</td><td>'.$status.'</td><td>'.$row->order_number.'</td><td>£'.number_format($cost, 2).'</td><td><a class="btn btn-primary" href="account.php?page=order&id='.$row->order_id.'">View <i class="fa fa-arrow-right"></i></a> <a onclick="return confirm(\'Are you sure you want to delete this order?\')" class="btn btn-primary" href="account.php?page=orders&action=delete&id='.$row->order_id.'">Delete <i class="fa fa-remove"></i></a></td></tr>';				

			} else {

			print '<tr><td>'.date('d/m/Y H:i', strtotime($row->order_date)).'</td><td>'.$name.'</td><td>'.$status.'</td><td>'.$row->order_number.'</td><td>£'.number_format($cost, 2).'</td><td><a class="btn btn-primary" href="account.php?page=order&id='.$row->order_id.'">View <i class="fa fa-arrow-right"></i></a> </td></tr>';

			}

		} else {

			print '<tr><td>'.date('d/m/Y H:i', strtotime($row->order_date)).'</td><td>'.$status.'</td><td>'.$row->order_number.'</td><td>£'.number_format($cost, 2).'</td><td><a class="btn btn-default" href="account.php?page=order&id='.$row->order_id.'">View <i class="fa fa-arrow-right"></i></a></td></tr>';

		}

	}

	?>

	</table>

</div>

<?php

} else {

	if(isset($_GET['search'])){

		print '<p>There are currently no orders for that search term.</p>';

	} else {

		print  $isAdmin  ? "<p>There are currently no ".strtolower($_GET['status'])." Orders.</p>" : "<p>There are currently no orders.</p>";

	}

}

?>
