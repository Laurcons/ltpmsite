

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

	$("#adauga-predare-modal").on("show.bs.modal", function() {

		ajax_updatePredareModal();

	});

	$("#adauga-predare-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[type='submit'][form='adauga-predare-form']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "?p=admin:utilizatori&post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#adauga-predare-modal").modal("hide");
					ajax_updatePredari();
		
				} else {
					console.error("AJAX status: " + result.status);
				}
		
			},
			error: function(req, err) {
				console.error("AJAX error: " + err);
			},
			complete: function() {
				updateFormIds();
				$("[type='submit'][form='adauga-predare-form']")
					.children("span")
						.remove();
			}
		
		});

	});

	$("#sterge-predare-modal").on("show.bs.modal", function(e) {

		var button = $(e.relatedTarget);
		var predareid = button.data("predare-id");
		$("#sterge-predare-form")
			.children("[name='predare-id']")
				.val(predareid);

	});

	$("#sterge-predare-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[type='submit'][form='sterge-predare-form']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "?p=admin:utilizatori&post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#sterge-predare-modal").modal("hide");
					ajax_updatePredari();

				} else {
					console.error("AJAX status: " + result.status);
				}
		
			},
			error: function(req, err) {
				console.error("AJAX error: " + err);
			},
			complete: function() {
				updateFormIds();
				// sterge loading indicatoru
				$("[type='submit'][form='sterge-predare-form']")
					.children("span")
						.remove();
			}
		
		});

	});

	$("#sterge-utilizator-modal").on("show.bs.modal", function(e) {

		ajax_updateStergeUtilizatorModal();

	});

	$("#sterge-utilizator-username").on("input", function(e) {

		// verifica daca e acelasi cu numele de utilizator
		var val = $(this).val().trim();
		if (val == utilizator_username) {
			$("[form='sterge-utilizator-form'][type='submit']").prop("disabled", false);
		} else {
			$("[form='sterge-utilizator-form'][type='submit']").prop("disabled", true);
		}

	});

	$("#sterge-utilizator-form").submit(function(e) {

		e.preventDefault();

		appendLoadingIndicator("[form='sterge-utilizator-form'][type='submit']");
		hideFormErrors("sterge-utilizator");

		$.ajax({
			url: "?p=admin:utilizatori&post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {

					$("[form='sterge-utilizator-form'][type='submit']")
						.html("Asteptati...")
						.prop("disabled", true);
					window.location = "?p=admin:utilizatori";
					
				} else if (result.status == "password-failed") {

					showFormError("sterge-utilizator", "form", "Parola este incorecta!");
		
				} else {
					console.error("AJAX status: " + result.status);
				}
		
			},
			error: function(req, err) {
				console.error("AJAX error: " + err);
			},
			complete: function() {
				updateFormIds();
				$("[form='sterge-utilizator-form'][type='submit']")
					.children("span")
						.remove();
			}
		
		});

	});

});

function ajax_updatePredari() {

	$("#predari-rows")
		.html(
			$("<div>")
				.addClass("row border border-bottom-0 p-3")
				.css("height", ($("#predari-rows").height() > 0) ? $("#predari-rows").height() : "auto")
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

						row.hasMaterie = i_clasa == 0;
						row.materie = materie;
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

function ajax_updatePredareModal() {

	$("#adauga-predare-modal-spinner").removeClass("d-none");

	// memoreaza pozitiile curente din selecturi
	var selectedMaterie = $("[form='adauga-predare-form'][name='materie'] option:selected").val();
	var selectedClasa = $("[form='adauga-predare-form'][name='clasa'] option:selected").val();

	// sterge toate intrarile
	$("[form='adauga-predare-form'][name='materie']").empty();
	$("[form='adauga-predare-form'][name='clasa']").empty();

	$.ajax({
		url: "?p=admin:utilizatori&ajax&r=adauga-predare-data",
		dataType: "json",
		success: function(result) {
	
			if (result.status == "success") {
	
				// populeaza materiile
				result.materii.forEach(function(item, index) {

					$("[form='adauga-predare-form'][name='materie']")
						.append(
							$("<option>")
								.attr("value", item.Id)
								.html(item.Nume));

				});

				// populeaza clasele
				result.clase.forEach(function(item, index) {

					$("[form='adauga-predare-form'][name='clasa']")
						.append(
							$("<option>")
								.attr("value", item.Id)
								.html("Clasa " + item.Nivel + "-" + item.Sufix + ", diriginte " + item.diriginte.Nume + " " + item.diriginte.Prenume));

				});

				// pune selectiile de dinainte de request
				$("[form='adauga-predare-form'][name='materie']")
					.val(selectedMaterie);
				$("[form='adauga-predare-form'][name='clasa']")
					.val(selectedClasa);
	
			} else {
				console.error("AJAX status: " + result.status);
			}
	
		},
		error: function(req, err) {
			console.error("AJAX error: " + err);
		},
		complete: function() {
			$("#adauga-predare-modal-spinner").addClass("d-none");
		}
	
	});

}

function ajax_updateStergeUtilizatorModal() {

	// loading indicator
	$("div[data-variant]").addClass("d-none");
	$("[data-variant='loading']").removeClass("d-none");
	$("[form='sterge-utilizator-form'][type='submit']").prop("disabled", true);

	$.ajax({
		url: "?p=admin:utilizatori&ajax&r=is-diriginte&id=" + getId(),
		method: "GET",
		dataType: "json",
		success: function(result) {
	
			if (result.status == "success") {
	
				if (result.is_diriginte) {

					$("[data-variant]").addClass("d-none");
					$("div[data-variant='unavailable']").removeClass("d-none");

				} else {

					$("[data-variant]").addClass("d-none");
					$("div[data-variant='available']").removeClass("d-none");

				}
	
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