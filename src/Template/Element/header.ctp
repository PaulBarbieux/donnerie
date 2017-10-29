<?php
/*	https://www.youtube.com/watch?v=ieYuE_G06UI 20:29
	https://v4-alpha.getbootstrap.com/components/navbar/
*/
$admin = false;
if ($this->request->session()->read("Auth.User.id")) {
	$connected = true;
	if ($this->request->session()->read("Auth.User.role") == "admin") {
		$admin = true;
	}
} else {
	$connected = false;
}
?>
<NAV class="navbar navbar-toggleable-sm fixed-top navbar-light">
	<BUTTON class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    	<SPAN class="navbar-toggler-icon"></SPAN>
	</BUTTON>
 	<A class="navbar-brand" href="<?= $this->Url->build(['controller'=>"Items", 'action'=>"home"]) ?>">
		<IMG src="<?= $this->Url->build("/img/donnerie-logo.png") ?>">
	</A>
	<DIV class="collapse navbar-collapse" id="navbarSupportedContent">
		<UL class="navbar-nav mr-auto">
			<LI class="nav-item">
				<A class="nav-link" href="<?= $this->Url->build("/items/add") ?>"><I class="fa fa-thumb-tack"></I> <?= __("Ajouter votre annonce") ?></A>
			</LI>
			<LI class="nav-item dropdown">
				<A class="nav-link dropdown-toggle" href="#" id="infoLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<I class="fa fa-info-circle"></I> <?= __("Infos") ?>
				</A>
				<DIV class="dropdown-menu" aria-labelledby="infoLinks">
					<?= $this->Html->link(__("F.A.Q."), array('controller'=>"pages", 'action'=>"faq"), array('class'=>"dropdown-item")) ?>
					<?= $this->Html->link(__("À propos de ce site"), array('controller'=>"pages", 'action'=>"info"), array('class'=>"dropdown-item")) ?>
				</DIV>
			</LI>
			<?php if ($connected) { ?>
			<?php if ($admin) { ?>
			<LI class="nav-item dropdown">
				<A class="nav-link dropdown-toggle" href="#" id="adminLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<I class="fa fa-cogs"></I>
				</A>
				<DIV class="dropdown-menu" aria-labelledby="adminLinks">
					<?= $this->Html->link(__("Utilisateurs"), array('controller'=>"users", 'action'=>"index"), array('class'=>"dropdown-item")) ?>
					<?= $this->Html->link(__("Annonces"), array('controller'=>"items", 'action'=>"index"), array('class'=>"dropdown-item")) ?>
					<?= $this->Html->link(__("Categories"), array('controller'=>"categories", 'action'=>"index"), array('class'=>"dropdown-item")) ?>
					<?= $this->Html->link(__("Rues"), array('controller'=>"streets", 'action'=>"index"), array('class'=>"dropdown-item")) ?>
				</DIV>
			</LI>
			<?php } ?>
			<LI class="nav-item dropdown">
				<A class="nav-link dropdown-toggle" href="#" id="myProfileLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<IMG width="25" class="gravatar" style="background-image:url('<?= $this->Url->build("/img/gravatar/".strtoupper(substr($this->request->session()->read('Auth.User.alias'),0,1)).".jpg") ?>');" src="http://www.gravatar.com/avatar/<?php echo md5($this->request->session()->read('Auth.User.username')) ?>?s=25&d=blank">
          			Bonjour <?php echo $this->request->session()->read('Auth.User.alias'); ?>
        		</A>
				<DIV class="dropdown-menu" aria-labelledby="myProfileLinks">
					<?= $this->Html->link(__("Mes annonces"), array('controller'=>"items", 'action'=>"mines"), array('class'=>"dropdown-item")) ?>
					<?= $this->Html->link(__("Mon profil"), array('controller'=>"users", 'action'=>"me"), array('class'=>"dropdown-item")) ?>
					<?= $this->Html->link(__("Se déconnecter"), array('controller'=>"users", 'action'=>"logout"), array('class'=>"dropdown-item")) ?>
				</DIV>
			</LI>
			<?php } else { ?>
			<LI class="nav-item">
				<A class="nav-link" href="<?= $this->Url->build(array('controller'=>"users", 'action'=>"login")) ?>"><I class="fa fa-plug"></I> <?= __("Se connecter") ?></A>
			</LI>
			<?php } ?>
		</UL>
		<DIV class="btn-group btn-group-sm">
			<?php
			if ($this->request->session()->read('Config.language')) {
				$lang = $this->request->session()->read('Config.language');
			} else {
				$lang = "fr_FR";
			}
			?>
			<A class="btn <?= ($lang == "fr_FR" ? "active" : "") ?>" href="<?= $this->Url->build(['controller'=>"app", 'action'=>"changeLanguage", "fr_FR"]) ?>">FR</A>
			<A class="btn <?= ($lang == "nl_NL" ? "active" : "") ?>" href="<?= $this->Url->build(['controller'=>"app", 'action'=>"changeLanguage", "nl_NL"]) ?>">NL</A>
		</DIV>
	</DIV>
</NAV>

<DIV id="contact-block">
	<A href="javascript:void(0);"><?= __("Contact") ?></A>
	<?php
	echo $this->Form->create(null, ['url' => ['controller' => 'App', 'action' => 'contact']]);
	if (!$connected) {
		echo $this->Form->text('name' , ['placeholder'=>__("Votre nom") , 'class'=>"form-control" , 'required'=>"required" ]);
		echo $this->Form->email('email' , ['placeholder'=>__("Votre email") , 'class'=>"form-control" , 'required'=>"required" ]);
	}
	echo $this->Form->select('subject' , [
		'issue'=>__("Problème technique"), 
		'report'=>__("Signaler une annonce ou un utilisateur"), 
		'main'=>__("Question sur le site"),
		'install'=>__("Avoir ce site pour ma communauté")
		] , ['empty' => __('(Choisissez)') , 'class'=>"form-control" , 'required'=>"required" ] );
	echo $this->Form->textarea('message', [ 'rows'=>"5" , 'class'=>"form-control" , 'required'=>"required" ] );
	echo $this->Form->submit(__('Envoyer'));
	echo $this->Form->end();
	?>
</DIV>