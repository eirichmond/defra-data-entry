(function ($) {
	"use strict";

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(function () {

		// Get all inputs with the class 'exempt-in'
		const exemptInputs = document.querySelectorAll('input.exempt-in');

		// Function to remove 'required' attribute from all inputs if at least one 'exempt-in' input is checked
		function checkExemptInputs() {
			// Check if at least one exempt-in input is checked
			const isAnyChecked = Array.from(exemptInputs).some(input => input.checked);
			// Get all input elements
			const allInputs = document.querySelectorAll('input[required]');
			if (isAnyChecked) {
				// Remove 'required' attribute from all input elements
				allInputs.forEach(input => input.removeAttribute('required'));
			} else {
				// Add 'required' attribute to all input elements
				exemptInputs.forEach(input => input.setAttribute('required', 'required'));
			}
		}

		// Add event listeners to all exempt-in inputs
		exemptInputs.forEach(input => {
			input.addEventListener('change', checkExemptInputs);
		});

		// Initial check in case any exempt-in inputs are already checked on page load
		checkExemptInputs();
		
	});
})(jQuery);
