
function getId() {
	var get = new URLSearchParams(location.search);
	return get.get("id");
}

$(document).ready(function() {

	ajax_updateElevi();
	ajax_updatePredari();

});

function ajax_updateElevi() {

	// pune aia rotitoare ca se incarca
	$("#elevi-div").html("<div class='spinner-border m-2'></div>");

	var idClasa = getId();

	$.ajax({
		url: "?p=admin:clase&ajax&r=elevi&id=" + idClasa,
		dataType: "json",
		success: function(result) {

			// pune datele auxiliare
			for (var i = 0; i < result.elevi.length; i++) {

				result.elevi[i].first = (i == 0) ? true : false;
				result.elevi[i].nrcrt = i + 1; 

			}

			// pune prin mustache
			var output = "";
			result.elevi.forEach(function(item, index) {

				var rendered = Mustache.render($("#elev-template").html(), item);
				output += rendered;

			});

			if (result.elevi.length == 0) {
				output = "<div class='row border p-2'><div class='col-md-12'>Nu exista elevi in clasa!</div></div>";
			}

			$("#elevi-div").html(output);

		}

	});

}

function ajax_updatePredari() {

	// pune aia rotitoare ca se incarca
	$("#predari-div").html("<div class='spinner-border m-2'></div>");

	var idClasa = getId();

	$.ajax({
		url: "?p=admin:clase&ajax&r=predari&id=" + idClasa,
		dataType: "json",
		success: function(result) {

			// pune datele auxiliare
			for (var i = 0; i < result.predari.length; i++) {

				result.predari[i].first = (i == 0) ? true : false;
				result.predari[i].nrcrt = i + 1; 

			}

			// pune prin mustache
			var output = "";
			result.predari.forEach(function(item, index) {

				var rendered = Mustache.render($("#predare-template").html(), item);
				output += rendered;

			});

			if (result.predari.length == 0) {
				output = "<div class='row border p-2'><div class='col-md-12'>Nu exista predari in clasa!</div></div>";
			}

			$("#predari-div").html(output);

		}

	});

}