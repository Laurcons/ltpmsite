

var currentPage = 0;

$(document).ready(function() {

	ajax_updateUtilizatori();

});

function ajax_updateUtilizatori() {

	$.ajax({
		url: "?p=admin:utilizatori&ajax&r=utilizatori&epp=200&pag=" + currentPage,
		dataType: "json",
		success: function(result) {

			utilizatori = result.utilizatori;

			var template = $("#utilizatori-table-row-template").html();

			result.utilizatori.forEach(function(item, index) {

				item.nrcrt = index+1;
				item.isProfesor = (item.Functie == "profesor") ? true : false;
				item.isElev = (item.Functie == "elev") ? true : false;

			});

			var output = "";
			result.utilizatori.forEach(function(item, index) {

				output += Mustache.render(template, item);

			});

			$("#utilizatori-table-rows").html(output);

		}

	});

}