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
		var edit = $(".edit");
		var save = $(".save");
		var del = $(".delete");

		edit.on("click", function (e) {
			//e.preventDefault();
			do_toggles($(this));
		});

		save.on("click", function (e) {
			e.preventDefault();
			do_toggles($(this));
			var id = $(this).data("id");
			var type = $(this).data("type");
			var input = $("#input-" + id).val();
			var action = $(this).data("action");
			//debugger;
			jQuery.post(
				defra_object.ajax_url,
				{
					action: action,
					input: input,
					id: id,
					type: type,
					nextNonce: defra_object.nextNonce,
				},
				function (response) {
					var input = $("#input-" + id).val();
					$("#output-" + id).html(input);
				}
			);
		});

		del.on("click", function (e) {
			e.preventDefault();
			var d = confirm("Delete data?");
			if (d) {
				var id = $(this).data("id");
				var type = $(this).data("type");
				var action = $(this).data("action");
				jQuery.post(
					defra_object.ajax_url,
					{
						action: action,
						id: id,
						type: type,
						nextNonce: defra_object.nextNonce,
					},
					function (response) {
						var rendered = $("#rendered-" + id);
						$(rendered).remove();
					}
				);
			}
		});

		/**
		 * Generic toggling function where n is the id and input output classes are present
		 * @param obj of $(this) from jquery
		 */
		function do_toggles(obj) {
			var n = obj.data("id");
			var s = $("#save-" + n);
			$("#input-" + n).toggleClass("show");
			$("#output-" + n).toggleClass("hide");
			$(s).toggleClass("show");
		}

		$(document).ready(function () {
			$("#table_id").DataTable();

			$(".js-example-basic-single").select2({
				minimumInputLength: 2,
				placeholder: {
					id: "0",
					text: "Select a manufacturer",
				},
			});
			$(".js-multiple").select2({
				minimumInputLength: 2,
				multiple: true,
				allowClear: true,
				placeholder: "Select a footnote",
			});
			$(".js-multiple-fuel").select2({
				minimumInputLength: 2,
				multiple: true,
				allowClear: true,
				placeholder: "Select a fuel",
			});
			$(".js-multiple-si").select2({
				minimumInputLength: 2,
				multiple: true,
				allowClear: true,
				placeholder: "Select a Statutory Instrument",
			});

			// const updateform = document.getElementById("update");
			// const deletePost = document.getElementById("delete-post");
			// if (deletePost) {
			// 	// Add a submit event listener to the updateform
			// 	updateform.addEventListener("submit", function (event) {
			// 		// Prevent the updateform from submitting immediately
			// 		event.preventDefault();

			// 		// Ask for user confirmation
			// 		const userConfirmed = confirm(
			// 			"Do you really want to delete the data?"
			// 		);

			// 		// Continue with the updateform submission if the user confirms
			// 		if (userConfirmed) {
			// 			updateform.submit(); // Submit the updateform programmatically
			// 		} else {
			// 			alert("You chose to cancel!");
			// 		}
			// 	});
			// } else {
			// 	console.log("Submit button not found.");
			// }
		});
	});
})(jQuery);
