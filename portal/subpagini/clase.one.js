

var elevToUpdate = {id: "all", index: 0};

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

function ajax_updateElevi(elev_id = "all", elev_index = 0) {

	var updatedElement = (elev_id != "all" ? $("div.row[data-elev-id='" + elev_id + "']") : $("#elevi-rows"));

	updatedElement
		.html(
			$("<div>")
				.addClass((elev_id != "all" ? "" : "row col border border-top-0 p-3"))
				.css("height", (updatedElement.height() > 0) ? updatedElement.height() : "auto")
				.html(
					$("<span>")
						.addClass("spinner-border text-primary")));

	var elev_work = function(elev, index) {

		elev.nrcrt = index + 1;
		var lunaRoman = function() {
			return "&#x216" + (this.Luna-1).toString(16);
		}
		elev.note.forEach(function(nota) {
			nota.lunaRoman = lunaRoman;
			nota.json = JSON.stringify(nota).split("\"").join("\\\"");
			nota.numeElev = elev.Nume + " " + elev.Prenume;
			nota.isOral = nota.Tip == "oral";
			nota.isTest = nota.Tip == "test";
			nota.isTeza = nota.Tip == "teza";
		});
		elev.absente.forEach(function(absenta) {
			absenta.lunaRoman = lunaRoman;
		});
		if (elev.media_sem1 == 0)
			elev.media_sem1 = "-";
		if (elev.media_sem2 == 0)
			elev.media_sem2 = "-";
		if (elev.media_gen == 0)
			elev.media_gen = "-";
		// faza cu .49
		if (parseInt((elev.media_sem1 - parseInt(elev.media_sem1)) * 100) == 49 ||
			parseInt((elev.media_sem2 - parseInt(elev.media_sem2)) * 100) == 49 ||
			parseInt((elev.media_gen - parseInt(elev.media_gen)) * 100) == 49)
			elev.mediaAlert = true;
		else elev.mediaAlert = false;

	};

	$.ajax({ // url-ul merge si pentru elevi si pentru un singur elev
		url: "/portal/clase/ajax/" + (elev_id != "all" ? "elev" : "elevi") + "?id=" + urlId() + "&pid=" + urlId() + (elev_id != "all" ? "&uid=" + elev_id : "") +
			"&sem=" + semestru,
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {
	
				// pune cu mustache
				var template = $("#elev-row-template").html();
				updatedElement.empty();

				if (elev_id == "all") {

					result.elevi.forEach(function(elev, elev_i) {

						elev_work(elev, elev_i);

						updatedElement
							.append(
								Mustache.render(template, elev));

					});

				} else {

					elev_work(result.elev, elev_index);

					updatedElement
						.html(
							$($.parseHTML(Mustache.render(template, result.elev))).filter("div").html());

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

function ajax_updatePreferinteTezaModal() {

	$("#preferinte-teza-modal-table")
		.html(
			$("<span>")
				.addClass("spinner-border text-primary"));

	$.ajax({
		url: "/portal/clase/ajax/teze?pid=" + urlId(),
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {

				var template = $("#preferinte-teza-row-template").html();
	
				result.elevi.forEach(function(elev, index) {

					elev.nrcrt = index + 1;

					$("#preferinte-teza-modal-table")
						.append(
							Mustache.render(template, elev));

					if (elev.teza)
						$("#preferinta-teza-modal-elev-" + elev.Id + "-da")
							.prop("checked", true);
					else 
						$("#preferinta-teza-modal-elev-" + elev.Id + "-nu")
							.prop("checked", true);

				});
	
			} else {
				console.error("AJAX status: " + result.status);
			}
	
		},
		error: function(req, err) {
			console.error("AJAX error: " + err);
		},
		complete: function() {
			$("#preferinte-teza-modal-table")
				.children("span")
					.remove();
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
					ajax_updateElevi(elevToUpdate.id, elevToUpdate.index);

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

		var related = $(e.relatedTarget);

		var elev_id = related.data("elev-id");
		$("#noteaza-form [name='elev-id']")
			.val(elev_id);
		$("#noteaza-modal-body span[data-for='nume']")
			.html(related.data("elev-nume"));
		hideFormErrors("noteaza");

		if (related.data("elev-has-teza") == true) {
			$("#noteaza-modal-teza")
				.removeClass("d-none");
		} else {
			$("#noteaza-modal-teza")
				.addClass("d-none");
		}

		elevToUpdate.id = related.closest(".elev-row").data("elev-id");
		elevToUpdate.index = related.closest(".elev-row").data("elev-index");

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
			elevToUpdate.id = $(e.relatedTarget).closest(".elev-row").data("elev-id");
			elevToUpdate.index = $(e.relatedTarget).closest(".elev-row").data("elev-index");
		},
		on_ajax_success: function(result, modal) {
			ajax_updateElevi(elevToUpdate.id, elevToUpdate.index);
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
		on_open: function(e) {
			elevToUpdate.id = $(e.relatedTarget).closest(".elev-row").data("elev-id");
			elevToUpdate.index = $(e.relatedTarget).closest(".elev-row").data("elev-index");
		},
		on_ajax_success: function(result, modal) {
			ajax_updateElevi(elevToUpdate.id, elevToUpdate.index);
			modal.modal("hide");
		},
		on_ajax_nonsuccess: function(result) {
			if (result.status == "exception") {
				showFormError("adauga-absenta", "form", "Absenta nu a putut fi trecuta. Probabil exista o absenta pe aceeasi data?");
			}
		}
	});

	// anuleaza absenta
	createModalForm({
		modal: $("#anuleaza-absenta-modal"),
		form: $("#anuleaza-absenta-form"),
		formErrorName: "anuleaza-absenta",
		action: "/portal/clase/post",
		bind_data: ["absenta-id"],
		on_open: function(e) {
			$("#anuleaza-absenta-form")[0].reset();
			var ziuasidata = $(e.relatedTarget).data("absenta-data").split(" ");
			$("#anuleaza-absenta-modal-body [data-name='data']")
				.html(ziuasidata[0] + " " + "&#x216" + (ziuasidata[1]-1).toString(16));
			elevToUpdate.id = $(e.relatedTarget).closest(".elev-row").data("elev-id");
			elevToUpdate.index = $(e.relatedTarget).closest(".elev-row").data("elev-index");
		},
		on_ajax_success: function(result, modal) {
			ajax_updateElevi(elevToUpdate.id, elevToUpdate.index);
			modal.modal("hide");
		},
		on_ajax_nonsuccess: function(result) {
			if (result.status == "password-failed") {
				showFormError("anuleaza-nota", "password", "Parola este incorecta!");
			}
		}
	});

	// motiveaza, nu se poate face cu createModalForm
	// eventul e pe document pentru ca butoanele astea, la momentul asta nu exista in DOM
	$(document).on("click", "[data-action='motiveaza-absenta']", function(e) {

		e.preventDefault();

		var button = $(this);

		$("#motiveaza-absenta-form [name='absenta-id']")
			.val(
				button.data("absenta-id"));

		// pune un loading indicator pe nota
		button.closest(".dropdown").children(".absenta")
			.html(
				$("<span>")
					.addClass("spinner-border spinner-border-sm text-dark"));

		$.ajax({
			url: "/portal/clase/post",
			method: "POST",
			dataType: "json",
			data: $("#motiveaza-absenta-form").serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					elevToUpdate.id = button.closest("div.elev-row").data("elev-id");
					elevToUpdate.index = button.closest("div.elev-row").data("elev-index");

					ajax_updateElevi(elevToUpdate.id, elevToUpdate.index);
		
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

	// preferinte teza
	createModalForm({
		modal: $("#preferinte-teza-modal"),
		form: $("#preferinte-teza-form"),
		action: "/portal/clase/post",
		on_open: ajax_updatePreferinteTezaModal,
		on_ajax_success: function(result, modal) {
			ajax_updateElevi();
			modal.modal("hide");
		}

	});

});	
