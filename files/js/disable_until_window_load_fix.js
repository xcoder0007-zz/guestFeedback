/**
 * This JavaScript needs to be loaded AFTER jQuery, but BEFORE jQuery Mobile, e.g.:
 * 
 * <script src="your/path/jquery-x.x.x.min.js"></script>
 * <script src="your/path/disable_until_window_load_fix.js"></script>
 * <script src="your/path/jquery.mobile-x.x.x.min.js"></script>
 * 
 * Script adds the 'ui-disabled' class to every HTML element of class 'disable_until_window_load',
 * and removes the 'ui-disabled' class from these elements after the window has loaded.
 * 
 * This prevents the user from being able to interact with jQuery Mobile pages before
 * jQuery Mobile was able to properly process the pages, which could lead to browser crashes
 * and such.
 * 
 */

$(document).ready(function() {

	$('.disable_until_window_load').addClass('ui-disabled');

	$(window).load(function() {
		$(".disable_until_window_load").removeClass('ui-disabled');
	});
});