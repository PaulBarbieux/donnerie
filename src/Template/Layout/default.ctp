<!DOCTYPE html>
<html lang="<?= LG ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="<?= $this->Url->build("/favicon.ico") ?>">
    <title><?= $this->fetch('title')." | ".SITE_NAME ?></title>
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('link') ?>
    <?= $this->Html->css(['bootstrap.min.css','style.css?20250517','branding.css']) ?>
	<?= $this->fetch('css') ?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
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