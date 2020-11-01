<TABLE>
	<TR>
		<TH>User</TH>
		<TH>Item</TH>
		<TH>Created</TH>
		<TH>Modified</TH>
		<TH>Contacts</TH>
	</TR>
<?php foreach ($items as $item) { ?>
	<TR>
		<TD><A href="<?= $this->Url->build(['controller'=>"Users", 'action'=>"edit",$item->user->id], ['fullBase'=>true]) ?>"><?= h($item->user->alias) ?></A></TD>
		<TD><A href="<?= $this->Url->build(['controller'=>"Items", 'action'=>"view",$item->id], ['fullBase'=>true]) ?>"><?= h($item->title) ?></A></TD>
		<TD><?= h($item->created) ?></TD>
		<TD><?= h($item->created) ?></TD>
		<td><?= h($item->stat->contacts) ?></td>
	</TR>
<?php } ?>
</TABLE>