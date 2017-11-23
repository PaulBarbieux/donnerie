<?= $this->Html->script('item-edit', ['block' => true]); ?>

<?php $this->assign('title', h($item->title)) ?>

<DIV class="col-sm-12">
	<DIV class="card">
		<DIV class="card-header">
			<H1><?= ($item->type == "d" ? __("Je donne") : __("Je cherche")) ?><?= ($admin ? " (".$owner.")" : "") ?></H1>
		</DIV>
		<DIV class="card-block">
			<?php
				$this->loadHelper('Form', [ 'templates' => 'app_form' ]); 
			?>
			<?= $this->Form->create($item, ['enctype' => 'multipart/form-data']) ?>
			<DIV class="row">
				<DIV class="col-md-6">
				<?php
						echo $this->Form->control('title' , [ 'label'=>__("Dénomination") , 'placeholder'=>__("Vélo de course, Table de jardin, etc.") ]);
						echo $this->Form->control('description' , [ 'label'=>__("Description") , 'placeholder'=>__("Donner des détails : marque, usage, comment venir le chercher, etc") ]);
						echo $this->Form->control('category_id', ['label'=>__("Catégorie") , 'options'=>$categories ]);
						if ($item->type == "d") {
							echo $this->Form->control('state' , ['type' => 'radio', 'label'=>__("Etat") , 'options' => ['new'=>__('Comme neuf'), 'used'=>__('Usagé'), 'broken'=>__('À réparer')] ]);
						}
				?>
				</DIV>
				<DIV class="col-md-6">
					<H2><?= __("Images") ?></H2>
					<P><?= __("La première image illustre votre annonce en page d'accueil. Sans image, une photo par défaut sera utilisée.") ?></P>
					<DIV class="row">
						<?php
						$images = array(1=>$item->image_1_url,2=>$item->image_2_url,3=>$item->image_3_url);
						for ($iImg=1; $iImg<=3; $iImg++) {
							$image = $images[$iImg];
						?>
						<DIV class="col-4 image-upload">
							<DIV class="image-preview">
								<?php if ($image) { ?>
								<IMG class="img-fluid" src="<?= $this->Url->build("/".$image) ?>" >
								<?php } else { ?>
								<IMG class="img-fluid" src="<?= $this->Url->build("/img/image-add.png") ?>">
								<?php } ?>
								<DIV class="block-actions deleteImage" <?php if (!$image) { ?>style="display:none;"<?php } ?>>
									<A href="javascript:void(0);" class="btn btn-sm btn-danger"><I class="fa fa-trash"></I></A>
								</DIV>
							</DIV>
							<?= $this->Form->file('image[]') ?>
							<?= $this->Form->input('image_'.$iImg.'_url' , ['type' => 'hidden' ]); ?>
						</DIV>
						<?php } ?>
						&nbsp;
					</DIV>
				</DIV>
			</DIV>
			<BUTTON type="submit" value="send" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> <?= __("Enregistrer") ?></BUTTON>
			<?= $this->Html->link("Annuler", array('controller'=>"items", 'action'=>"mines"), array('class'=>"btn btn-default")) ?>
			<?= $this->Form->end() ?>
		</DIV>
	</DIV>
</DIV>
<INPUT type="hidden" id="error_not_image" value="<?= __("Ce fichier n'est pas une image.") ?>">
<INPUT type="hidden" id="image-add-src" value="<?= $this->Url->build("/img/image-add.png") ?>">