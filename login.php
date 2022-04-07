<?php 

require __DIR__.'/includes/config.php';

if( isset($_POST['email']) ){

	$result = $user->login($_POST['email'], $_POST['password'], 1);
	
	if( ! $result ){
	
		redirect( 'login', 'Wrong login credentials', 'e' );
	
	} else {
	
		$_SESSION['user_id'] = $result->id;
		redirect( 'account.php?page=home', 'Logged in' );
	
	}

}

if( isset($_GET['log']) ){

	unset($_SESSION['user_id']);
	redirect( 'login', 'logged out' );

}

if($user->auth()){

	redirect( 'account' );

}

$meta_title = COMPANY_NAME.' | Login';
require __DIR__.'/header.php';

?>

	<div class="container mb-0 mt-30">
			<div class="col-md-4 hidden-xs hidden-sm" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
			<div class="col-md-4 text-center">  <h1 class="mt-10"><i class="fa fa-user"></i> LOGIN</h1> </div>
			<div class="col-md-4" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
	</div>

	<?php if( count(App\Helpers\Validation::errors()) || count(App\Helpers\Tools::flashes()) ){   ?>

	<div class="container mt-10 mb-10">
	
<?php require __DIR__.'/includes/flash-messages.php'; ?>
	
	</div>
	
	<?php } ?>

<div class="container pt-30 pb-50">
		
		<form class="form-horizontal form-light" id="form" method="post" action="">
			
					<div class="panel panel-default">
					<div class="panel-heading">PLEASE LOGIN TO YOUR ACCOUNT HERE</div>
						<div class="panel-body">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Email Address</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="email" name="email">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">Password</label>
									<div class="col-md-6">
										<input type="password" class="form-control" name="password">
									</div>
								</div>
								

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-default"> LOGIN </button>
										
									</div>
								</div>
							
						</div>
					</div>
			
		
		</form>
		

</div>

<?php require __DIR__.'/footer.php'; ?>