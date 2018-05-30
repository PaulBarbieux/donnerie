<DIV class="col-sm-12">
	<DIV class="d-flex justify-content-between">
		<h1><?= __('Export emails en CSV') ?></h1>
		<DIV>
			<?= $this->Html->link(__("Retour à la liste des utilisateurs"), array('controller'=>"users", 'action'=>"index"), array('class'=>"btn btn-outline-primary")) ?>
		</DIV>
	</DIV>
</DIV>
<DIV class="col-md-6">
	<DIV class="card">
		<DIV class="card-body">
			<H2><?= __("Francophones") ?></H2>
			<P>Copier-coller le contenu de cette zone dans les <STRONG>destinataires cachés (CCI)</STRONG> de votre email en français.</P>
			<TEXTAREA class="form-control" rows="10"><?php
				foreach ($users_fr as $user) {
					print $user->username."; ";
				}
				?>
			</TEXTAREA>
		</DIV>
	</DIV>
</DIV>
<DIV class="col-md-6">
	<DIV class="card">
		<DIV class="card-body">
			<H2><?= __("Néerlandophones") ?></H2>
			<P>Copier-coller le contenu de cette zone dans les <STRONG>destinataires cachés (CCI)</STRONG> de votre email en néerlandais.</P>
			<TEXTAREA class="form-control" rows="10"><?php
				foreach ($users_nl as $user) {
					print $user->username."; ";
				}
				?>
			</TEXTAREA>
		</DIV>
	</DIV>
</DIV>