

function getId() {

	return urlGet("id");

}

$(document).ready(function() {

	updateFormIds();

	if (utilizator_functie == "profesor")
		ajax_updatePredari();

	// alea de "modificari nesalvate"
	$("[data-unsave]").change(function() {
		$("[data-unsave-alert='" + $(this).attr("data-unsave") + "']").collapse("show");
	});

	// pune event handlers

	$("#update-general-form").submit(function(e) {

		// loading indicator
		$("[type='submit'][form='update-general-form']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		e.preventDefault();

		$.ajax({
			url: "?p=admin:utilizatori&post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			complete: function() {
				updateFormIds();
			},
			success: function(result) {

				if (result.status == "success") {

					$("[type='submit'][form='update-general-form']")
						.prop("disabled", true)
						.html("Asteptati...");
					window.location = window.location;

				}

			}

		});

	});

	$("#update-altele-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[type='submit'][form='update-altele-form']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		e.preventDefault();

		// trim spaces
		$("[form='update-altele-form']").each(function() {
			$(this).val($(this).val().trim());
		});

		$.ajax({
			url: "?p=admin:utilizatori&post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			complete: function() {
				updateFormIds();
			},
			success: function(result) {

				if (result.status == "success") {

					$("[type='submit'][form='update-altele-form']")
						.prop("disabled", true)
						.html("Asteptati...");
					window.location = window.location;

				} else {

					alert("AJAX failed: " + result.status);

				}

			}

		});

	});

	$("#generate-cod-inregistrare").click(function() {

		$("#generate-cod-inregistrare").html(
			"Genereaza " + "<span class='spinner-border spinner-border-sm'></span>");

		$.ajax({
			url: "?p=admin:utilizatori&post",
			method: "POST",
			data: {
				"form-id": generateKey(),
				"user-id": getId(),
				"cod-inreg": ""
			},
			dataType: "json",
			success: function(result) {

				if (result.status == "success") {

					$("#cod-inregistrare").val(result.newCod);

				}

			},
			complete: function() {

				$("#generate-cod-inregistrare").html("Genereaza");

			}

		});

	});

	$("#delete-utilizator-button").click(function () {

		alert("Not Implemented");

	});

});

function ajax_updatePredari() {

	$("#predari-rows")
		.html(
			$("<div>")
				.addClass("row border border-bottom-0 p-3")
				.html(
					$("<span>")
						.addClass("spinner-border text-primary")));

	$.ajax({
		url: "?p=admin:utilizatori&ajax&r=predari&id=" + getId(),
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {

				// creeaza obiectul cu mustache
				var template = $("#predare-row-template").html();
				var output = "";
				var rowCounter = 0;

				result.materii.forEach(function(materie, i_materie) {

					materie.clase.forEach(function(clasa, i_clasa) {

						var row = {};

						row.nrcrt = ++rowCounter;

						if (i_clasa == 0) {
							row.hasMaterie = true;
							row.materie = materie;
						} else row.hasMaterie = false;
						row.clasa = clasa;

						output += Mustache.render(template, row);

					});

				});

				if (result.materii.length == 0) {
					$("#predari-rows")
						.html(
							$("<div>")
								.addClass("row border border-bottom-0 p-2 px-3")
								.html("Profesorul nu preda la nicio clasa."));
				} 
				else $("#predari-rows").html(output);
	
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