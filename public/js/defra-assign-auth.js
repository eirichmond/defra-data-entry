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
		const d = defra_object;
		$(".defra-assign").click(function (e) {
			e.preventDefault();
			var nonce = $(this).data("nonce");
			var post_id = $(this).data("id");
			var user_id = $(this).data("user_id");
			var revoked = $(this).data("revoked");

			var role = $(this).data("role");
			$.ajax({
				url: d.ajax_url,
				type: "POST",
				data: {
					action: "defra_assign_link",
					defra_assign: nonce,
					post_id: post_id,
					user_id: user_id,
					revoked: revoked,
					role: role,
				},
				success: function (response) {
					document.location.href = response;
				},
			});
		});
	});
})(jQuery);
