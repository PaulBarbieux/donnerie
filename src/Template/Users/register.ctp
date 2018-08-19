<?php
$this->assign('title', __("Inscrivez-vous"));

$this->loadHelper('Form', [ 'templates' => 'app_form_inline', ]); 		// Set FORM on bootstrap style
$col = array('collabel' => "col-sm-4", 'colinput' => "col-sm-8");		// Alignement between labels and inputs
?>

<div class="col-sm-12">
	<H1><?= __("Inscrivez-vous") ?></H1>
	<P><?= __("L'inscription est nécessaire pour poster des annonces") ?><?php if (!PUBLIC_CONTACT) echo __(" et contacter les annonceurs") ?>.
	   <?= __("Seul votre pseudonyme sera visible par les utilisateurs du site.") ?>
	<P><?= __("En vous inscrivant, vous vous engagez à respecter ") . $this->Html->link(__("notre charte"), ['controller'=>"pages", 'action'=>"charter"], ['target' => '_blank']) ?>.</P>
    <?= $this->Form->create($user) ?>
        <?php
			echo $this->Form->control('alias' , [ 'label'=>__("Pseudonyme") , 'placeholder' => __("Le nom montré publiquement") , 'templateVars'=>$col ] );
            echo $this->Form->control('username' , [ 'type'=>"email" , 'label'=>__("Email") , 'templateVars'=>$col ]);
            echo $this->Form->control('password' , [ 'label'=>__("Mot de passe") , 'templateVars'=>$col ]);
            echo $this->Form->control('password2' , [ 'type'=>"password" , 'label'=>__("Confirmez le mot de passe") , 'templateVars'=>$col ]);
			echo $this->Form->control('street' , [ 'label'=>__("Rue") ,  'empty'=>__("(choisissez)") , 'templateVars'=>$col ]);
			echo $this->Form->control('language' , ['type' => 'radio', 'label'=>__("Langue") , 'templateVars'=>$col , 'default'=>LG ,
							'options' => ['fr'=>__("Français"), 'nl'=>__("Nederlands")] ]);
			echo $this->element('robot-form-trap');
        ?>
	<DIV class="form-check form-check-inline">
	  <INPUT class="form-check-input" type="checkbox" name="accept" id="accept" value="1" required>
	  <LABEL class="form-check-label" for="accept">
	  	<?php if (LG == "fr") { ?>
	  	J’ai lu et accepte la <A href='<?= $this->Url->build("/pages/privacy") ?>' target="_blank">politique de confidentialité</A> de ce site.
		<?php } else { ?>
		Ik heb het <A href='<?= $this->Url->build("/pages/privacy") ?>' target="_blank">privacy beleid</A> van deze site gelezen en goedgekeurd.
		<?php } ?>
	  </LABEL>
	</DIV>
	<BR>
	<IMG class="waiting-animation" src="<?= $this->Url->build("/img/loading.gif") ?>" style="display: none;">
	<?= $this->Form->submit(__('Envoyer'), ['templateVars'=> ['text'=>__('Envoyer'), 'icon'=>'<I class="fa fa-paper-plane"></I>'] ]); ?>
    <?= $this->Form->end() ?>
</div>