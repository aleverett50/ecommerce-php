<?php

if( isset($_POST['old_password']) ){

	$result = $user->login($user->auth()->email, $_POST['old_password'], $user->auth()->user_role_id);
	
	if( ! $result ){
	
		redirect( $_SERVER['HTTP_REFERER'], 'The old password you entered was incorrect', 'e' );
	
	} else {

		$new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
		$user->updateRow('users', ['password' => $new_password ], 'id = :id  ', [ 'id' => $user->auth()->id ] );
		
		redirect( $_SERVER['HTTP_REFERER'], 'The password has been changed' );

	}

}

?>

		<?php if(  $user->auth()->user_role_id == 1 ){ ?>

<h1 class="mt-40 mt-40-mob">CHANGE PASSWORD</h1>

<hr />
		    
		<?php } ?>

	<form class="form-horizontal form-light" method="post" action="">

						<div class="panel panel-default">
						<div class="panel-heading">CHANGE PASSWORD</div>
						<div class="panel-body">
						
								<div class="form-group">
									<label class="col-md-4 control-label">Old Password</label>
									<div class="col-md-6">
										<input type="password" class="form-control" name="old_password">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-4 control-label">New Password</label>
									<div class="col-md-6">
										<input type="password" class="form-control" name="password">
									</div>
								</div>
								

								<div class="form-group">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary"> CHANGE PASSWORD </button>
									</div>
								</div>
							
						</div>
					</div>
		
		
	</form>



		
	