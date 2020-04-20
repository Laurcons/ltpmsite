

// asta e aici ca sa mearga tooltipurile
$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});

function daysInMonth (month, year) {
    return new Date(year, month, 0).getDate();
}

function month_to_special_html(month) {

	var roman_code = 8543;
	roman_code += month;
	return String.fromCharCode(roman_code);
	//("&#" + roman_code + ";").text();

}

function hideDiv(selector) {

	var cls = $(selector).attr("class");
	cls += " d-none";
	$(selector).attr("class", cls);

}

function showDiv(selector) {

	var cls = $(selector).attr("class");
	cls = cls.split("d-none").join("");
	$(selector).attr("class", cls);

}

function hideErrors() {

	hideDiv("#noteaza-modal-server-error");
	hideDiv("#noteaza-modal-validation-error");
	hideDiv("#adauga-absenta-validation-error");
	hideDiv("#adauga-absenta-server-error");

}

function setNoteazaValidationError(message) {

	showDiv("#noteaza-modal-validation-error");
	$("#noteaza-modal-validation-error").html(message);

}

function setAdaugaAbsentaValidationError(message) {

	showDiv("#adauga-absenta-validation-error");
	$("#adauga-absenta-validation-error").html(message);

}

function linkNotaToForms(nota_id, elev_id) {

	$("#anuleaza-nota-" + nota_id).click(function() {

		// completeaza formul
		$("#anuleaza-nota-form-user-id").attr("value", elev_id);
		$("#anuleaza-nota-form-nota-id").attr("value", nota_id);
		$("#anuleaza-nota-form-form-id").attr("value", generateKey());


	});

}

function linkAbsentaToForms(elev_id, absenta_id) {

	$("#motiveaza-absenta-" + absenta_id).click(function() {

		// completeaza formul
		$("#motiveaza-absenta-form-user-id").attr("value", elev_id);
		$("#motiveaza-absenta-form-absenta-id").attr("value", absenta_id);
		$("#motiveaza-absenta-form-form-id").attr("value", generateKey());

	});
	$("#anuleaza-absenta-" + absenta_id).click(function() {

		// completeaza formul
		$("#anuleaza-absenta-form-elev-id").attr("value", elev_id);
		$("#anuleaza-absenta-form-form-id").attr("value", generateKey());
		$("#anuleaza-absenta-form-absenta-id").attr("value", absenta_id);


	});

}

function linkElevToNoteazaModal(elev_id) {

	$("#note-plus-" + elev_id).click(function() {

		$("#noteaza-modal-user-id").attr("value", elev_id);
		$("#noteaza-modal").modal("show");
		hideErrors();

	});

}

function linkElevToAdaugaAbsentaModal(elev_id) {

	$("#absente-plus-" + elev_id).click(function() {

		$("#adauga-absenta-form-elev-id").attr("value", elev_id);
		$("#adauga-absenta-modal").modal("show");
		hideErrors();

	})

}

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

	$("#anuleaza-nota-modal").on("show.bs.modal", function(e) {

		var dataobj = JSON.parse($(e.relatedTarget).data("nota-json").split("\\\"").join("\""));
		$("#anuleaza-nota-modal-body [data-name='nota']")
			.html(dataobj.Nota);
		$("#anuleaza-nota-modal-body [data-name='data']")
			.html(dataobj.Ziua + " " + "&#x216" + (dataobj.Luna-1).toString(16));
		$("#anuleaza-nota-form [name='nota-id']")
			.val(dataobj.Id);
		hideFormErrors("anuleaza-nota");

	});

	$("#anuleaza-nota-form").submit(function(e) {

		e.preventDefault();

		appendLoadingIndicator("[form='anuleaza-nota-form'][type='submit']");
		hideFormErrors("anuleaza-nota");

		$.ajax({
			url: "/portal/clase/post",
			data: $(this).serialize(),
			method: "POST",
			dataType: "json",
			success: function(result) {

				if (result.status == "success") {

					$("#anuleaza-nota-modal").modal("hide");
					ajax_updateElevi();

				} else if (result.status == "password-failed") {

					showFormError("anuleaza-nota", "password", "Parola este incorecta!");

				} else {

					console.error("AJAX status: " + result.status);

				}

			},
			error: function(req, text) {
				console.error("AJAX error: " + text);
			},
			complete: function() {
				updateFormIds();
				$("[form='anuleaza-nota-form'][type='submit']")
					.children("span")	
						.remove();
			}

		});

	});

	// ajax request pentru motivarea absentei din dropdown
	$("#motiveaza-absenta-form").submit(function(e) {

		e.preventDefault();

		// fa ajax si motiveaza
		$.ajax({
			url: "6",
			data: $(this).serialize(),
			method: "POST",
			success: function() {

				var user_id = $("#motiveaza-absenta-form-user-id").attr("value");
				ajax_updateAbsente(user_id);

			}


		})

	});

	$("#adauga-absenta-form").submit(function(e) {

		e.preventDefault();

		hideErrors();

		$("#adauga-absenta-form-form-id").attr("value", generateKey());

		if (!validateNoteazaModal()) {
			return;
		}

		$.ajax({
			url: "7",
			data: $(this).serialize(),
			method: "POST",
			success: function() {

				var user_id = $("#adauga-absenta-form-elev-id").attr("value");
				ajax_updateAbsente(user_id);

				$("#adauga-absenta-modal").modal("hide");

			},
			error: function() {

				showDiv("#adauga-absenta-server-error");

			}
		});

	});

	$("#anuleaza-absenta-form").submit(function(e) {

		e.preventDefault();

		$("#anuleaza-absenta-form-form-id").attr("value", generateKey());

		$.ajax({
			url: "8",
			data: $(this).serialize(),
			method: "POST",
			success: function() {

				var user_id = $("#anuleaza-absenta-form-elev-id").attr("value");
				ajax_updateAbsente(user_id);

			}

		});

	});

});	
