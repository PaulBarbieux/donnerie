<?php $this->assign('title', h($owner->alias)) ?>

<div class="col-sm-12">
	<IMG width="50" class="gravatar rounded float-left" style="background-image:url('<?= $this->Url->build("/img/gravatar/".strtoupper(substr($owner->alias,0,1)).".jpg") ?>');" src="http://www.gravatar.com/avatar/<?php echo md5($owner->username) ?>?s=50&d=blank">
	<H1><?= __("Les annonces de {0}" , h($owner->alias) ) ?></H1>
</div>
<div class="col-sm-12 grid">
	<?php foreach ($items as $item): ?>
	<A href="<?= $this->Url->build("/items/view/".$item->id) ?>" class="card grid-item" style="width:200px; ">
		<DIV class="card-header">
			<h2 class="card-title"><?= h($item->title) ?></h2>
		</DIV>
		<DIV class="card-block">
			Posté le <?= h($item->created->i18nFormat("d MMMM YY")) ?>
		</DIV>
		<DIV class="card-block">
			<DIV class="item-img">
				<IMG src="<?= $this->Url->build($item->image_1_url ? "/".$item->image_1_url : "/img/item-".$item->type."-no-image.jpg") ?>" class="img-fluid">
				<SPAN class="item-state <?= h($item->state) ?>"><?= h($item->category->title_fr) ?></SPAN>
			</DIV>
		</DIV>
		<DIV class="card-block">
			<P><?= nl2br(h($item->description)) ?></P>
		</DIV>
	</A>
	<?php endforeach; ?>
</div>