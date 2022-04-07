<?php

use App\Product;
$productObj = new Product( $databaseObj );

$productObj->setProducts( $page = 'byCategory', $category_row->id );

$query = $productObj->getProducts();

$title = $category_row->title;

require 'header.php';

?>

<div class="container-fluid" style="background-color:white;">

	<div class="container mb-0">
			<div class="">  <h3 class="mt-10"><?= strtoupper($title) ?></h3> </div>
	</div>

<div class="container pt-10 pb-30">

<?php if(!count($query)){ ?>

<p>There are no results for that query.</p>

<?php } ?>

	<div class="row">

		<?php foreach($query as $row){

		$images = json_decode($row->images, true);

		?>

		<div class="col-sm-4 col-md-4 col-xs-6 mb-20 product-item">

			<div class="thumbnail mb-0">

				<div class="same-height mb-10">
				<a href="<?= DOMAIN ?>/product/<?= $row->seo_url ?>">
				<img class="" style="width: 100%;" src="<?= DOMAIN ?>/product-images/<?= $images[0] ?>">
				</a>
				</div>

				<a class="prod-list-link" href="<?= DOMAIN ?>/product/<?= $row->seo_url ?>">
					<p class="mb-0 text-center para-height" style="text-transform:uppercase;"><?= $row->title ?></p>

					<p class="orange text-center">

					<strong>
					<?php

					if($row->special_offer_price){

						print '<span class="red"><strike>£'.$row->price.'</strike></span> £'.$row->special_offer_price;

					}else{

						print '£'.$row->price;

					}

					?>
					</strong>

					</p>
				</a>
			</div>


		</div>

		<?php } ?>


	</div>


</div>

</div>

<?php require 'footer.php'; ?>
