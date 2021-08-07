jQuery(document).ready(function(){
	// Packery instance
	var $gridPackery = $('.grid')
	var pckr = $gridPackery.data('packery');
	// Infinite scroll
	$gridPackery.infiniteScroll({
		path: ".paginator .next A",
		append: ".grid-item",
		prefill: true,
		outlayer: pckr,
		status: '.page-load-status',
		hideNav: ".paginator"
	});
});
