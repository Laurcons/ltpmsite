
$(document).ready(function() {

	$("#inregistrare-form-form-id").val(generateKey());

	$("#submit-cod-inregistrare").click(function() {

		$("#submit-cod-inregistrare").html(
			"Continua " + "<span class='spinner-border spinner-border-sm'></span>");
		hideFormErrors("inregistrare-form");

		var cod = $("#inregistrare-form-cod-inregistrare").val();

		$.ajax({
			url: "?p=inreg&ajax&r=cod-inreg",
			method: "POST",
			data: {
				cod: cod
			},
			dataType: "json",
			success: function(result) {

				if (result.utilizator == null) {

					showFormError("inregistrare-form", "cod", "Codul de inregistrare dat nu exista in baza de date! ");

				} else {

					// avanseaza la urmatorul pas
					$("#inregistrare-form-username").attr("placeholder", result.utilizator.Username);
					$("#inregistrare-form-username").attr("value", "");
					$("#inregistrare-form-nume").attr("value", result.utilizator.Nume);
					$("#inregistrare-form-prenume").attr("value", result.utilizator.Prenume);
					$("#inregistrare-form-email").attr("value", result.utilizator.Email);
					$("#detalii-functie").html(result.utilizator.Functie);
					$("#detalii-autoritate").html(result.utilizator.Autoritate == "normal" ? "normala" : "admin");
					if (result.utilizator.clasa != null) {
						$("#detalii-clasa").html(result.utilizator.clasa.Nivel + " " + result.utilizator.clasa.Sufix);
					} else {
						$("#detalii-clasa").html("&lt;neatribuit&gt;");
					}
					$("#detalii-functie-clasa").html(result.utilizator.Functie == "elev" ? "elev" :
													 result.utilizator.Functie == "profesor" ? "diriginte" : "?");
					$("#inregistrare-form-user-id").val(result.utilizator.Id);
					$("#collapse-step1").collapse("hide");
					$("#collapse-step2").collapse("show");

				}

			},
			complete: function() {

				$("#submit-cod-inregistrare").html(
					"Continua");

			}

		}); // ajax

	}); // submit cod inregistrare event

	$("#prev-step2").click(function() {

		$("#collapse-step2").collapse("hide");
		$("#collapse-step1").collapse("show");

	});

	$("#inregistrare-form").submit(function(e) {

		e.preventDefault();
		hideFormErrors("inregistrare-form");
		if (!validate_inregistreaza_form())
			return;

		$("#submit-inregistrare").html(
			"Inregistrare " + "<span class='spinner-border spinner-border-sm'></span>");
		hideFormErrors("inregistrare-form");

		$.ajax({
			url: "?p=inreg&post",
			method: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function(result) {

				if (result.status == "success") {
					$("#submit-inregistrare").prop("disabled", true);
					$("#submit-inregistrare").html("Asteptati...");

					window.location = "?p=logare&src=inreg";
				}

			},
			complete: function() {

				$("#inregistrare-form-form-id").val(generateKey());

			}

		});

	});

});

function validate_inregistreaza_form() {

	var username = $("#inregistrare-form-username").val().trim();
	var password = $("#inregistrare-form-password").val().trim();
	var confirmPassword = $("#inregistrare-form-confirm-password").val().trim();
	var rex = /^[a-zA-Z0-9_]+$/;

	if (username == "") {

		showFormError("inregistrare-form", "username", "Trebuie sa alegeti un nume de utilizator! Acesta poate fi unul simplu, precum nume_prenume.");
		return false;

	}
	if (!rex.test(username)) {

		showFormError("inregistrare-form", "username", "Numele dvs de utilizator contine caractere nepermise! Puteti folosi doar literele alfabetului englez, numere, si caracterul <kbd>_</kbd>.");
		return false;

	}
	if (password == "") {

		showFormError("inregistrare-form", "passwords", "Va rugam sa alegeti o parola!");
		return false;

	}
	if (password != confirmPassword) {

		showFormError("inregistrare-form", "passwords", "Parolele dvs nu coincid! Va rugam sa le rescrieti!");
		return false;

	}

	return true;

}