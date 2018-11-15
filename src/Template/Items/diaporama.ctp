<STYLE type="text/css">
BODY {
	margin:0 !important;
	padding-top: 10px !important;
	font-size:25px;
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
#ItemImage, .card {
	-webkit-box-shadow: 0px 5px 15px -3px rgba(0, 0, 0, 0.5);
	-moz-box-shadow:    0px 5px 15px -3px rgba(0, 0, 0, 0.5);
	box-shadow:         0px 5px 15px -3px rgba(0, 0, 0, 0.5);
}
.item-state {
	display:inline-block;
	padding: 5px 10px;
}
</STYLE>
<?php
if (isset($_GET['offline'])) {
	// Infinite loop without refresh of items
	$offline = true;
} else {
	$offline = false;
}
?>
<DIV class="container">
	<DIV class="row">
		<DIV class="col-8 text-right" >
			<DIV id="ItemIllu">
				<IMG id="ItemImage" class="img-fluid">
			</DIV>
		</DIV>
		<DIV class="col-4" id="ItemInfo">
			<DIV class="card">
				<DIV class="card-body">
					<P class="item-type d"><?= implode(" / ",$labels['d']) ?></P>
					<P class="item-type r"><?= implode(" / ",$labels['r']) ?></P>
					<H2 id="ItemTitle"></H2>
					<DIV class="item-state new"><?= implode(" / ",$labels['new']) ?></DIV>
					<DIV class="item-state used"><?= implode(" / ",$labels['used']) ?></DIV>
					<DIV class="item-state broken"><?= implode(" / ",$labels['broken']) ?></DIV>
					<P id="ItemDescription"></P>
				</DIV>
			</DIV>
		</DIV>
	</DIV>
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

<?php
$this->assign('title', "Diaporama");
$lastId = -1;
foreach ($items as $i=>$item) {
	$lastId++;
?>
	<INPUT type="hidden" class="item" id="diapo_<?= $i ?>" 
		item-title="<?= htmlentities($item->title) ?>" 
		item-description="<?= htmlentities($item->description) ?>" 
		item-type="<?= $item->type ?>" 
		item-state="<?= $item->state ?>" 
		item-image="<?= $this->Url->build("/".$item->image_1_url) ?>">
	<IMG src="<?= $this->Url->build("/".$item->image_1_url) ?>" style="display:none; ">
<?php
}
?>
<INPUT type="hidden" id="lastId" value="<?= $lastId ?>">
<INPUT type="hidden" id="Offline" value="<?= $offline ?>">

<SCRIPT type="text/javascript">
jQuery(document).ready(function(){
	var timeout = 5000;
	var id = 0;
	var infinite = $("#Offline").val();
	var curLang = "nl";
	showItem();
	
	function showItem() {
		thisItem =  $("#diapo_" + id);
		$("#ItemIllu").slideUp(300,function(){
			$("#ItemImage").attr('src',thisItem.attr("item-image"));
			$("#ItemIllu").slideDown(300);
			$("#ItemTitle").text(thisItem.attr("item-title"));
			$("#ItemDescription").text(thisItem.attr("item-description"));
			$(".item-type, .item-state").hide();
			$(".item-type."+thisItem.attr("item-type")).show();
			if (thisItem.attr("item-type") == "d") {
				$(".item-state."+thisItem.attr("item-state")).show();
			}
		});
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
		id++;
		if (id <= $("#lastId").val() || infinite) {
			if (id > $("#lastId").val()) {
				// Back to begin (infinite loop)
				id = 0;
			}
			setTimeout(showItem,timeout);
		} else {
			// Refresh the page
			setTimeout(function(){
				window.location = "/diaporama";
			},timeout);
		}
	}
});
</SCRIPT>