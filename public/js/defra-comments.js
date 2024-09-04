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

	/**
	 * remove required input if da is approving something
	 */
	$(function () {
		var approvedByDa = document.getElementById("approved-by-da");
		var approvedByDr = document.getElementById("approved-by-dr");
		var approvedRevocationByDr = document.getElementById("approve-revocation-by-dr");
		var rejectedRevocationByDa = document.getElementById("rejected-revocation-by-da");
		var approvedRevocationByDa = document.getElementById("approved-revocation-by-da");
		
		var rejectedByDr = document.getElementById("rejected-by-dr");
		var userComments = document.getElementById("user_comments");
		if(approvedByDa) {
			approvedByDa.addEventListener("click", function () {
				userComments.removeAttribute("required");
			});
		}
		if(approvedByDr) {
			var toDefraComments = document.getElementById("comments_to_defra_da");
			approvedByDr.addEventListener("click", function () {
				userComments.removeAttribute("required");
				toDefraComments.removeAttribute("required");
			});
		}

		if(approvedRevocationByDr) {
			var toDefraComments = document.getElementById("comments_to_defra_da");
			approvedRevocationByDr.addEventListener("click", function () {
				userComments.removeAttribute("required");
				toDefraComments.removeAttribute("required");
			});
		}

		if(rejectedRevocationByDa) {
		}

		if(approvedRevocationByDa) {
			approvedRevocationByDa.addEventListener("click", function () {
				userComments.removeAttribute("required");
			});
		}

		if(rejectedByDr) {
			rejectedByDr.addEventListener("click", function () {
				toDefraComments.removeAttribute("required");
			});
		}

	});
})(jQuery);
