
<div class="panel panel-default mb-50">
<div class="panel-heading"><i class="fa fa-home"></i> ACCOUNT | WELCOME <?= strtoupper($user->auth()->first_name); ?></div>
	<div class="panel-body">
		
		<div class="row mb-50 mt-50">

			
			<div class="col-md-4 mb-10"> <a class="btn btn-default full-width font-bigger" href="account?page=details"><i class="fa fa-user"></i> MY DETAILS</a> </div>
			
			<div class="col-md-4 mb-10"> <a class="btn btn-default full-width font-bigger" href="account?page=orders">MY ORDERS</a> </div>
			
			<div class="col-md-4 mb-10"> <a class="btn btn-default full-width font-bigger" href="account?page=change-password">CHANGE PASSWORD</a> </div>
		
		
		</div>
		
</div>
</div>