<DIV class="col-sm-12">
    <h1><?= __('Users') ?></h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('alias') ?></th>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role') ?></th>
                <th scope="col"><?= $this->Paginator->sort('street') ?></th>
                <th scope="col"><?= $this->Paginator->sort('language') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col">Announces</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Html->link($user->alias, ['controller'=>"items", 'action'=>"user", $user->id]) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->role) ?></td>
                <td><?= h($user->street) ?></td>
                <td><?= h($user->language) ?></td>
                <td><?php switch ($user->status) {
					case "" : echo "active"; break;
					case "banned" : echo "banned"; break;
					default :
						if (strpos($user->status,"waitForConfirm") === false) {
							echo $user->status;
						} else {
							echo "waiting"; break;
						}
					} ?>
				</td>
                <td><?= h($user->created) ?></td>
                <td><?= h($user->modified) ?></td>
				<td><?= count(h($user->items)) ?></td>
                <td class="actions">
                    <?= $this->Html->link("", ['action' => 'edit', $user->id] , ['class'=>"fa fa-pencil"]) ?>
                    <?= $this->Form->postLink("", ['action' => 'delete', $user->id], ['confirm' => __('Êtes-vous sûr de supprimer {0} ?', $user->username) , 'class'=>"fa fa-trash"]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
		<TFOOT>
			<TR>
				<TD colspan="9"><?= $this->element('paginator') ?></TD>
			</TR>
		</TFOOT>
    </table>
</DIV>
