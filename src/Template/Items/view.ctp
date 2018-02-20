<?php
$this->assign('title', h($item->title));
if ($this->request->session()->read("Auth.User.id")) {
	$connected = true;
} else {
	$connected = false;
}
?>

<DIV class="col-sm-12">
	<DIV class="card">
		<DIV class="card-body">
			<DIV class="row">
				<DIV class="col-md-5">
					<DIV class="row">
						<DIV class="col-sm-12">
							<?php if ($item->image_1_url) { ?>
							<IMG class="img-fluid img-border" src="<?= $this->Url->build("/".$item->image_1_url) ?>">
							<?php } else { ?>
							<IMG class="img-fluid img-border" src="<?= $this->Url->build("/img/item-".$item->type."-no-image.jpg") ?>">
							<?php } ?>
							<BR>&nbsp;
						</DIV>
						<?php if ($item->image_2_url) { ?>
						<DIV class="<?= ($item->image_3_url ? "col-sm-6" : "col-sm-12") ?>">
							<IMG class="img-fluid img-border" src="<?= $this->Url->build("/".$item->image_2_url) ?>">
						</DIV>
						<?php } ?>
						<?php if ($item->image_3_url) { ?>
						<DIV class="col-sm-6">
							<IMG class="img-fluid img-border" src="<?= $this->Url->build("/".$item->image_3_url) ?>">
						</DIV>
						<?php } ?>
					</DIV>
				</DIV>
				<DIV class="col-md-7">
					<h1><?= h($item->title) ?></h1>
					<P><?= $this->Html->link($item->category->title, [ 'action' => 'category', $item->category->id]) ?>
						/ <SPAN class="item-state <?= ( $item->type == "d" ? $item->state : "request" ) ?>"><?= ( $item->type == "d" ? h($item->state_label) : __("Je cherche") ) ?></SPAN></P>
					<TABLE class="item-dialog">
						<TR>
							<TD class="item-gravatar" valign="top">
								<IMG class="gravatar img-fluid" style="background-image:url('<?= $this->Url->build("/img/gravatar/".strtoupper(substr($item->user->alias,0,1)).".jpg") ?>');" src="https://www.gravatar.com/avatar/<?php echo md5($item->user->username) ?>?s=100&d=blank">
							</TD>
							<TD><TABLE>
									<TR>
										<TD class="item-description-left"></TD>
										<TD>
											<DIV class="item-description"><?= $this->Text->autoParagraph(h($item->description)); ?></DIV>
										</TD>
									</TR>
									<TR>
										<TD></TD>
										<TD class="item-date"><?= $this->Html->link($item->user->alias, ['controller' => 'Items', 'action' => 'user', $item->user->id] , ['title' => __("Voir ses annonces")]) ?>
											le <?= h($item->created->i18nFormat("d MMMM YYYY")) ?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					</TABLE>
					&nbsp;
					<H3><I class="fa fa-send"></I> <?= __("Prendre contact pour cette annonce") ?></H3>
					<?php if (PUBLIC_CONTACT or $connected) { ?>
					<FORM method="post">
						<?php 
						echo $this->Form->textarea('message' , ['placeholder'=>__("Votre message concernant cette annonce") , 'class'=>"form-control" , 'required'=>"required" , 'rows'=>"5" ]);
						if (PUBLIC_CONTACT and !$connected) {
							echo $this->Form->text('name' , ['placeholder'=>__("Votre nom") , 'class'=>"form-control" , 'required'=>"required" ]);
							echo $this->Form->email('email' , ['placeholder'=>__("Votre email") , 'class'=>"form-control" , 'required'=>"required" ]);
						}
						echo $this->element('robot-form-trap');
						?>
						<IMG class="waiting-animation" src="<?= $this->Url->build("/img/loading.gif") ?>" style="display: none;">
						<BUTTON type="submit" name="contact" class="btn btn-primary" value="send"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?= __("Envoyer") ?></BUTTON>
					</FORM>
					<?php } else { ?>
					<P><?= __("Vous devez") . " " . $this->Html->link(__("vous connecter"), array('controller'=>"users", 'action'=>"login", '?'=>['redirect'=>"/items/view/".$item->id])) . " " . __("pour pouvoir contacter {0}" , h($item->user->alias) ) ?>.</P>
					<?php } ?>
				</DIV>			
			</DIV>
		</DIV>
	</DIV>
</DIV>

