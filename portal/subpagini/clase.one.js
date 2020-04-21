

function validateNoteazaModal() {

	var ziua = $("#noteaza-modal-ziua").children("option:selected").val();
	var luna = $("#noteaza-modal-luna").children("option:selected").val();

	var ziua_max = daysInMonth(luna, 2020); // an bisect

	if (ziua_max < ziua) {

		showFormError("noteaza", "data", "Luna nu are atatea zile!");
		return false;

	}

	return true;
}

function validateAdaugaAbsentaModal() {

	var ziua = $("#adauga-absenta-form-ziua").children("option:selected").val();
	var luna = $("#adauga-absenta-form-luna").children("option:selected").val();

	var ziua_max = daysInMonth(luna, 2020); // an bisect

	if (ziua_max < ziua) {

		setAdaugaAbsentaValidationError("Luna nu are atatea zile!");
		return false;

	}

	return true;
}

function ajax_updateElevi() {

	$("#elevi-rows")
		.html(
			$("<div>")
				.addClass("row border border-bottom-0 p-3")
				.css("height", ($("#elevi-rows").height() > 0) ? $("#elevi-rows").height() : "auto")
				.html(
					$("<span>")
						.addClass("spinner-border text-primary")));

	$.ajax({
		url: "/portal/clase/ajax/elevi?id=" + urlId(),
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {
	
				// pune cu mustache
				var template = $("#elev-row-template").html();
				$("#elevi-rows").empty();

				result.elevi.forEach(function(elev, elev_i) {

					elev.nrcrt = elev_i + 1;
					var lunaRoman = function() {
						return "&#x216" + (this.Luna-1).toString(16);
					}
					elev.note.forEach(function(nota) {
						nota.lunaRoman = lunaRoman;
						nota.json = JSON.stringify(nota).split("\"").join("\\\"");
					});
					elev.absente.forEach(function(absenta) {
						absenta.lunaRoman = lunaRoman;
					});

					$("#elevi-rows")
						.append(
							Mustache.render(template, elev));

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

$(document).ready(function() {

	ajax_updateElevi();
	updateFormIds();

	$("#noteaza-form").submit(function(e) {

		e.preventDefault();
		hideFormErrors("noteaza");
		updateFormIds();

		if (!validateNoteazaModal()) {
			return;
		}

		appendLoadingIndicator("[form='noteaza-form'][type='submit']");

		$.ajax({
			url: "/portal/clase/post",
			method: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function(result) {

				if (result.status == "success") {

					// ascunde modalul
					$("#noteaza-modal").modal("hide");
					ajax_updateElevi();

				} else if (result.status == "exception") {

					showFormError("noteaza", "form", "Nu s-a putut trece nota! Exista o nota pe aceeasi data?");

				} else {

					console.error("AJAX status: " + result.status);

				}

			},
			error: function(xhr, text) {
				console.error("AJAX error: " + text);
			},
			complete: function() {
				updateFormIds();
				$("[form='noteaza-form'][type='submit']")
					.children("span")
						.remove();
			}

		});

	});

	$("#noteaza-modal").on("show.bs.modal", function(e) {

		var elev_id = $(e.relatedTarget).data("elev-id");
		$("#noteaza-form [name='elev-id']")
			.val(elev_id);
		hideFormErrors("noteaza");

	});

	// anuleaza nota
	createModalForm({
		modal: $("#anuleaza-nota-modal"),
		form: $("#anuleaza-nota-form"),
		formErrorName: "anuleaza-nota",
		action: "/portal/clase/post",
		bind_data: ["nota-id"],
		on_open: function(e) {
			$("#anuleaza-nota-form")[0].reset();
			var dataobj = JSON.parse($(e.relatedTarget).data("nota-json").split("\\\"").join("\""));
			$("#anuleaza-nota-modal-body [data-name='nota']")
				.html(dataobj.Nota);
			$("#anuleaza-nota-modal-body [data-name='data']")
				.html(dataobj.Ziua + " " + "&#x216" + (dataobj.Luna-1).toString(16));
		},
		on_ajax_success: function(result, modal) {
			ajax_updateElevi();
			modal.modal("hide");
		},
		on_ajax_nonsuccess: function(result) {
			if (result.status == "password-failed") {
				showFormError("anuleaza-nota", "password", "Parola este incorecta!");
			}
		}
	});

	// adauga absenta
	createModalForm({
		modal: $("#adauga-absenta-modal"),
		form: $("#adauga-absenta-form"),
		formErrorName: "adauga-absenta",
		action: "/portal/clase/post",
		validator: validateAdaugaAbsentaModal,
		bind_data: ["elev-id"],
		on_ajax_success: function(result, modal) {
			ajax_updateElevi();
			modal.modal("hide");
		},
		on_ajax_nonsuccess: function(result) {
			if (result.status == "exception") {
				showFormError("adauga-absenta", "form", "Absenta nu a putut fi trecuta. Probabil exista o absenta pe aceeasi data?");
			}
		}
	});

	$(document).on("click", "[data-action='motiveaza-absenta']", function() {

		console.log("called");

		$("#motiveaza-absenta-form [name='absenta-id']")
			.val(
				$(this).data("absenta-id"));

		$.ajax({
			url: "/portal/clase/post",
			method: "POST",
			dataType: "json",
			data: $("#motiveaza-absenta-form").serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
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
			}
		
		});	

	});

});	
