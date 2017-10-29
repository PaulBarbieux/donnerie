<div class="col-sm-8">
    <H1><?= __('Streets') ?></H1>
</div>
<div class="col-sm-4 text-right">
	<A href="<?= $this->Url->build(['controller'=>"Streets", 'action'=>"add"]) ?>" class="btn btn-primary"><I class="fa fa-plus"></I> Ajouter</A>
</div>
<div class="col-sm-12">
	<DIV class="card">
		<DIV class="card-block">
			<TABLE class="table table-striped">
				<THEAD>
					<TR>
						<TH scope="col"><?= $this->Paginator->sort('id') ?></TH>
						<TH scope="col"><?= $this->Paginator->sort('name_fr') ?></TH>
						<TH scope="col"><?= $this->Paginator->sort('name_nl') ?></TH>
						<TH scope="col" class="actions"><?= __('Actions') ?></TH>
					</TR>
				</THEAD>
				<TBODY>
					<?php foreach ($streets as $street): ?>
					<TR>
						<TD><?= $this->Number->format($street->id) ?></TD>
						<TD><?= h($street->name_fr) ?></TD>
						<TD><?= h($street->name_nl) ?></TD>
						<TD class="actions">
							<?= $this->Html->link("", ['action' => 'edit', $street->id] , ['class'=>"fa fa-pencil"]) ?>
							<?= $this->Form->postLink("", ['action' => 'delete', $street->id], ['confirm' => __("Êtes-vous sûr de supprimer la rue {0} ?", $street->name_fr) , 'class'=>"fa fa-trash"]) ?>
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
