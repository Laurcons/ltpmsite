
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

$(document).ready(function() {

	$("#adauga-materie-form").submit(function(e) {

		e.preventDefault();
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

				$("#adauga-materie-form-form-id").val(generateKey());

			}

		})

	});

	$("#sterge-materie-form").submit(function(e) {

		e.preventDefault();

		$.ajax({
			url: "?p=admin:materii&post",
			method: "POST",
			data: $(this).serialize(),
			success: function() {

				ajax_updateMaterii();
				$("#sterge-materie-modal").modal("hide");

			},
			complete: function() {

				$("#sterge-materie-form-form-id").val(generateKey());

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