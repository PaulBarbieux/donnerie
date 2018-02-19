jQuery(document).ready(function() {
	// Contact toggle
	$("#contact-block > A").click(function(){
		$("#contact-block > FORM").toggle(300);
	});
	// Avoid double-click and show waiting animation
	$("FORM").submit(function(){
		$(this).find("[type='submit']").attr('disabled',true);
		$(".waiting-animation").show();
		return true;
	});
});