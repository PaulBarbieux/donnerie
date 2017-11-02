<?php $this->assign('title', h($category->title_fr)) ?>

<div class="col-sm-12">
	<H1><?= __("Les annonces de catégorie {0}", $category->title) ?></H1>
</div>
<div class="col-sm-12 grid">
	<?php foreach ($items as $item): ?>
	<?= $this->element('grid-item', ['item'=>$item, 'category'=>$category->title, 'user'=>false] ) ?>
	<?php endforeach; ?>
</div>