<?php
$this->assign('title', __("Accueil"));
?>

<div class="col-sm-12 grid">
	<?php foreach ($items as $item): ?>
	<?= $this->element('grid-item', ['item'=>$item, 'category'=>false, 'user'=>false] ) ?>
	<?php endforeach; ?>
</div>
<div class="col-12 text-center">
	<DIV class="paginator">
		<UL>
			<LI><?= $this->Paginator->counter(['format' => __('Il y a {{count}} annonces')]) ?></LI>
			<?php
				if ($this->Paginator->hasPrev()) 
					echo $this->Paginator->prev('< ' . __('Annonces plus récentes'));
				if ($this->Paginator->hasNext()) 
					echo $this->Paginator->next(__('Annonces plus anciennes') . ' >');
			?>
		</UL>
	</DIV>
</div>