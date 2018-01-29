<?= $this->Html->script('item-edit', ['block' => true]); ?>

<?php $this->assign('title', __("Nouvelle annonce")) ?>

<div class="col-sm-12">
	<DIV class="card">
		<DIV class="card-header">
			<H1><?= __("Créer une annonce") ?></H1>
		</DIV>
		<DIV class="card-block">
			<?php
				$this->loadHelper('Form', [ 'templates' => 'app_form', ]); 
			?>
			<?= $this->Form->create($item, ['enctype' => 'multipart/form-data']) ?>
				<DIV class="row">
					<DIV class="col-md-12">
						<?php
						$this->Form->setTemplates([
							'nestingLabel' => '{{hidden}}<div class="form-check form-check-inline"><label class="form-check-label" {{attrs}}>{{input}} {{text}}</label></div>'
						]);
						echo $this->Form->control('type', ['type' => 'radio', 'label' => false,
							'options' => ['d' => __("Je donne"), 'r' => __("Je cherche")] ]);
						?>
					</DIV>
					<DIV class="col-md-6">
						<?php
						echo $this->Form->control('title' , [ 'label'=>__("Dénomination") , 'placeholder'=>__("Vélo de course, Table de jardin, etc.") ]);
						echo $this->Form->control('description' , [ 'label'=>__("Description") , 'placeholder'=>__("Donner des détails : marque, usage, comment venir le chercher, etc") ]);
						?>
					</DIV>
					<DIV class="col-md-6">
						<DIV class="row">
							<DIV class="col-sm-12">
								<P><?= __("Pour améliorer le succès de votre annonce, fournissez quelques photos. La première sera utilisée dans la page d'accueil.") ?></P>
							</DIV>
							<?php for ($i=1; $i<=3; $i++) { ?>
							<DIV class="col-4 image-upload">
								<DIV class="image-preview">
									<IMG class="img-fluid" src="<?= $this->Url->build("/img/image-add.png") ?>">
									<DIV class="block-actions deleteImage" style="display:none;">
										<A href="javascript:void(0);" class="btn btn-sm btn-danger"><I class="fa fa-trash"></I></A>
									</DIV>
								</DIV>
								<?= $this->Form->file('image[]') ?>
							</DIV>
							<?php } ?>
							&nbsp;
						</DIV>
					</DIV>
					<DIV class="col-md-12">
						<?= $this->Form->control('category_id', ['label'=>__("Catégorie") , 'options'=>$categories, 'empty'=>__("(choisissez la meilleure catégorie possible)") ]); ?>
					</DIV>
					<DIV class="col-md-12" id="input-state">
						<?= $this->Form->control('state' , ['type' => 'select', 'label'=>__("Etat") , 
							'empty'=>__("(indiquez l'état du don)") ,
							'options' => ['new'=>__("Comme neuf, jamais ou peu utilisé, pas de trace d'usure. Précisez dans la description s'il y a l'amballage d'origine, une garantie en cours..."), 
										  'used'=>__("Usagé, mais ne nécessite pas de réparation."), 
										  'broken'=>__("À réparer, ou pour récupérer des pièces. Ne remplit pas correctement sa fonction en l'état.")] ]);
						?>
					</DIV>
				</DIV>
				<?= $this->Form->submit(__('Envoyer')) ?>
			<?= $this->Form->end() ?>
		</DIV>
	</DIV>
</div>
<INPUT type="hidden" id="error_not_image" value="<?= __("Ce fichier n'est pas une image.") ?>">
<INPUT type="hidden" id="error_old_browser" value="<?= __("Désolé : votre navigateur est trop ancien pour charger des images. Nous travaillons à ce problème...") ?>">
<INPUT type="hidden" id="image-add-src" value="<?= $this->Url->build("/img/image-add.png") ?>">