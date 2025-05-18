<DIV id="contact-block">
	<A id="contact-toggle" href="javascript:void(0);"><?= __("Contact") ?></A>
	<?= $this->Form->create(null, ['url' => ['controller' => 'App', 'action' => 'contact']]) ?>
		<P class="alert alert-warning"><?= __("N'utilisez pas ce formulaire pour contacter un annonceur : utilisez le formulaire dans le détail de l'annonce.") ?></P>
		<?php
		if (!$connected) {
			echo $this->Form->text('name' , ['placeholder'=>__("Votre nom") , 'class'=>"form-control" , 'required'=>"required" ]);
			echo $this->Form->email('email' , ['placeholder'=>__("Votre email") , 'class'=>"form-control" , 'required'=>"required" ]);
		}
		echo $this->Form->select('subject' , [
			__("Problème technique")=>__("Problème technique"), 
			__("Signaler une annonce ou un utilisateur")=>__("Signaler une annonce ou un utilisateur"), 
			"Question sur le site"=>__("Question sur le site"),
			"Avoir ce site pour ma communauté"=>__("Avoir ce site pour ma communauté")
			] , ['empty' => __('(Choisissez)') , 'class'=>"form-control" , 'required'=>"required" ] );
		echo $this->Form->textarea('message', [ 'rows'=>"5" , 'class'=>"form-control" , 'required'=>"required" ] );
		echo $this->element('robot-form-trap');
		?>
		<div class="input-group">
			<?= $this->Form->text('district' , ['placeholder'=>__("Code postal de notre commune") , 'class'=>"form-control" , 'required'=>"required" ]) ?>
			<div class="input-group-append">
				<button class="btn btn-primary" type="submit" ><?= __('Envoyer') ?></button>
			</div>
		</div>
	<?= $this->Form->end() ?>
</DIV>