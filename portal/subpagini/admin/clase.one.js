
function getId() {
	var get = new URLSearchParams(location.search);
	return get.get("id");
}

$(document).ready(function() {

	updateFormIds();
	ajax_updateElevi();
	ajax_updatePredari();

	$("#atribuie-utilizator-modal").on("show.bs.modal", function() {

		ajax_updateAdaugaElevModal();

	});

	$("#deatribuie-utilizator-modal").on("show.bs.modal", function(e) {

		var button = $(e.relatedTarget);

		$("#deatribuie-utilizator-form")
			.children("[name='user-id']")
				.val(button.data("user-id"));

	});

	$("#atribuie-utilizator-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[form='atribuie-utilizator-form'][type='submit']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "?p=admin:clase&post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#atribuie-utilizator-modal").modal("hide");
					ajax_updateElevi();
		
				} else {
					console.error("AJAX status: " + result.status);
				}
		
			},
			error: function(req, err) {
				console.error("AJAX error: " + err);
			},
			complete: function() {
				updateFormIds();
				$("[form='atribuie-utilizator-form'][type='submit']")
					.children("span")
						.remove();
			}
		
		});

	});

	$("#deatribuie-utilizator-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[form='deatribuie-utilizator-form'][type='submit']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "?p=admin:clase&post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#deatribuie-utilizator-modal").modal("hide");
					ajax_updateElevi();
		
				} else {
					console.error("AJAX status: " + result.status);
				}
		
			},
			error: function(req, err) {
				console.error("AJAX error: " + err);
			},
			complete: function() {
				updateFormIds();
				$("[form='deatribuie-utilizator-form'][type='submit']")
					.children("span")
						.remove();
			}
		
		});

	});

});

function ajax_updateElevi() {

	// pune aia rotitoare ca se incarca
	$("#elevi-div").html("<div class='spinner-border m-2'></div>");

	var idClasa = getId();

	$.ajax({
		url: "?p=admin:clase&ajax&r=elevi-clasa&id=" + idClasa,
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

function ajax_updateAdaugaElevModal() {

	// loading indicator
	$("#atribuie-utilizator-modal-spinner")
		.removeClass("d-none");

	// goleste selectul
	$("[form='atribuie-utilizator-form'][name='user-id']")
		.empty();

	$.ajax({
		url: "?p=admin:clase&ajax&r=elevi-disponibili",
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {
	
				// populeaza selectul
				result.elevi.forEach(function(item, index) {

					$("[form='atribuie-utilizator-form'][name='user-id']")
						.append(
							$("<option>")
								.attr("value", item.Id)
								.html(item.Nume + " " + item.Prenume + " (" + item.Username + ")"));

				});
				if (result.elevi.length == 0) {
					$("#atribuie-utilizator-modal-unavailable")
						.removeClass("d-none");
					$("[form='atribuie-utilizator-form'][type='submit']")
						.prop("disabled", true);
				} else {
					$("#atribuie-utilizator-modal-unavailable")
						.addClass("d-none");
					$("[form='atribuie-utilizator-form'][type='submit']")
						.prop("disabled", false);
				}
	
			} else {
				console.error("AJAX status: " + result.status);
			}
	
		},
		error: function(req, err) {
			console.error("AJAX error: " + err);
		},
		complete: function() {
			updateFormIds();
				$("#atribuie-utilizator-modal-spinner")
					.addClass("d-none");
		}
	
	});

}