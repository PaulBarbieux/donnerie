<!DOCTYPE html>
<html lang="<?= substr($this->request->session()->read('Config.language'),0,2) ?>">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="<?= $this->Url->build("/favicon.ico") ?>">
    <title><?= $this->fetch('title')." | ".SITE_NAME ?></title>

    <!-- Bootstrap CSS -->
    <?= $this->Html->css(['bootstrap.css','style.css','font-awesome.min.css']) ?>
	<?= $this->Html->script(['jquery-3.2.1.min.js', 'tether.min.js', 'bootstrap.min.js', 'packery.pkgd.min.js', 'init.js']); ?>
	<!-- Packery -->
	<script type="text/javascript">
		jQuery('document').ready(function(){
			var $gridPackery = $('.grid').packery({
			  itemSelector: '.grid-item',
			  gutter: 10
			});
			setTimeout(function(){
				$gridPackery.packery('layout');
			},1000);
		});
	</script>

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
  </body>
</html>