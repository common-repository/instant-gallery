jQuery( document ).ready(function() {
	jQuery("a.group").fancybox({
		'nextEffect'	:	'fade',
		'prevEffect'	:	'fade',
		'overlayOpacity' :  0.8,
		'overlayColor' : '#000000',
		'arrows' : false,
	});	
	
	var instagram_ig = jQuery('#instagram-photos');
	// initialize
	instagram_ig.masonry({
		itemSelector: '.instagram-photo'
	});		
});