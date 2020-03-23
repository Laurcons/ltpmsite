
$(document).ready(function() {

	ajax_updateClase();

});

function ajax_updateClase() {

	$.ajax({
		url: "?p=admin:clase&ajax&r=clase",
		data: "json",
		success: function(result) {

			var clasa_template = $("#clasa-template").html();
			var clase_obj = JSON.parse(result);
			var result_html = "";

			clase_obj.clase.forEach(function(elem, index) {

				if (index % 3 == 0)
					result_html += "<div class='row'>";

				result_html += Mustache.render(clasa_template, elem);

				if (index % 3 == 2)
					result_html += "</div>";

			});

			$("#clase-list").html(result_html);

		}


	});

}