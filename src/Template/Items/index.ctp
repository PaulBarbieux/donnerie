<DIV class="col-12">
	<DIV class="d-flex justify-content-between">
		<H1><?= __('Items') ?></H1>
		<DIV>
			<?= $this->Html->link(__("Export Excel"), ['controller'=>"items", 'action'=>"excel"] , ['class'=>"btn btn-outline-primary"] ) ?>
		</DIV>
	</DIV>
</DIV>
<div class="col-12">
	<DIV class="card">
		<DIV class="card-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col"><?= $this->Paginator->sort('id') ?></th>
						<th scope="col"><?= $this->Paginator->sort('type') ?></th>
						<th scope="col"><?= $this->Paginator->sort('title') ?></th>
						<th scope="col"><?= $this->Paginator->sort('state') ?></th>
						<th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
						<th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
						<th scope="col"><?= $this->Paginator->sort('booked') ?></th>
						<th scope="col"><?= $this->Paginator->sort('created') ?></th>
						<th scope="col"><?= $this->Paginator->sort('modified') ?></th>
						<th scope="col">Contacts</th>
						<th scope="col" class="actions"><?= __('Actions') ?></th>
						<th scope="col">Maintenance</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$toDay = new DateTime();
					foreach ($items as $item):
						// Number of days old
						$diff = $item->modified->diff($toDay);
						$nbDays = $diff->format('%a');
						if ($nbDays >= 100) {
							$opacity = 1;
						} else {
							$opacity = "." . sprintf("%02d",$nbDays);
						} 
					?>
					<tr>
						<td><?= $this->Number->format($item->id) ?></td>
						<td><?= h($item->type) ?></td>
						<td><?= $this->Html->link($item->title, ['action' => 'view', $item->id]) ?></td>
						<td><?= h($item->state) ?></td>
						<td><?= (isset($categories[$item->category_id]) ?
									$this->Html->link($categories[$item->category_id], ['controller' => 'Items', 'action' => 'category', $item->category_id])
									: "Unknown!" )
							?></td>
						<td><?= $item->has('user') ? $this->Html->link($item->user->alias, ['controller' => 'Items', 'action' => 'user', $item->user->id]) : '' ?></td>
						<td><?= h($item->isBooked()) ?></td>
						<td><?= h($item->created) ?></td>
						<td><?= h($item->modified) ?></td>
						<td><?= isset($item->stat) ? h($item->stat->contacts) : "?" ?></td>
						<td class="actions">
							<?= $this->Html->link("", ['action' => 'edit', $item->id, $item->user->alias] , ['class'=>"fas fa-pencil-alt"]) ?>
							<?= $this->Form->postLink("", ['action' => 'delete', $item->id], 
								['confirm' => __('Êtes vous sûr de supprimer {0}?', $item->title) , 
								 'class'=>"text-danger fa fa-trash"]) ?>
						</td>
						<td><?php if ($item->isOutdated()) { ?>
								<a class="disabled" title="<?= __("Un avertissement a déjà été envoyé.") ?>"><i class="fas fa-paper-plane"></i></a>
								<span class="text-danger"><?= $nbDays ?></span>
							<?php } else {
								print $this->Html->link("", ['action' => 'outdate', $item->id, $item->user->alias] ,
									['confirm'=>__("Envoyer un email d'avertissement à l'annonceur ?"),
									 'class'=>"text-warning fas fa-paper-plane", 
									 'style'=>"opacity:".$opacity.";",
									 'title'=>__("Envoyer un avertissement à l'annonceur")]);
								print " ".$nbDays;
								} ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				<TFOOT>
					<TR>
						<TD colspan="10"><?= $this->element('paginator') ?></TD>
					</TR>
				</TFOOT>
			</table>
		</div>
	</div>
</div>
