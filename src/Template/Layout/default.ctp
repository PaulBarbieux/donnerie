<!DOCTYPE html>
<html lang="<?= LG ?>">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="<?= $this->Url->build("/favicon.ico") ?>">
    <title><?= $this->fetch('title')." | ".SITE_NAME ?></title>

    <!-- Bootstrap CSS -->
    <?= $this->Html->css(['bootstrap.css','style.css','branding.css','font-awesome.min.css']) ?>
	<?= $this->fetch('css') ?>
	<?= $this->Html->script(['jquery-3.2.1.min.js', 'tether.min.js', 'bootstrap.min.js', 'init.js']); ?>
	<?= $this->fetch('script') ?>

  </head>
  <body>
  
  	<?= $this->element('header') ?>
	<div class="container">
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