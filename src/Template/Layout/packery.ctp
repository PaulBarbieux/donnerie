<!DOCTYPE html>
<html lang="<?= LG ?>">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="<?= $this->Url->build("/favicon.ico") ?>">
    <title><?= $this->fetch('title')." | ".SITE_NAME ?></title>

    <?= $this->Html->css(['bootstrap.min.css','style.css?2018022','branding.css','font-awesome.min.css']) ?>
	<?= $this->Html->script(['jquery-3.2.1.min.js', 'tether.min.js', 'bootstrap.min.js?20180220', 'imagesloaded.pkgd.min.js', 'packery.pkgd.min.js', 'init.js']); ?>
	<!-- Packery -->
	<script type="text/javascript">
		jQuery('document').ready(function(){
			var $gridPackery = $('.grid').packery({
			  itemSelector: '.grid-item',
			  gutter: 0
			});
			// layout Packery after each image loads
			$gridPackery.imagesLoaded().progress( function() {
				$gridPackery.packery();
			});
		});
	</script>
	
	<?php
	// Infinite scroll on announces
	if (HOME_INFINITE_SCROLL) {
		echo $this->Html->script(['infinite-scroll.pkgd.min.js', 'items-infinite.js?20180819']);
	}
	?>
	
  </head>
  <body>
  
    <?= $this->element('header') ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
  				<?= $this->Flash->render() ?>
			</div>
		</div>
		<div class="row">
    		<?= $this->fetch('content') ?>
		</div>
	</div>
	<?= $this->element('footer') ?>

  </body>
</html>