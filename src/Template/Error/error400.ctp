<?php
$this->assign('title', __("Erreur"));
?>
<DIV class="col-12">
	<P class="alert alert-warning">
		<?php if (LG == "nl") { ?>
		(nl) Aïe aïe aïe, on dirait bien que cette page n'existe pas !<BR>
		Si vous vouliez accéder à une annonce, il est probable qu'elle soit déjà retirée pas son propriétaire.
		<?php } else { ?>
		Aïe aïe aïe, on dirait bien que cette page n'existe pas !<BR>
		Si vous vouliez accéder à une annonce, il est probable qu'elle soit déjà retirée pas son propriétaire.
		<?php } ?>
	</P>
	<DIV class="text-center">
		<?= $this->Html->image('error-not-found.png', ['class' => 'img-fluid']); ?>
	</DIV>
</DIV>