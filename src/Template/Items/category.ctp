<?php $this->assign('title', h($category->title_fr)) ?>

<div class="col-sm-12">
	<H1><?= __("Les annonces de catégorie {0}", $category->title_fr) ?></H1>
</div>
<div class="col-sm-12 grid">
	<?php foreach ($items as $item): ?>
	<?= $this->element('grid-item', ['item'=>$item, 'category'=>$category->title_fr, 'user'=>false] ) ?>
	<?php endforeach; ?>
</div>