<?php $this->assign('title', __("Identifiez-vous")) ?>

<div class="col-sm-12">
	<?= $this->Flash->render() ?>
</div>
<div class="col-sm-6">
	<?php
		$this->loadHelper('Form', [ 'templates' => 'app_form', ]); 
		$col = array('collabel' => "col-sm-3", 'colinput' => "col-sm-9");
	?>
	<H2><?= __("Identifiez-vous") ?></H2>
	<P class="alert alert-warning"><?= __("En vous connectant vous acceptez l'usage de cookies pour ce site.") ?></P>
	<?= $this->Form->create() ?>
    <?= $this->Form->input('username', array('label'=>"Email" , 'templateVars'=>$col)) ?>
    <?= $this->Form->input('password', array('label'=>"Mot de passe" , 'templateVars'=>$col)) ?>
	<?= $this->Form->submit(__('Se Connecter')); ?>
	<?= $this->element('robot-form-trap'); ?>
	<?= $this->Form->end() ?>
</div>
<div class="col-sm-6">
	<H2><?= __("Vous n'avez pas de compte ?") ?></H2>
	<P><?= $this->Html->link(__("Créer votre compte"), array('controller'=>"users", 'action'=>"register"), array('class'=>"btn btn-primary")); ?></P>
	<P>Ce site est ouvert aux habitants de Jette ou travailleurs dans la commune&nbsp;: son utilisation nécessite une inscription. Gratuite, bien entendu&nbsp;!</P>
</div>