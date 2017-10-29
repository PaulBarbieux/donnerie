<?php
$this->loadHelper('Form', [ 'templates' => 'app_form_inline', ]);
$col = array('collabel' => "col-sm-4", 'colinput' => "col-sm-8");
?>
<DIV class="col-lg-8 col-md-10 col-sm-12">
	<H1>User <?= $user->username ?></H1>
    <?= $this->Form->create($user) ?>
        <?php
			echo $this->Form->control('alias' , [ 'templateVars'=>$col ]);
            echo $this->Form->control('username' , [ 'templateVars'=>$col ]);
			echo $this->Form->control('street' , [ 'empty'=>__("(choisissez)") , 'templateVars'=>$col ]);
            echo $this->Form->control('language' , [ 'type'=>"radio" , 'options'=>['fr'=>"French", 'nl'=>"Dutch"] , 'templateVars'=>$col ]);
            echo $this->Form->control('role' , [ 'type'=>"radio" , 'options'=>['user'=>"User", 'admin'=>"Administrator"] , 'templateVars'=>$col ]);
			echo $this->Form->control('status' , [ 'templateVars'=>$col ]);
            echo $this->Form->control('passwordNew' , [ 'templateVars'=>$col , 'placeholder'=>__("Donner un mot de passe pour écraser l'ancien") ]);
        ?>
	<BUTTON type="submit" value="send" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> <?= __("Enregistrer") ?></BUTTON>
	<A href="<?= $this->Url->build("/users/") ?>" class="btn btn-outline-primary"><?= __("Annuler") ?></A>
    <?= $this->Form->end() ?>
</DIV>