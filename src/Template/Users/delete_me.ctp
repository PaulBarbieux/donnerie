<?php
$this->assign('title', __("Supprimer mon compte"));
?>

<DIV class="col-sm-12">
	<H1><?= __("Supprimer mon compte") ?></H1>
</DIV>
<DIV class="col-md-6">
	<P class="alert alert-warning"><?= __("Toutes vos annonces seront supprimées en même temps que votre compte : cette action est irreversible.") ?></P>
</DIV>
<DIV class="col-md-6">
	<?= $this->Form->create($user) ?>	
		<?= __("Donnez votre mot de passe et confirmez la suppression de votre compte.") ?>
		<DIV class="input-group">
			<INPUT name="passwordDeleteMe" class="form-control" id="passworddeleteme" type="password">
			<DIV class="input-group-append">
				<BUTTON type="submit" value="send" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> <?= __("Confirmer") ?></BUTTON>
			</DIV>
		</DIV>
	<?= $this->Form->end() ?>
</DIV>