
$(document).ready(function() {

	updateFormIds();

	if (utilizator_functie == "profesor")
		ajax_updateMaterii();

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
			url: "/portal/admin/utilizatori/post",
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
			url: "/portal/admin/utilizatori/post",
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
			url: "/portal/admin/utilizatori/post",
			method: "POST",
			data: {
				"form-id": generateKey(),
				"user-id": urlId(),
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

	$("#adauga-materie-modal").on("show.bs.modal", function() {

		ajax_updateAdaugaMaterieModal();

	});

	$("#adauga-materie-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[type='submit'][form='adauga-materie-form']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "/portal/admin/utilizatori/post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#adauga-materie-modal").modal("hide");
					ajax_updateMaterii();
		
				} else {
					console.error("AJAX status: " + result.status);
				}
		
			},
			error: function(req, err) {
				console.error("AJAX error: " + err);
			},
			complete: function() {
				updateFormIds();
				$("[type='submit'][form='adauga-materie-form']")
					.children("span")
						.remove();
			}
		
		});

	});

	$("#sterge-materie-modal").on("show.bs.modal", function(e) {

		var button = $(e.relatedTarget);
		var predareid = button.data("materie-id");
		$("#sterge-materie-form")
			.children("[name='materie-id']")
				.val(predareid);

	});

	$("#sterge-materie-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[type='submit'][form='sterge-materie-form']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "/portal/admin/utilizatori/post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#sterge-materie-modal").modal("hide");
					ajax_updateMaterii();

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
				$("[type='submit'][form='sterge-materie-form']")
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
			url: "/portal/admin/utilizatori/post",
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

function ajax_updateMaterii() {

	$("#materii-rows")
		.html(
			$("<div>")
				.addClass("row border border-bottom-0 p-3")
				.css("height", ($("#materii-rows").height() > 0) ? $("#materii-rows").height() : "auto")
				.html(
					$("<span>")
						.addClass("spinner-border text-primary")));

	$.ajax({
		url: "/portal/admin/utilizatori/ajax/materii?id=" + urlId(),
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {

				// creeaza obiectul cu mustache
				var template = $("#materie-row-template").html();
				var output = "";

				result.materii.forEach(function(materie, i) {

					materie.nrcrt = i + 1;
					switch (materie.TipTeza) {
						case "nu": materie.tipTeza = "Nu se da teza"; break;
						case "optional": materie.tipTeza = "Teza e la alegere"; break;
						case "obligatoriu": materie.tipTeza = "Teza e obligatorie"; break;
					}

					output += Mustache.render(template, materie);

				});

				if (result.materii.length == 0) {
					$("#materii-rows")
						.html(
							$("<div>")
								.addClass("row border border-bottom-0 p-2 px-3")
								.html("Profesorul nu preda la nicio clasa."));
				} 
				else $("#materii-rows").html(output);
	
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

function ajax_updateAdaugaMaterieModal() {

	$("#adauga-materie-modal-spinner").removeClass("d-none");

	// memoreaza pozitiile curente din selecturi
	var selectedClasa = $("[form='adauga-materie-form'][name='clasa'] option:selected").val();
	if (selectedClasa == null)
		selectedClasa = 0;

	// sterge toate intrarile
	$("[form='adauga-materie-form'][name='materie']").empty();
	$("[form='adauga-materie-form'][name='clasa']").empty();

	$.ajax({
		url: "/portal/admin/utilizatori/ajax/adauga-materie-data",
		dataType: "json",
		success: function(result) {
	
			if (result.status == "success") {
	
				// populeaza clasele
				result.clase.forEach(function(item, index) {

					$("[form='adauga-materie-form'][name='clasa']")
						.append(
							$("<option>")
								.attr("value", item.Id)
								.html("Clasa " + item.Nivel + "-" + item.Sufix + ", diriginte " + item.diriginte.Nume + " " + item.diriginte.Prenume));

				});

				// pune selectiile de dinainte de request
				$("[form='adauga-materie-form'][name='clasa']")
					.val(selectedClasa);
	
			} else {
				console.error("AJAX status: " + result.status);
			}
	
		},
		error: function(req, err) {
			console.error("AJAX error: " + err);
		},
		complete: function() {
			$("#adauga-materie-modal-spinner").addClass("d-none");
		}
	
	});

}

function ajax_updateStergeUtilizatorModal() {

	// loading indicator
	$("div[data-variant]").addClass("d-none");
	$("[data-variant='loading']").removeClass("d-none");
	$("[form='sterge-utilizator-form'][type='submit']").prop("disabled", true);

	$.ajax({
		url: "/portal/admin/utilizatori/ajax/is-diriginte?id=" + urlId(),
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