<STYLE type="text/css">
BODY {
	margin:0 !important;
	padding-top: 10px !important;
	font-size:16px;
}
H1, H2 {
	font-weight:bold;
	text-transform:uppercase;
}
H1 {
	font-zize: 10rem;
}
H1 A {
	text-decoration:underline;
}
H2 {
	font-zize: 4rem;
}
#CenterBlock {
	position: relative;
	width:90%;
}
#CenterBlock.format-portrait #ItemIllu {
	position: absolute;
	top:0;
	right:40%;
}
#CenterBlock.format-lanscape #ItemIllu {
	position: absolute;
	top:0;
	left:0;
}
#ItemIllu IMG {
	height:100%;
	width:auto;
}
#ItemInfo {
	position: absolute;
	top:10%;
	left:55%;
	font-size: 25px;
}
#ItemImage, .card {
	-webkit-box-shadow: 0px 5px 15px -3px rgba(0, 0, 0, 0.5);
	-moz-box-shadow:    0px 5px 15px -3px rgba(0, 0, 0, 0.5);
	box-shadow:         0px 5px 15px -3px rgba(0, 0, 0, 0.5);
}
.item-state {
	display:inline-block;
	padding: 5px 10px;
}
.item-type.r {
	background-color:#666666;
	color: #FFF;
	padding: 5px 10px;
}
</STYLE>
<?php
if (isset($_GET['settings'])) {
	$go = true;
	$offline = $_GET['offline'];
	$wait = $_GET['wait'];
	$langFr = isset($_GET['lang_fr']);
	$langNl = isset($_GET['lang_nl']);
} else {
	$go = false;
	$offline = false;
	$wait = 5000;
	$langFr = true;
	$langNl = true;
}

function setLabel($labels, $langFr, $langNl) {
	if ($langFr and $langNl) {
		return implode(" / ",$labels);
	} elseif ($langNl) {
		return $labels[1];
	} else {
		return $labels[0];
	}
}
?>
<DIV class="container-fluid d-flex justify-content-center align-items-center">
	
	<DIV class="card" id="Settings" <?php if ($go) { ?>style="display:none;"<?php } ?>>
		<DIV class="card-body">
			<FORM method="get">
				<DIV class="form-group">
					<LABEL>Temps de pause</LABEL>
					<SELECT name="wait">
						<OPTION value="3000" <?php if ($wait == "3000") echo "selected" ?>>3 sec</OPTION>
						<OPTION value="5000" <?php if ($wait == "5000") echo "selected" ?>>5 sec</OPTION>
						<OPTION value="8000" <?php if ($wait == "8000") echo "selected" ?>>8 sec</OPTION>
						<OPTION value="12000" <?php if ($wait == "12000") echo "selected" ?>>12 sec</OPTION>
						<OPTION value="20000" <?php if ($wait == "20000") echo "selected" ?>>20 sec</OPTION>
					</SELECT>
					<INPUT type="hidden" id="wait" value="<?= $wait ?>">
				</DIV>
				<DIV class="form-group">
					Langues
					<LABEL><INPUT type="checkbox" name="lang_fr" value="1" <?php if ($langFr) echo "checked" ?>> Français</LABEL>
					<LABEL><INPUT type="checkbox" name="lang_nl" value="1" <?php if ($langNl) echo "checked" ?>> Néerlandais</LABEL>
					<INPUT type="hidden" id="lang_fr" value="<?= $langFr ? 1 : 0 ?>">
					<INPUT type="hidden" id="lang_nl" value="<?= $langNl ? 1 : 0 ?>">
				</DIV>
				<DIV class="form-group">
					Fonctionnement offline ? 
					<LABEL><INPUT type="radio" name="offline" value="0" <?php if (!$offline) echo "checked" ?>> Non</LABEL>
					<LABEL><INPUT type="radio" name="offline" value="1" <?php if ($offline) echo "checked" ?>> Oui</LABEL>
					<small class="form-text text-muted">Si oui : une fois lancé, le diaporama n'a plus besoin de connexion internet</small>
					<INPUT type="hidden" id="offline" value="<?= $offline ? 1 : 0 ?>">
				</DIV>
				<INPUT type="hidden" name="settings" value="true">
				<BUTTON type="submit" class="btn btn-primary">Démarrer</BUTTON>
				<small class="form-text text-muted">Une fois lancé, mémorisez l'URL dans vos favoris si vous voulez régulièrement montrer le diaporama avec ces paramètres.</small>
			</FORM>
		</DIV>
	</DIV>
	
	<?php if ($go) { ?>

	<DIV id="CenterBlock">
	
			<DIV id="ItemIllu">
				<IMG id="ItemImage" class="img-fluid">
			</DIV>
			
			<DIV id="ItemInfo">
				<DIV class="card">
					<DIV class="card-body">
						<P class="item-type d"><?= setLabel($labels['d'],$langFr,$langNl) ?></P>
						<P class="item-type r"><?= setLabel($labels['r'],$langFr,$langNl) ?></P>
						<H2 id="ItemTitle"></H2>
						<DIV class="item-state new"><?= setLabel($labels['new'],$langFr,$langNl) ?></DIV>
						<DIV class="item-state used"><?= setLabel($labels['used'],$langFr,$langNl) ?></DIV>
						<DIV class="item-state broken"><?= setLabel($labels['broken'],$langFr,$langNl) ?></DIV>
						<P id="ItemDescription"></P>
					</DIV>
				</DIV>
			</DIV>
			
	</DIV>
	
	<?php } ?>
	
</DIV>

<FOOTER>
	<DIV class="container-fluid">
		<DIV class="row">
			<DIV class="col-12">
				<H1 class="text-center"><SPAN class="fr"><?= $labels['title'][0] ?></SPAN><SPAN class="nl" style="display:none;"><?= $labels['title'][1] ?></SPAN></H1>
			</DIV>
		</DIV>
	</DIV>
</FOOTER>

<?php if ($go) { ?>

<?php
$this->assign('title', "Diaporama");
$lastId = 0;
foreach ($items as $i=>$item) {
	$lastId++;
	if ($item->image_1_url == "") {
		$imageUrl = "img/item-".$item->type."-no-image.jpg";
	} else {
		$imageUrl = $item->image_1_url;
	}
	list($widthImg,$heightImg) = getimagesize(WWW_ROOT.$imageUrl);
	if ($widthImg > $heightImg) {
		$format = "landscape";
	} else {
		$format = "portrait";
	}
?>
	<INPUT type="hidden" class="item" id="diapo_<?= $lastId ?>" 
		item-id="<?= $item->id ?>"
		item-title="<?= htmlentities($item->title) ?>" 
		item-description="<?= htmlentities($item->description) ?>" 
		item-type="<?= $item->type ?>" 
		item-state="<?= $item->state ?>" 
		item-image="<?= $this->Url->build("/".$imageUrl) ?>"
		item-format="<?= $format ?>"
	>
	<IMG src="<?= $this->Url->build("/".$imageUrl) ?>" style="display:none;">
<?php
}
?>
<INPUT type="hidden" id="lastId" value="<?= $lastId ?>">

<SCRIPT type="text/javascript">
jQuery(document).ready(function(){
	/*
		Compute height
	*/
	var resizeId;
	$(window).resize(function(){
		clearTimeout(resizeId);
		resizeId = setTimeout(doneResizing, 250);
	});
	doneResizing();
	function doneResizing() {
		availableHeight = $("HTML").height() - $("FOOTER").height();
		$("#CenterBlock, #ItemIllu").height(availableHeight - 100);
	}
	/*
		Diaporama
	*/
	var timeout = $("#wait").val();
	var offline = $("#offline").val();
	var langFr = $("#lang_fr").val();
	var langNl = $("#lang_nl").val();
	if ((langFr + langNl) == "11") {
		var alternateLg = true;
		var curLang = "nl";
	} else {
		var alternateLg = false;
		if (langFr == "1") {
			var curLang = "fr";
		} else {
			var curLang = "nl";
			$(".fr").hide();
			$(".nl").show();
		}
	}
	var id = 1;
	showItem();
	
	function showItem() {
		thisItem =  $("#diapo_" + id);
		$("#ItemImage").slideUp(300,function(){
			$("#ItemImage").attr('src',thisItem.attr("item-image"));
			$("#CenterBlock").removeClass("format-portrait");
			$("#CenterBlock").removeClass("format-landscape");
			$("#CenterBlock").addClass("format-" + thisItem.attr("item-format"));
			$("#ItemImage").slideDown(300);
			$("#ItemTitle").text(thisItem.attr("item-title"));
			$("#ItemDescription").text(thisItem.attr("item-description"));
			$(".item-type, .item-state").hide();
			$(".item-type."+thisItem.attr("item-type")).show();
			if (thisItem.attr("item-type") == "d") {
				$(".item-state."+thisItem.attr("item-state")).show();
			}
		});
		if (alternateLg) {
			// Alternate language
			if (curLang == "fr") {
				$(".fr").hide();
				$(".nl").show();
				curLang = "nl";
			} else {
				$(".nl").hide();
				$(".fr").show();
				curLang = "fr";
			}
		}
		id++;
		if (id <= $("#lastId").val() || offline == "1") {
			if (id > $("#lastId").val()) {
				// Back to begin (infinite loop)
				id = 1;
			}
			setTimeout(showItem,timeout);
		} else {
			// Refresh the page
			setTimeout(function(){
				window.location = $(location).attr('href');
			},timeout);
		}
	}
});
</SCRIPT>

<?php } // End go ?>