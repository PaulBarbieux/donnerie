<?php
$this->assign('title', $this->Paginator->counter(['format' => __('{{count}} annonces')]));
?>

<div class="col-sm-12 grid">
	<?php foreach ($items as $item): ?>
	<?= $this->element('grid-item', ['item'=>$item, 'category'=>false, 'user'=>false] ) ?>
	<?php endforeach; ?>
</div>
<div class="col-12 text-center">
	<DIV class="paginator">
		<UL>
			<?php
				if ($this->Paginator->hasPrev()) 
					echo $this->Paginator->prev('< ' . __('Annonces plus récentes'));
				if ($this->Paginator->hasNext()) 
					echo $this->Paginator->next(__('Annonces plus anciennes') . ' >');
			?>
		</UL>
	</DIV>
</div>
<div class="col-12 text-center page-load-status">
	<div class="infinite-scroll-request"><img src="<?= $this->Url->build("/img/infinite-scroll-loading.gif") ?>"></div>
	<div class="infinite-scroll-last">
		<div class="total-announces">
			<?= $this->Paginator->counter(['format' => __('Il y a {{count}} annonces')]) ?>
		</div>
	</div>
</div>