<?php
$this->assign('title', h($item->title));
// Connected or not
if ($this->request->session()->read("Auth.User.id")) {
	$connected = true;
} else {
	$connected = false;
}
/*
	Meta tags
*/
// This URL, for share links
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
$full_url = $protocol."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
// Site Name
$this->Html->meta('og:site_name', SITE_NAME, ['block' => true]);
$this->Html->meta('twitter:site', SITE_NAME, ['block' => true]);
$this->Html->meta('og:type', "website", ['block' => true]);
// URL
$this->Html->meta('og:url', $full_url, ['block' => true]);
// Page title
$meta_title = ($item->type == "d" ? $item->state_label : __("Je cherche")) . " : " . $item->title;
$this->Html->meta('og:title', $meta_title, ['block' => true]);
$this->Html->meta('twitter:title', $meta_title, ['block' => true]);
// Description
$meta_description = $item->description;
$this->Html->meta('description', $meta_description, ['block' => true]);
$this->Html->meta(['property' => 'og:description', 'content' => $meta_description, 'block' => true] );
$this->Html->meta('twitter:description', $meta_description, ['block' => true]);
// Image
if ($item->image_1_url) {
	$featured_image = urlencode($this->Url->build("/".$item->image_1_url,true));
} else {
	$featured_image = urlencode($this->Url->build("/img/item-".$item->type."-no-image.jpg"));
}
$this->Html->meta('og:image', $featured_image, ['block' => true]);
$this->Html->meta('twitter:image', $featured_image, ['block' => true]);
$this->Html->meta(['link'=>$featured_image, 'rel'=>"image_src", 'block'=>true]);
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
					<DIV class="d-flex justify-content-between mb-3">
						<SPAN>
							<?= $this->Html->link($item->category->title, [ 'action' => 'category', $item->category->id]) ?>
							<SPAN class="item-state <?= ( $item->type == "d" ? $item->state : "request" ) ?>"><?= ( $item->type == "d" ? h($item->state_label) : __("Je cherche") ) ?></SPAN>
						</SPAN>
						<SPAN class="share-links">
							<A href="https://www.facebook.com/sharer.php?u=<?= $full_url ?>" target="_blank" title="Facebook"><i class="fab fa-facebook"></i></A>
							<A href="https://twitter.com/intent/tweet?text=<?= $meta_title ?>&amp;url=<?= $full_url ?>" target="_blank" title="Twitter"><i class="fab fa-twitter-square"></i></A>
							<A href="https://plus.google.com/share?app=110&url=<?= $full_url ?>" target="_blank" title="Google+"><i class="fab fa-google-plus-square"></i></A>
							<A href="http://pinterest.com/pin/create/button/?url=<?= $full_url ?>&amp;media=<?= $featured_image ?>&amp;description=<?= $meta_title ?>" target="_blank" title="Pinterest"><i class="fab fa-pinterest-square"></i></A>
							<A href="mailto:?subject=<?= $meta_title ?> (<?= SITE_NAME ?>)&body=<?= $meta_description."   ".$full_url ?>" title="E-mail"><i class="fas fa-envelope-square"></i></A>
						</SPAN>
					</DIV>
					<TABLE class="item-dialog mb-3">
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

