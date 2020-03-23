<script>

// asta e aici ca sa mearga tooltipurile
$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
});

// https://stackoverflow.com/questions/1349404/generate-random-string-characters-in-javascript
function generateKey(length = 10) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

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

		setNoteazaValidationError("Luna nu are atatea zile!");
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

function ajax_updateNote(elev_id) {

	// actualizeaza notele din pagina
	$.ajax({url: "?p=clase&ajax&r=note&uid=" + elev_id +
			"&mid=<?= $materie['Id'] ?>&sem=1",
		dataType: "html",
		success: function(result) {

			// pune cu Mustache detaliile
			var note_obj_inner = JSON.parse(result);
			var note_obj = {};
			note_obj.note = note_obj_inner;
			note_obj.size = 6.35;
			note_obj.cursor = "pointer";
			var templ = $("#nota-list-template").html();
			// converteste lunile
			note_obj.note = note_obj.note.map(function(item) {

				item.Luna = month_to_special_html(item.Luna);
				if (item.Ziua < 10)
					item.Ziua = "0" + item.Ziua;
				return item;

			});

			$("#note-" + elev_id).html(
				Mustache.render(templ, note_obj)
			);

		}
	});

}

function ajax_updateAbsente(elev_id) {

	$.ajax({url: "?p=clase&ajax&r=absente&uid=" + elev_id +
		"&mid=<?= $materie['Id'] ?>&sem=1",
		dataType: "html",
		success: function(result) {

			// pune absentele cu Mustache
			var absente_obj_inner = JSON.parse(result);
			var absente_obj = {};
			absente_obj.absente = absente_obj_inner;
			absente_obj.size = 4.75;
			absente_obj.cursor = "pointer";
			var template = $("#absenta-list-template").html();
			// converteste lunile
			absente_obj.note = absente_obj.absente.map(function(item) {

				item.Luna = month_to_special_html(item.Luna);
				if (item.Ziua < 10)
					item.Ziua = "0" + item.Ziua;
				return item;

			});

			$("#absente-" + elev_id).html(
				Mustache.render(template, absente_obj)
			);

		}

	});

}

$(document).ready(function() {

	// configureaza un AJAX request pentru modalul noteaza
	$("#noteaza-modal-form").submit(function(e) {

		e.preventDefault(); // avoid default submit behaviour

		hideErrors();

		// regenereaza form-id-ul
		$("#noteaza-modal-form-id").attr("value", generateKey());

		if (!validateNoteazaModal()) {
			return;
		}

		//console.log("called");

		$.ajax({
			method: "POST",
			data: $(this).serialize(),
			url: "<?= $post_href ?>",
			success: function(result) {

				// obtine user-id-ul pentru a actualiza notele din pagina
				var elev_id = $("#noteaza-modal-user-id").attr("value");

				ajax_updateNote(elev_id);

				// ascunde modalul
				$("#noteaza-modal").modal("hide");

			},
			error: function(xhr, text) {

				showDiv("#noteaza-modal-server-error");

			}

		});

	});

	// ajax request pentru anularea notei din dropdown
	$("#anuleaza-nota-form").submit(function(e) {

		e.preventDefault();

		// fa ajax si sterge nota
		$.ajax({
			url: "<?= $post_href ?>",
			data: $(this).serialize(),
			method: "POST",
			success: function() {

				var user_id = $("#anuleaza-nota-form-user-id").attr("value");
				ajax_updateNote(user_id);

			}

		});

	});

	// ajax request pentru motivarea absentei din dropdown
	$("#motiveaza-absenta-form").submit(function(e) {

		e.preventDefault();

		// fa ajax si motiveaza
		$.ajax({
			url: "<?= $post_href ?>",
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
			url: "<?= $post_href ?>",
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
			url: "<?= $post_href ?>",
			data: $(this).serialize(),
			method: "POST",
			success: function() {

				var user_id = $("#anuleaza-absenta-form-elev-id").attr("value");
				ajax_updateAbsente(user_id);

			}

		});

	});

});	

</script>