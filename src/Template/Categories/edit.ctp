<?php
$this->loadHelper('Form', [ 'templates' => 'app_form_inline', ]);
$col = array('collabel' => "col-sm-4", 'colinput' => "col-sm-8");
?>
<div class="col-sm-12">
	<H1><?= (!isset($category->title_fr) ? "Nouvelle catégorie" : "Modifier ".$category->title_fr) ?></H1>
    <?= $this->Form->create($category) ?>
        <?php
            echo $this->Form->control('title_fr' , [ 'templateVars'=>$col ]);
            echo $this->Form->control('description_fr' , [ 'templateVars'=>$col ]);
            echo $this->Form->control('title_nl' , [ 'templateVars'=>$col ]);
            echo $this->Form->control('description_nl' , [ 'templateVars'=>$col ]);
        ?>
	<BUTTON type="submit" value="send" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Save</BUTTON>
	<A href="<?= $this->Url->build("/categories/") ?>" class="btn btn-secondary">Cancel</A>
    <?= $this->Form->end() ?>
</div>
