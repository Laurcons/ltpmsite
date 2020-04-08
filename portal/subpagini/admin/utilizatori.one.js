
$(document).ready(function() {

	$("select[data-unsave='update-general']").change(function() {

		$("#update-general-unsaved-alert").collapse("show");

	});

	$("#update-general-form").submit(function(e) {

		e.preventDefault();

	});

});