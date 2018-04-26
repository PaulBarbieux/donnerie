jQuery(document).ready(function(){
	// Packery instance
	var $gridPackery = $('.grid')
	var pckr = $gridPackery.data('packery');
	// Infinite scroll
	$gridPackery.infiniteScroll({
		path: ".paginator .page-next",
		append: ".grid-item",
		prefill: true,
		outlayer: pckr,
		hideNav: ".paginator"
	});
	// Last page hit
	$(".infinite-scroll-last").hide();
	$gridPackery.on( 'last.infiniteScroll', function() {
		$(".infinite-scroll-last").show();
	});
});
