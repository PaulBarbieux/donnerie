<?php
$this->assign('title', __("Mon profil"));

$this->loadHelper('Form', [ 'templates' => 'app_form_inline', ]);
$col = array('collabel' => "col-md-4", 'colinput' => "col-md-8");
?>

<div class="col-md-12">
	<H1><?= __("Mon profil") ?></H1>
</div>
<div class="col-md-8">
	<DIV class="card">
		<DIV class="card-block">
			<?= $this->Form->create($user) ?>
				<?php
					echo $this->Form->control('alias' , [ 'label'=>"Pseudonyme" , 'placeholder' => "Le nom que le public verra" , 'templateVars'=>$col ] );
					echo $this->Form->control('username' , [ 'type'=>"email" , 'label'=>"Email" , 'templateVars'=>$col ]);
					echo $this->Form->control('street' , [ 'label'=>"Rue" , 'empty'=>__("(choisissez)") , 'templateVars'=>$col ]);
					echo $this->Form->control('language' , ['type' => 'radio', 'label'=>__("Langue") , 'templateVars'=>$col , 
									'options' => ['fr'=>__("Français"), 'nl'=>__("Nederlands")] ]);
				?>
				<P class="form-text text-muted">
				  <?= __("Si vous voulez changer votre mot de passe, encodez deux fois le nouveau. Laissez ces zones vides si vous ne voulez pas le changer.") ?>
				</p>
				<?php
					echo $this->Form->control('passwordNew' , [ 'type'=>"password", 'label'=>__("Mot de passe") , 'templateVars'=>$col ]);
					echo $this->Form->control('passwordConfirm' , [ 'type'=>"password", 'label'=>__("Confirmez le mot de passe") , 'templateVars'=>$col ]);
				?>
				<BUTTON type="submit" value="send" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> <?= __("Enregistrer") ?></BUTTON>
				<!--
				<A href="deleteMe" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> <?= __("Supprimer mon profil") ?></A>
				-->
			<?= $this->Form->end() ?>
		</DIV>
	</DIV>
</div>
<div class="col-md-4">
	<H2><?= __("Photo de profil") ?></H2>
	<P><?= __("Notre site utilise <A href='http://fr.gravatar.com' target='_blank'>Gravatar</A> pour avoir votre photo de profil. Si votre image est une lettre sur une silhouette, c'est que vous n'avez pas de Gravatar :") ?></P>
	<P><IMG width="100" class="gravatar" style="background-image:url('../img/gravatar/<?php echo strtoupper(substr($user->alias,0,1)) ?>.jpg');" src="http://www.gravatar.com/avatar/<?php echo md5($user->username) ?>?s=100&d=blank"></P>
	<P><?= __("Gravatar permet de lier une photo à votre adresse email : simple, efficace et utile sur beaucoup de sites.") ?></P>
	<P><A href="http://fr.gravatar.com" class="btn btn-secondary" target="_blank"><I class="fa fa-share"></I> <?= __("Créez votre Gravatar") ?></A></P>
</div>