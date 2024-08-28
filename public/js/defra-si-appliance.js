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
		
		$(".edit-si-appliance").click(function (e) {
			let deid = document.getElementById('deid');
			let denumber = document.getElementById('denumber');
			let delink = document.getElementById('delink');
			let countryTerms = document.getElementById('countryTerms');

			let decountries = $(this).data("decountries");
			// Loop through each option in the select element
			for (let i = 0; i < countryTerms.options.length; i++) {
				let option = countryTerms.options[i];
				option.selected = false;
				// Check if the option's value is in the selectedItems array
				if (decountries.includes(parseInt(option.value))) {
					option.selected = true;
				}
			}

			deid.value = $(this).data("deid");
			denumber.value = $(this).data("denumber");
			delink.value = $(this).data("delink");

		});

		// Add an event listener to the button to submit the form
		document.getElementById('saveChanges').addEventListener('click', function() {
			document.getElementById('siForm').submit(); // Submit the form
		});

		// $.ajax({
			// 	url: d.ajax_url,
			// 	type: "POST",
			// 	data: {
			// 		action: "defra_assign_link",
			// 		defra_assign: nonce,
			// 		post_id: post_id,
			// 		user_id: user_id,
			// 		revoked: revoked,
			// 		role: role,
			// 	},
			// 	success: function (response) {
			// 		document.location.href = response;
			// 	},
			// });

	});
})(jQuery);
