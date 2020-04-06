
$(document).ready(function() {

	ajax_updateMaterii();

});

function ajax_updateMaterii() {

	// display loading indicator
	$("#table-rows").html(
		"<div class=\"row border p-2\"><div class=\"col-md-12\"><span class=\"spinner-border text-dark\"></span></div></div>");

	$.ajax({
		url: "?p=admin:materii&ajax&r=materii",
		dataType: "json",
		success: function(response) {

			// fill with mustache
			var output = "";
			var template = $("#table-row-template").html();

			response.materii.forEach(function(item, index) {

				item.nrcrt = index + 1;
				item.profesoriStr = item.profesori
					.map(elem => elem.Nume + " " + elem.Prenume)
					.join(", ");
				output += Mustache.render(template, item);

			});

			$("#table-rows").html(output);

		}

	});

}