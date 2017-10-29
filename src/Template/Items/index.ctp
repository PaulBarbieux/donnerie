<div class="col-sm-12">
    <h1><?= __('Items') ?></h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image_1_url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image_2_url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('image_3_url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $this->Number->format($item->id) ?></td>
                <td><?= h($item->type) ?></td>
                <td><?= $this->Html->link($item->title, ['action' => 'view', $item->id]) ?></td>
                <td><?= h($item->state) ?></td>
                <td><?= (isset($categories[$item->category_id]) ?
							$this->Html->link($categories[$item->category_id], ['controller' => 'Categories', 'action' => 'view', $item->category_id])
							: "Unknwown!" )
					?></td>
                <td><?= h($item->image_1_url) ?></td>
                <td><?= h($item->image_2_url) ?></td>
                <td><?= h($item->image_3_url) ?></td>
                <td><?= $item->has('user') ? $this->Html->link($item->user->alias, ['controller' => 'Items', 'action' => 'user', $item->user->id]) : '' ?></td>
                <td><?= h($item->created) ?></td>
                <td><?= h($item->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link("", ['action' => 'edit', $item->id, $item->user->alias] , ['class'=>"fa fa-pencil"]) ?>
                    <?= $this->Form->postLink("", ['action' => 'delete', $item->id], ['confirm' => __('Êtes vous sûr de supprimer {0}?', $item->title) , 'class'=>"fa fa-trash"]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
		<TFOOT>
			<TR>
				<TD colspan="11"><?= $this->element('paginator') ?></TD>
			</TR>
		</TFOOT>
    </table>
</div>
