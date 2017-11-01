<?php
// Size of the image : necessary for the compute by Packery JS
if ($item->image_1_url) {
	$imageFile = $item->image_1_url;
} else {
	$imageFile = "img/item-".$item->type."-no-image.jpg";
}
list($widthSrc,$heightSrc) = getimagesize($root.$imageFile); // To refactor to respect CakePHP
$heightImgGrid = round(176 / $widthSrc * $heightSrc);
?>

<A href="<?= $this->Url->build(['controller'=>"Items", 'action'=>"view",$item->id]) ?>" class="card grid-item item-<?= $item->type ?>" style="width:200px; ">
	<DIV class="card-header">
		<h2 class="card-title"><?= h($item->title) ?></h2>
	</DIV>
	<DIV class="card-block">
		<?php if (!$user) { ?>
			<IMG width="25" class="gravatar" style="background-image:url('<?= $this->Url->build("/img/gravatar/".strtoupper(substr($item->user->alias,0,1)).".jpg") ?>');" src="http://www.gravatar.com/avatar/<?php echo md5($item->user->username) ?>?s=25&d=blank">
			<?= h($item->user->alias) . ", " ?>
		<?php } ?>
		<?php
		$dateNow = new DateTime();
		$diff = $dateNow->diff(new DateTime($item->created->i18nFormat("YYYY-MM-d")));
		switch ($diff->days) {
			case 0 : $createdString = __("aujourd'hui"); break;
			case 1 : $createdString = __("hier"); break;
			case 2 : $createdString = __("avant-hier"); break;
			default : $createdString = __("il y a {0} jours",$diff->days);
		}
		?>
		<?= $createdString ?>
	</DIV>
	<DIV class="card-block">
		<DIV class="item-img">
			<IMG src="<?= $this->Url->build("/".$imageFile) ?>" width="176" height="<?= $heightImgGrid ?>">
			<SPAN class="item-state <?= h($item->state) ?>">
				<?php if ($category) { ?>
				<?= $category ?>
				<?php } else { ?>
				<?= h($item->category->title_fr) ?>
				<?php } ?>
			</SPAN>
			<?php if ($item->user->street == $this->request->session()->read("Auth.User.street") and $item->user->id != $this->request->session()->read("Auth.User.id")) { ?>
			<SPAN class="item-same-street" title="<?= __("C'est dans votre rue") ?>"></SPAN>
			<?php } ?>
		</DIV>
	</DIV>
	<DIV class="card-block">
		<P><?= nl2br(h($this->Text->truncate($item->description,HOME_TRUNCATE_TEXT))) ?></P>
	</DIV>
</A>