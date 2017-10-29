<!DOCTYPE html>
<html lang="fr"><!-- InstanceBegin template="/Templates/Level N fr.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
$lang = 'fr';
$iLang = 0;
require($_SERVER['DOCUMENT_ROOT'].'/_includes/xml_coding.php');
require($_SERVER['DOCUMENT_ROOT'].'/_includes/init.php');
?>
<title><?php echo strip_tags($THIS_PAGE['name']) ?></title>
<!-- Bootstrap -->
<?php echo '
<link href="/_styles/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/_styles/font-awesome.min.css" rel="stylesheet">
<link href="/_styles/styles.css?20170421" rel="stylesheet" type="text/css" media="all">
<link href="/_styles/print.css" rel="stylesheet" type="text/css" media="print">
' ?>
<link href="/_styles/default.css?20170421" rel="stylesheet" type="text/css" media="all">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="/_scripts/jquery.min.js"></script>
<script src="/_scripts/bootstrap.min.js"></script>
<script src="/_scripts/init.js"></script>


<!-- InstanceParam name="Regular_text" type="boolean" value="true" -->
<!-- InstanceParam name="Packery" type="boolean" value="false" --> 
<!-- InstanceParam name="Page_title" type="boolean" value="true" --> 
<!-- InstanceParam name="Tabs_navigation" type="boolean" value="false" --> 
<!-- InstanceParam name="jQuery_UI" type="boolean" value="false" --> 
<!-- InstanceBeginEditable name="head" -->
<style>
INPUT[type="file"].inputImage {
	display: none;
}
.imagePreview {
	position: relative;
	display: inline-block;
	width: 100px;
	height: 100px;
	-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
	background-image: url(../_img/add-image.png);
	cursor: pointer;
	margin-left: 10px;
}
.imagePreview DIV {
	width:100%;
	height:100%;
	background-position: center center;
	background-size: cover;
}
A.deleteImage {
	position:absolute;
	top:2px;
	right:2px;
	display:block;
}


#imagePreview {
    width: 180px;
    height: 180px;
    background-position: center center;
    background-size: cover;
    -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
    display: inline-block;
}
</style>

<script src="_scripts/ajaxupload.js" type="text/javascript"></script>
<SCRIPT type="text/javascript">
$(document).ready(function(){
	// Load image file
	$(".imagePreview").click(function(){
		$(this).next().click();
	});
	// Preview after choosing a file
	$(".inputImage").change(function(){
		var file = this.files[0];
		preview = $(this).prev();
		if (file.type.match(/image.*/)) {
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onloadend = function() {
				$(preview).find("DIV").css("background-image", "url("+this.result+")");
				$(preview).find(".deleteImage").show();
			}
		} else {
			alert ("Sorry : your file is not an image");
		}
	});
	// Remove file and preview
	$(".deleteImage").click(function(){
		preview = $(this).parent();
		$(preview).children("DIV").css("background-image", "none"); // Remove image
		$(preview).children(".deleteImage").hide(); // Hide delete link
		$(preview).next().val(""); // Reset input file
		return false;
	});

	$("#uploadFile").on("change", function() {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file 
            reader.onloadend = function(){ // set image data as background of div
                $("#imagePreview").css("background-image", "url("+this.result+")");
            }
        }
    });
});
</SCRIPT>

<!-- InstanceEndEditable -->
<!--ZOOMSTOP-->
</head>

<body class="fr">

<DIV class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
	<DIV class="modal-dialog">
		<DIV class="modal-content">
			<?php 
			$showModal = false;
			if (isset($_POST['contactWebredactor'])) {
				require $_SERVER['DOCUMENT_ROOT']."/modal/contact.php";
				$showModal = true;
			}
			?>
		</DIV>
	</DIV>
</DIV>
<?php
if ($showModal) {
?>
<SCRIPT type="text/javascript">
jQuery(document).ready(function(){
	$("#myModal").modal('show');
});
</SCRIPT>
<?php
}
?>

<?php include $_SERVER['DOCUMENT_ROOT']."/_includes/feedback.php" ?>

<header>
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<?php include $_SERVER['DOCUMENT_ROOT']."/fr/_includes/navbar.php" ?>
		</div>
	</nav>
</header>

<div id="FrameNavigation">
	<?php include $_SERVER['DOCUMENT_ROOT']."/_includes/nav.php" ?>
	<?php include $_SERVER['DOCUMENT_ROOT']."/fr/_includes/services.php" ?>
</div>

<div id="FrameContent">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<?php include $_SERVER['DOCUMENT_ROOT']."/_includes/flash.php" ?>
			</div>
		</div>
		<div class="row">
			<!-- InstanceBeginEditable name="BREADCRUMP" -->
			<?php showPath() ?>
			<!-- InstanceEndEditable -->
			
			
			<H1 class="pageTitle"><?php echo $THIS_PAGE['name'] ?></H1>
			
			<div class="col-sm-12">
				<?php include $_SERVER['DOCUMENT_ROOT']."/_includes/alerts.php" ?>
			</div>
		</div>
		<div class="row" id="ThisIsThePageContent">
			<!--ZOOMRESTART-->
			
			<div class="col-sm-12 col-limited">
				<!-- InstanceBeginEditable name="CONTENT-SIZED" -->
				<?php
				if (isset($_POST['save'])) {
					print_r($_POST);
				}
				?>
				<P>Recherche d'un composant JavaScript pour un <em>upload friendly</em> de fichiers images.</P>
				<h2>Chargement d'une image sans voir le input file</h2>
				<p>Utilisation d'une vignette [+], agissant à la place d'un input file, et utilisant FileReader comme ci-dessous.</p>
				<FORM method="post">
					<?php for ($i=1; $i<=3; $i++) { ?>
					<DIV id="previewImage_<?= $i ?>" class="imagePreview" image-id="<?= $i ?>">
						<DIV></DIV>
						<A href="javascript:void(0);" class="deleteImage btn btn-xs btn-danger" style="display:none;"><SPAN class="glyphicon glyphicon-trash"></SPAN></A>
					</DIV>
					<INPUT type="file" name="image_<?= $i ?>" class="inputImage">
					<?php } ?>
					<BR>
					<BUTTON type="submit" name="save">Save</BUTTON>
				</FORM>
				<h2>How to show image thumbnail before upload with jQuery</h2>
				<p><a href="http://www.phpgang.com/how-to-show-image-thumbnail-before-upload-with-jquery_573.html" target="_blank">www.phpgang.com/how-to-show-image-thumbnail-before-upload-with-jquery_573.html</a></p>
				<p>Démo (fonctionne) : <a href="http://demo.phpgang.com/jquery-show-image-thumbnail-before-upload/" target="_blank">demo.phpgang.com/jquery-show-image-thumbnail-before-upload/</a></p>
				<p>A propos de FileReader : <a href="http://blog.teamtreehouse.com/reading-files-using-the-html5-filereader-api" target="_blank">blog.teamtreehouse.com/reading-files-using-the-html5-filereader-api</a></p>
				<div id="imagePreview"></div>
				<input id="uploadFile" name="image" class="img" type="file">
				<!-- InstanceEndEditable -->
			</div>
			
			
			
			<!--ZOOMSTOP-->
		</div>
	</div>
</div>

</body>
<!-- InstanceEnd --></html>