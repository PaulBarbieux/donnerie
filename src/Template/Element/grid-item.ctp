<A href="<?= $this->Url->build(['controller'=>"Items", 'action'=>"view",$item->id]) ?>" class="card grid-item item-<?= $item->type ?> <?php if ($item->isBooked()) { ?>item-booked<?php } ?>">
	<DIV class="card-header">
		<h2 class="card-title"><?= h($item->title) ?></h2>
	</DIV>
	<DIV class="card-body">
		<?php if (!$user) { ?>
			<IMG width="25" class="gravatar" style="background-image:url('<?= $this->Url->build("/img/gravatar/".strtoupper(substr($item->user->alias,0,1)).".jpg") ?>');" src="https://www.gravatar.com/avatar/<?php echo md5($item->user->username) ?>?s=25&d=blank">
			<?= h($item->user->alias) . ", " ?>
		<?php } ?>
		<?php
		$dateNow = new DateTime();
		$diff = $dateNow->diff(new DateTime($item->created->i18nFormat("yyyy-MM-d")));
		switch ($diff->days) {
			case 0 : $createdString = __("aujourd'hui"); break;
			case 1 : $createdString = __("hier"); break;
			case 2 : $createdString = __("avant-hier"); break;
			default : $createdString = __("il y a {0} jours",$diff->days);
		}
		?>
		<?= $createdString ?>
	</DIV>
	<DIV class="card-body">
		<DIV class="item-img">
			<?php
			if ($item->image_1_url) {
				$imageFile = $item->image_1_url;
			} else {
				$imageFile = "img/item-".$item->type."-no-image.jpg";
			}
			?>
			<IMG src="<?= $this->Url->build("/".$imageFile) ?>" class="img-fluid">
			<SPAN class="item-state <?= h($item->state) ?>">
				<?php if ($category) { ?>
				<?= $category ?>
				<?php } else { ?>
				<?= h($item->category->title) ?>
				<?php } ?>
			</SPAN>
			<?php if ($item->user->street == $this->request->session()->read("Auth.User.street") and $item->user->id != $this->request->session()->read("Auth.User.id")) { ?>
			<SPAN class="item-same-street" title="<?= __("C'est dans votre rue") ?>"></SPAN>
			<?php } ?>
		</DIV>
	</DIV>
	<DIV class="card-body">
		<P><?= nl2br(h($this->Text->truncate($item->description,HOME_TRUNCATE_TEXT))) ?></P>
	</DIV>
	<?php if ($item->isBooked()) { ?>
	<DIV class="banner-booked">
		<?= __("Réservé") ?>
	</DIV>
	<?php } ?>
</A>