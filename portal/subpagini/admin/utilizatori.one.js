

function getId() {

	var searchParams = new URLSearchParams(window.location.search);
	return searchParams.get("id");

}

$(document).ready(function() {

	$("select[data-unsave='update-general']").change(function() {

		$("#update-general-unsaved-alert").collapse("show");

	});

	$("#update-general-form").submit(function(e) {

		e.preventDefault();

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