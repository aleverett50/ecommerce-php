<script>
$(function(){
	screenHeight = $( document ).height();
	var p = $( "footer" );
	var bottom = p.position().top + p.outerHeight(true);
	if( screenHeight > bottom ){
		var diff = screenHeight - bottom + 0;
		$('footer').css({ 'margin-top' : diff + 'px' });
	}

		$('.same-height-footer').matchHeight();

});

function myFunction() {
    document.getElementById(".myDiv").style.flexGrow = "5";
}
</script>
<script>
    $('.product-item').matchHeight({byRow: false});
</script>
<footer class="container-fluid footer-fluid-bg no-padding pl-0 pr-0">

      <div class="container footer pb-40">

	<div class="row">

		<div class="col-md-6 col-sm-6 same-height-footer">

			<div class="site-map">
                <?php
                foreach ($categories as $category) {
                ?>

                    <li style="text-transform: uppercase;"><a href="<?= DOMAIN . "/" .  $category->seo_url ?>/"><?=  $category->title ?></a></li>

                    <?php
                    }
                    ?>

			</div>

		</div>
		

		<div class="col-md-6 col-sm-6 same-height-footer custom-col-1">

            <div class="footer-padding"></div>

            <div class="row">
                <div class="col-md-12" style="min-height: 30px !important;">
                    <div class="social-media fb pull-right ml-5"><a target="_blank" href="https://www.facebook.com/thehiddenwardrobe/"><i class="fab fa-facebook-f" style="color:white;position:relative;top:1px;"></i> </a> </div>
                    <div class="social-media fb pull-right"><a target="_blank" href="https://www.pinterest.co.uk/bellamy2011/"><i class="fab fa-pinterest" style="color:white;position:relative;top:1px;left:1px;"></i></a></div>

                    <div class="social-media fb pull-right"><a target="_blank" href="https://instagram.com/_hiddenwardrobe_?igshid=1ixuk21dz0ddm"><i class="fab fa-instagram" style="color:white;position:relative;top:1px;"></i></a></div>
                </div>
                <div class="col-md-12 mt-10">
                    <p class="text-right">
                        Copyright <?= date('Y') ?> <?= COMPANY_NAME ?> &copy;Web Design by <a href="https://www.wtstechnologies.co.uk/" target="_blank">WTS Technologies</a>
                    </p>
                </div>
            </div>


		</div>

	</div>

      </div>



	</footer>

</body>
</html>
