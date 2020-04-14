
// https://stackoverflow.com/questions/1349404/generate-random-string-characters-in-javascript
// copiata direct din /portal/subpagini/clase.js.php
function generateKey(length = 10) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

function validate_creeaza_clasa() {

	var nivel = $("#creeaza-clasa-form-nivel").val();
	var sufix = $("#creeaza-clasa-form-sufix").val();

	if ((nivel < 0 || nivel > 12) || nivel.trim() == "") {
		// invalid
		showFormError("creeaza-clasa", "denumire", "Nivelul trebuie sa fie o cifra araba de la 0 la 12!");
		return false;

	}
	if (sufix.trim() == "") {
		showFormError("creeaza-clasa", "denumire", "Sufixul clasei nu poate fi gol!");
		return false;
	}
	return true;

}

$(document).ready(function() {

	$("#creeaza-clasa-form").submit(function(e) {

		e.preventDefault();
		if (!validate_creeaza_clasa())
			return false;
		hideFormErrors();
		var form = $(this);
		$("#creeaza-clasa-form-form-id").val(generateKey());

		$.ajax({
			url: form.attr("action"),
			method: form.attr("method"),
			data: form.serialize(),
			success: function() {

				$("#creeaza-clasa-modal").modal("hide");
				ajax_updateClase();

			}
		})

	});

	$("#sterge-clasa-form").submit(function(e) {

		e.preventDefault();
		var form = $(this);
		$("#sterge-clasa-form-form-id").val(generateKey());

		$.ajax({

			url: form.attr("action"),
			method: "POST",
			data: form.serialize(),
			success: function() {

				$("#sterge-clasa-modal").modal("hide");
				ajax_updateClase();

			}

		});

	});

	ajax_updateClase();

});

function ajax_updateClase() {

	$("#clase-list").html('\
			<div class="spinner-border text-primary"></div>');

	$.ajax({
		url: "?p=admin:clase&ajax&r=clase",
		dataType: "json",
		success: function(result) {

			var clasa_template = $("#clasa-template").html();
			var clase_obj = result;
			var result_html = "";

			var event_handlers = [];

			clase_obj.clase.forEach(function(elem, index) {

				if (index % 3 == 0)
					result_html += "<div class='row'>";

				result_html += Mustache.render(clasa_template, elem);

				if (index % 3 == 2)
					result_html += "</div>";

				// prepare event handlers
				// they can't be added right now because the corresponding ID's don't exist
				//  in the DOM yet
				event_handlers.push({

					id: "sterge-clasa-button-" + elem.Id,
					event: "click",
					handler: function() {

						$("#sterge-clasa-form-clasa-id").val(elem.Id);
						$("#sterge-clasa-modal").modal("show");

					}

				});

			});

			$("#clase-list").html(result_html);
			// attach event handlers
			event_handlers.forEach(function(elem) {

				$("#" + elem.id).on(elem.event, elem.handler);

			});

		}

	});

	// actualizeaza tot ce tine de profesorii disponibili (din #creeaza-clasa-modal)
	$.ajax({
		url: "?p=admin:clase&ajax&r=profesori-disponibili",
		dataType: "json",
		success: function(result) {

			//console.log(result.profesori_disponibili.length);
			if (result.profesori_disponibili.length != 0) {

				$("#creeaza-clasa-modal-content").html(
					$("#creeaza-clasa-modal-allowed-template").html()
				);

				// completeaza profesorii disponibili
				result.profesori_disponibili.forEach(function(item, index) {

					$("#creeaza-clasa-form-idprofesor").append(
						"<option value=\"" + item.Id + "\">" + item.Nume + " " + item.Prenume + "</option>"
					);

				});

			} else {

				$("#creeaza-clasa-modal-content").html(
					$("#creeaza-clasa-modal-disallowed-template").html()
				);

			}

		}

	});

}