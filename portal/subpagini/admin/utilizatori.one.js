

function getId() {

	var searchParams = new URLSearchParams(window.location.search);
	return searchParams.get("id");

}

$(document).ready(function() {

	updateFormIds();

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

});