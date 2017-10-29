<?php
$this->loadHelper('Form', [ 'templates' => 'app_form_inline', ]);
$col = array('collabel' => "col-sm-4", 'colinput' => "col-sm-8");
?>
<div class="col-sm-12">
	<H1><?= (!isset($street->name_fr) ? "Nouvelle rue" : "Modifier ".$street->name_fr) ?></H1>
	<DIV class="card">
		<DIV class="card-block">
			<?= $this->Form->create($street) ?>
				<?php
					echo $this->Form->control('name_fr' , [ 'templateVars'=>$col ]);
					echo $this->Form->control('name_nl' , [ 'templateVars'=>$col ]);
				?>
			<BUTTON type="submit" value="send" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Save</BUTTON>
			<A href="<?= $this->Url->build("/streets/") ?>" class="btn btn-secondary">Cancel</A>
			<?= $this->Form->end() ?>
		</DIV>
	</DIV>
</div>
