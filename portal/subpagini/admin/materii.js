
function validate_adauga_materie() {

	var nume = $("#adauga-materie-form-nume").val();

	if (nume.trim() == "") {
		showFormError("adauga-materie", "nume", "Denumirea nu poate fi goala!");
		return false;
	}

	return true;

}

$(document).ready(function() {

	updateFormIds();

	$("#adauga-materie-modal").on("show.bs.modal", function() {

		hideFormErrors("adauga-materie");

	});

	$("#adauga-materie-form").submit(function(e) {

		e.preventDefault();
		if (!validate_adauga_materie())
			return false;
		hideFormErrors("adauga-materie");
		var form = $(this);

		$.ajax({
			url: "?p=admin:materii&post",
			method: "POST",
			data: form.serialize(),
			success: function() {

				ajax_updateMaterii();
				$("#adauga-materie-modal").modal("hide");

			},
			complete: function() {
				updateFormIds();
			}

		})

	});

	$("#sterge-materie-form").submit(function(e) {

		e.preventDefault();

		hideFormErrors("sterge-materie");

		$.ajax({
			url: "?p=admin:materii&post",
			method: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function(result) {

				if (result.status == "success") {

					ajax_updateMaterii();
					$("#sterge-materie-modal").modal("hide");

				} else if (result.status == "password-failed") {

					showFormError("sterge-materie", "password", "Parola este incorecta!");

				}

			},
			complete: function() {

				updateFormIds();

			}

		});

	});

	$("#sterge-materie-modal").on("show.bs.modal", function(e) {

		$("#sterge-materie-form-materie-id").val(
			$(e.relatedTarget).data("materie-id")
		);
		$("#sterge-materie-modal-nume-materie").html(
			$(e.relatedTarget).data("nume-materie")
		);

	});

	ajax_updateMaterii();

});

function ajax_updateMaterii() {

	// display loading indicator
	$("#table-rows").html(
		"<div class=\"row border p-2\"><div class=\"col-md-12\"><span class=\"spinner-border text-dark\"></span></div></div>");

	$.ajax({
		url: "?p=admin:materii&ajax&r=materii",
		dataType: "json",
		success: function(response) {

			// fill with mustache
			var output = "";
			var template = $("#table-row-template").html();

			response.materii.forEach(function(item, index) {

				item.nrcrt = index + 1;
				if (item.profesori.length == 0)
					item.profesori.push({Id: -1, Nume: "<niciunul>", Prenume: ""});
				item.profesoriStr = item.profesori
					.map(elem => elem.Nume + " " + elem.Prenume)
					.join(", ");
				output += Mustache.render(template, item);

			});

			$("#table-rows").html(output);

		}

	});

}