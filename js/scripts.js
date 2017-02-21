(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';
		
		// DOM ready, take it away
		
		/*$(".main-nav").tinyNav({
		  active: 'on',
		  header: 'Navigation', 		  
		  label: ''
		});*/
		
		$('.main-nav').addClass('active');
		jQuery('.toggle-nav').click(function(e) {
	        jQuery(this).toggleClass('active');
	        jQuery('.menu ul.main-nav').toggleClass('active');
	 
	        e.preventDefault();
	    });
		
	});
	
})(jQuery, this);
