/**
 * Admin scripts for Disable Gutenberg for WP
 *
 * @package DisableGutenbergForWP
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		// Select All button
		$('#dgwp-select-all').on('click', function(e) {
			e.preventDefault();
			$('.dgwp-toggle-checkbox').prop('checked', true);
		});

		// Deselect All button
		$('#dgwp-deselect-all').on('click', function(e) {
			e.preventDefault();
			$('.dgwp-toggle-checkbox').prop('checked', false);
		});
	});

})(jQuery);
