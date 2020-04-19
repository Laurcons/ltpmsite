
$(document).ready(function() {

	ajax_updatePredari();

});

function ajax_updatePredari() {

	// loading indicator
	$("#clase-cards")
		.html(
			$("<div>")
				.addClass("row")
				.html(
					$("<span>")
						.addClass("spinner-border text-primary ml-5")));

	$.ajax({
		url: "?p=clase&ajax&r=predari",
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {

				$("#clase-cards").html("");
	
				// pune cu mustache
				var template = $("#clasa-card-template").html();
				result.predari.forEach(function(item, index) {

					$("#clase-cards")
						.append(
							$("<div>")
								.addClass("col mb-3")
								.html(
									Mustache.render(template, item)));

				});
	
			} else {
				console.error("AJAX status: " + result.status);
			}
	
		},
		error: function(req, err) {
			console.error("AJAX error: " + err);
		},
		complete: function() {
	
		}
	
	});

}