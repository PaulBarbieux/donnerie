<?php $this->assign('title', h($category->title_fr)) ?>

<div class="col-sm-12">
	<H1><?= __("Les annonces de catégorie {0}", $category->title_fr) ?></H1>
</div>
<div class="col-sm-12 grid">
	<?php foreach ($items as $item): ?>
	<A href="<?= $this->Url->build(['controller'=>"Items", 'action'=>"view",$item->id]) ?>" class="card grid-item item-<?= $item->type ?>" style="width:200px; ">
		<DIV class="card-header">
			<h2 class="card-title"><?= h($item->title) ?></h2>
		</DIV>
		<DIV class="card-block">
			<IMG width="25" class="gravatar" style="background-image:url('<?= $this->Url->build("/img/gravatar/".strtoupper(substr($item->user->alias,0,1)).".jpg") ?>');" src="http://www.gravatar.com/avatar/<?php echo md5($item->user->username) ?>?s=25&d=blank">
			<?= h($item->user->alias) ?> le <?= h($item->created->i18nFormat("d MMMM YY")) ?>
		</DIV>
		<DIV class="card-block">
			<DIV class="item-img">
				<IMG src="<?= $this->Url->build( ($item->image_1_url ? "/".$item->image_1_url : "/img/item-".$item->type."-no-image.jpg") ) ?>" class="img-fluid">
				<SPAN class="item-state <?= h($item->state) ?>"></SPAN>
			</DIV>
		</DIV>
		<DIV class="card-block">
			<P><?= nl2br(h($item->description)) ?></P>
		</DIV>
	</A>
	<?php endforeach; ?>
</div>