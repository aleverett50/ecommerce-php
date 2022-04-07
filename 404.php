<?php

$meta_title = COMPANY_NAME.' | Page Not Found';
require 'header.php';

?>

	<div class="container mb-0 mt-30">
			<div class="col-md-4 hidden-xs hidden-sm" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
			<div class="col-md-4 text-center">  <h1 class="mt-10">OOPS...</h1> </div>
			<div class="col-md-4" style="border-bottom:2px dotted #311E26"> &nbsp;  </div>
	</div>

<div class="container pt-30 pb-30">

<p class="text-center mb-50">Sorry, the page you requested does not exist</p>

<div class="col-md-4 col-md-offset-4">
<a class="btn btn-default center-block" href="<?= DOMAIN ?>/">HOME PAGE</a>
</div>


</div>


<?php require 'footer.php'; ?>