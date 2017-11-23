jQuery(document).ready(function(){
	/*
		Type of announce
	*/
	$("[name='type']").change(function(){
		if ($(this).val() == "d") {
			$("#input-state").show(300);
			$("#state").val("");
		} else {
			$("#input-state").hide(300);
			$("#state").val("new");
		}
	});
	/*
		Image management
	*/
	// Address of add image symbol
	addImageSrc = $("#image-add-src").val();
	// Trigger file input browsing by clicking on thumb
	$(".image-preview").click(function(){
		$(this).next().click();
	});
	// Preview after choosing a file using FileReader API
	$("INPUT[type='file']").change(function(){
		if (this.files == undefined) {
			alert($("#error_old_browser").val());
		} else {
			var file = this.files[0];
			preview = $(this).prev();
			currentImgFile = $(this).parent().find("INPUT[type='hidden']");
			if (file.type.match(/image.*/)) {
				var reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onloadend = function() {
					$(preview).find("IMG").attr("src",this.result); // Show image
					$(preview).find(".deleteImage").show(); // Show delete link
					$(currentImgFile).val(""); // Remove current image address (edit mode)
				}
			} else {
				alert ($("#error_not_image").val());
			}
		}
	});
	// Remove file and preview
	$(".deleteImage").click(function(){
		preview = $(this).parent();
		$(preview).find("IMG").attr('src',addImageSrc); // Set add image symbol
		$(preview).children(".deleteImage").hide(); // Hide delete link
		$(preview).parent().find("INPUT").val(""); // Reset input(s) file
		return false;
	});
});