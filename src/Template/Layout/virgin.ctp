<!DOCTYPE html>
<html lang="<?= LG ?>">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="<?= $this->Url->build("/favicon.ico") ?>">
    <title><?= $this->fetch('title')." | ".SITE_NAME ?></title>

    <!-- Bootstrap CSS -->
    <?= $this->Html->css(['bootstrap.min.css','style.css?20181028','branding.css']) ?>
	<?= $this->fetch('css') ?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
	<?= $this->Html->script(['jquery-3.2.1.min.js', 'tether.min.js', 'bootstrap.min.js?20180220', 'init.js']); ?>
	<?= $this->fetch('script') ?>

  </head>
  <body>
  
  <?= $this->fetch('content') ?>

  </body>
</html>