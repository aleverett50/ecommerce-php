<?php

$_GET['status'] = "All";

?>

<div class="panel panel-default mb-30">
<div class="panel-heading"><a href="account?page=home"><i class="fa fa-home"></i> ACCOUNT HOME</a> | MY ORDERS</div>
	<div class="panel-body">

<br />

<?php

include('console/admin-includes/orders.php');

?>

<br /><br />

</div>
</div>