<?php
$this->assign('title', __("Mot de passe oublié"));

$this->loadHelper('Form', [ 'templates' => 'app_form_inline', ]); 		// Set FORM on bootstrap style
$col = array('collabel' => "col-sm-4", 'colinput' => "col-sm-8");		// Alignement between labels and inputs

if (!isset($inputCode)) {
	$inputCode = false; // First pass
}
?>

<div class="col-12">
	<H1><?= __("Mot de passe oublié") ?></H1>
	<?php if (LG == "fr") { ?>
	<P>Cette page vous permet de renouveler votre mot de passe avec une procédure par email, suite à un oubli.</P>
	<P>Si vous voulez changer votre mot de passe pour une autre raison, nous vous conseillons de <?= $this->Html->link("vous connecter", array('controller'=>"users", 'action'=>"login")); ?> et de le changer dans votre profil.</P>
	<?php } else { ?>
	<P>Cette page vous permet de renouveler votre mot de passe avec une procédure par email, suite à un oubli.</P>
	<P>Si vous voulez changer votre mot de passe pour une autre raison, nous vous conseillons de <?= $this->Html->link("vous connecter", array('controller'=>"users", 'action'=>"login")); ?> et de le changer dans votre profil.</P>
	<?php } ?>
    <?= $this->Form->create() ?>
        <?php
            echo $this->Form->control('username' , [ 'type'=>"email" , 'label'=>__("Votre email") , 'templateVars'=>$col , 'readonly'=>$inputCode ]);
			echo $this->Form->control('street' , [ 'label'=>__("Votre rue") , 'empty'=>__("(choisissez)") , 'templateVars'=>$col , 'readonly'=>$inputCode ]);
			if ($inputCode) {
		?>
			<P class="alert alert-info">
				<?php if (LG == "fr") { ?>Veuillez copier-coller le code reçu par email et encoder un nouveau de passe.<?php } else { ?>
				Veuillez copier-coller le code reçu par email et encoder un nouveau de passe.<?php } ?>
			</P>
		<?php
				echo $this->Form->control('resetcode' , [ 'label'=>__("Code reçu par email") ,'templateVars'=>$col ]);
				echo $this->Form->control('password' , [ 'label'=>__("Nouveau mot de passe") , 'templateVars'=>$col ]);
				echo $this->Form->control('password2' , [ 'type'=>"password" , 'label'=>__("Confirmez le nouveau mot de passe") , 'templateVars'=>$col ]);
			}
			echo $this->element('robot-form-trap');
        ?>
	<IMG class="waiting-animation" src="<?= $this->Url->build("/img/loading.gif") ?>" style="display: none;"> 
	<?= $this->Form->submit(__('Envoyer'), ['templateVars'=> ['text'=>__('Envoyer'), 'icon'=>'<I class="fa fa-paper-plane"></I>'] ]); ?>
    <?= $this->Form->end() ?>
</div>