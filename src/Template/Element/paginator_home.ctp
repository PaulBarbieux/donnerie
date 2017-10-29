<DIV class="paginator">
	<UL>
		<LI><?= $this->Paginator->counter(['format' => __('{{count}} annonces')]) ?></LI>
		<?= $this->Paginator->first('<< ' . __('first')) ?>
		<?= $this->Paginator->prev('< ' . __('previous')) ?>
		<?= $this->Paginator->next(__('next') . ' >') ?>
		<?= $this->Paginator->last(__('last') . ' >>') ?>
	</UL>
</DIV>
