<?php $this->assign('title', __("Mes annonces")) ?>

<div class="col-sm-12">
	<H1><?= __("Mes annonces") ?></H1>
	<P><?= __("Voici vos annonces. Pensez à les supprimer quand elles ne sont plus d'actualité.") ?></P>
	<A href="<?= $this->Url->build(['controller'=>"Items", 'action'=>"add"]) ?>" class="btn btn-primary"><I class="fa fa-plus"></I> <?= __("Nouvelle annonce") ?></A>
	<BR>&nbsp;
</div>

<div class="col-sm-12 grid">
<?php foreach ($items as $item): ?>
	<DIV class="card grid-item item-<?= $item->type ?>" style="width:200px; ">
		<DIV class="card-header">
			<h2 class="card-title"><?= h($item->title) ?></h2>
		</DIV>
		<DIV class="card-body">
			<?= __("Posté le")." ".h($item->created->i18nFormat("d MMMM YYYY")) ?>
		</DIV>
		<DIV class="card-body">
			<DIV class="item-img">
				<?php if ($item->image_1_url) { ?>
				<IMG src="<?= $this->Url->build("/".$item->image_1_url) ?>" class="img-fluid">
				<?php } else { ?>
				<P class="alert alert-warning"><?= __("Pas d'image : image par défaut utilisée") ?></P>
				<?php } ?>
				<SPAN class="item-state <?= h($item->state) ?>"><?= h($item->category->title_fr) ?></SPAN>
			</DIV>
		</DIV>
		<DIV class="card-body">
			<P><?= nl2br(h($item->description)) ?></P>
		</DIV>
		<DIV class="block-actions">
			<DIV class="btn-group">
				<?= $this->Html->link(
					"", 
					['action' => 'edit', $item->id],
					['class' => 'btn btn-primary btn-sm fas fa-pencil-alt']
				) ?>
				<?= $this->Form->postLink(
					"", 
					['action' => 'delete', $item->id], 
					['confirm' => __('Êtes-vous sûr de supprimer {0} ?', $item->title) , 'class' => 'btn btn-danger btn-sm fa fa-trash']
				) ?>
			</DIV>
		</DIV>
	</DIV>
<?php endforeach; ?></div>