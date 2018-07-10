<div class="col-sm-8">
    <H1><?= __('Categories') ?></H1>
</div>
<div class="col-sm-4 text-right">
	<A href="<?= $this->Url->build(['controller'=>"Categories", 'action'=>"add"]) ?>" class="btn btn-primary"><I class="fa fa-plus"></I> Ajouter</A>
</div>
<div class="col-12">
	<DIV class="card">
		<DIV class="card-body">
			<TABLE class="table table-striped">
				<THEAD>
					<TR>
						<TH scope="col"><?= $this->Paginator->sort('id') ?></TH>
						<TH scope="col"><?= $this->Paginator->sort('title_fr') ?></TH>
						<TH scope="col"><?= $this->Paginator->sort('description_fr') ?></TH>
						<TH scope="col"><?= $this->Paginator->sort('title_nl') ?></TH>
						<TH scope="col"><?= $this->Paginator->sort('description_nl') ?></TH>
						<TH scope="col"><?= __("Items") ?></TH>
						<TH scope="col" class="actions"><?= __('Actions') ?></TH>
					</TR>
				</THEAD>
				<TBODY>
					<?php foreach ($categories as $category): ?>
					<TR>
						<TD><?= $this->Number->format($category->id) ?></TD>
						<TD><?= h($category->title_fr) ?></TD>
						<TD><?= h($category->description_fr) ?></TD>
						<TD><?= h($category->title_nl) ?></TD>
						<TD><?= h($category->description_nl) ?></TD>
						<TD><?= $this->Html->link(h(count($category->items)), ['controller' => 'Items', 'action' => 'category', $category->id]) ?></TD>
						<TD class="actions">
							<?= $this->Html->link("", ['action' => 'edit', $category->id] , ['class'=>"fa fa-pencil"]) ?>
							<?php if (count($category->items) == 0) { ?>
							<?= $this->Form->postLink("", ['action' => 'delete', $category->id], ['confirm' => __("Êtes-vous sûr de supprimer la catégorie {0} ?", $category->title_fr) , 'class'=>"fa fa-trash"]) ?>
							<?php } else { ?>
							<A class="disabled" title="<?= __("Suppression interdite : il y a des annonces pour cette catégorie.") ?>"><I class="fa fa-trash"></I></A>
							<?php } ?>
						</TD>
					</tr>
					<?php endforeach; ?>
				</TBODY>
				<TFOOT>
					<TR>
						<TD colspan="6"><?= $this->element('paginator') ?></TD>
					</TR>
				</TFOOT>
			</TABLE>
		</DIV>
	</DIV>
</div>
