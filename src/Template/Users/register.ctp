<?php
$this->assign('title', __("Inscrivez-vous"));

$this->loadHelper('Form', [ 'templates' => 'app_form_inline', ]); 		// Set FORM on bootstrap style
$col = array('collabel' => "col-sm-4", 'colinput' => "col-sm-8");		// Alignement between labels and inputs
?>

<div class="col-lg-8 col-md-10 col-sm-12">
	<H1><?= __("Inscrivez-vous") ?></H1>
	<P><?= __("L'inscription est nécessaire pour poster des annonces et contacter des annonceurs. Seul votre pseudonyme sera visible par les utilisateurs du site.") ?></P>
    <?= $this->Form->create($user) ?>
        <?php
			echo $this->Form->control('alias' , [ 'label'=>__("Pseudonyme") , 'placeholder' => __("Le nom montré publiquement") , 'templateVars'=>$col ] );
            echo $this->Form->control('username' , [ 'type'=>"email" , 'label'=>__("Email") , 'templateVars'=>$col ]);
            echo $this->Form->control('password' , [ 'label'=>__("Mot de passe") , 'templateVars'=>$col ]);
            echo $this->Form->control('password2' , [ 'type'=>"password", 'label'=>__("Confirmez le mot de passe") , 'templateVars'=>$col ]);
			echo $this->Form->control('street' , [ 'label'=>__("Rue") ,  'empty'=>__("(choisissez)") , 'templateVars'=>$col ]);
			echo $this->Form->control('language' , ['type' => 'radio', 'label'=>__("Langue") , 'templateVars'=>$col , 
							'options' => ['fr'=>__("Français"), 'nl'=>__("Nederlands")] ]);
        ?>
    <?= $this->Form->submit	(__('Envoyer')) ?>
    <?= $this->Form->end() ?>
</div>