<?php $this->assign('title', h($owner->alias)) ?>

<div class="col-sm-12">
	<IMG width="50" class="gravatar rounded float-left" style="background-image:url('<?= $this->Url->build("/img/gravatar/".strtoupper(substr($owner->alias,0,1)).".jpg") ?>');" src="http://www.gravatar.com/avatar/<?php echo md5($owner->username) ?>?s=50&d=blank">
	<H1><?= __("Les annonces de {0}" , h($owner->alias) ) ?></H1>
</div>
<div class="col-sm-12 grid">
	<?php foreach ($items as $item): ?>
	<?= $this->element('grid-item', ['item'=>$item, 'category'=>false, 'user'=>h($owner->alias)] ) ?>
	<?php endforeach; ?>
</div>