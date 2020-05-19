

$(document).ready(function() {

	updateFormIds();
	ajax_updateElevi();
	ajax_updateMaterii();

	$("#atribuie-utilizator-modal").on("show.bs.modal", function() {

		ajax_updateAdaugaElevModal();

	});

	$("#deatribuie-utilizator-modal").on("show.bs.modal", function(e) {

		var button = $(e.relatedTarget);

		$("#deatribuie-utilizator-form")
			.children("[name='user-id']")
				.val(button.data("user-id"));

	});

	$("#atribuie-utilizator-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[form='atribuie-utilizator-form'][type='submit']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "/portal/admin/clase/post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#atribuie-utilizator-modal").modal("hide");
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
				$("[form='atribuie-utilizator-form'][type='submit']")
					.children("span")
						.remove();
			}
		
		});

	});

	$("#deatribuie-utilizator-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[form='deatribuie-utilizator-form'][type='submit']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "/portal/admin/clase/post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#deatribuie-utilizator-modal").modal("hide");
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
				$("[form='deatribuie-utilizator-form'][type='submit']")
					.children("span")
						.remove();
			}
		
		});

	});

	$("#adauga-materie-modal").on("show.bs.modal", function() {

		ajax_updateAdaugaMaterieModal();

	});

	$("#adauga-materie-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		$("[form='adauga-materie-form'][type='submit']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "/portal/admin/clase/post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#adauga-materie-modal").modal("hide");
					ajax_updateMaterii();
		
				} else {
					console.error("AJAX status: " + result.status);
				}
		
			},
			error: function(req, err) {
				console.error("AJAX error: " + err);
			},
			complete: function() {
				updateFormIds();
				$("[form='adauga-materie-form'][type='submit']")
					.children("span")
						.remove();
			}
		
		});

	});

	$("#sterge-materie-modal").on("show.bs.modal", function(e) {

		$("#sterge-materie-form input[name='materie-id']")
			.val($(e.relatedTarget).data("materie-id"));

	});

	$("#sterge-materie-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		appendLoadingIndicator("[form='sterge-materie-form'][type='submit']");

		$.ajax({
			url: "/portal/admin/clase/post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("#sterge-materie-modal").modal("hide");
					ajax_updateMaterii();
		
				} else {
					console.error("AJAX status: " + result.status);
				}
		
			},
			error: function(req, err) {
				console.error("AJAX error: " + err);
			},
			complete: function() {
				updateFormIds();
				$("[form='sterge-materie-form'][type='submit']")
					.children("span")
						.remove();
			}
		
		});

	});

	$("#schimba-diriginte-modal").on("show.bs.modal", function(e) {

		ajax_updateSchimbaDiriginteModal();

	});

	$("#schimba-diriginte-form").submit(function(e) {

		e.preventDefault();

		// loading indicator
		appendLoadingIndicator("[form='schimba-diriginte-form'][type='submit']");

		$.ajax({
			url: "/portal/admin/clase/post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {
		
				if (result.status == "success") {
		
					$("[form='schimba-diriginte-form'][type='submit']")
						.prop("disabled", true)
						.html("Asteptati...");
					window.location = window.location;
		
				} else {
					console.error("AJAX status: " + result.status);
				}
		
			},
			error: function(req, err) {
				console.error("AJAX error: " + err);
			},
			complete: function() {
				$("[form='schimba-diriginte-form'][type='submit']")
					.children("span")
						.remove();
			}
		
		});

	});

});

function ajax_updateElevi() {

	// pune aia rotitoare ca se incarca
	$("#elevi-div").html("<div class='spinner-border m-2'></div>");

	var idClasa = urlId();

	$.ajax({
		url: "/portal/admin/clase/ajax/elevi-clasa?id=" + idClasa,
		dataType: "json",
		success: function(result) {

			// pune datele auxiliare
			for (var i = 0; i < result.elevi.length; i++) {

				result.elevi[i].first = (i == 0) ? true : false;
				result.elevi[i].nrcrt = i + 1; 

			}

			// pune prin mustache
			var output = "";
			result.elevi.forEach(function(item, index) {

				var rendered = Mustache.render($("#elev-template").html(), item);
				output += rendered;

			});

			if (result.elevi.length == 0) {
				output = "<div class='row border p-2'><div class='col-md-12'>Nu exista elevi in clasa!</div></div>";
			}

			$("#elevi-div").html(output);

		}

	});

}

function ajax_updateMaterii() {

	// pune aia rotitoare ca se incarca
	$("#materii-div").html("<div class='spinner-border m-2'></div>");

	var idClasa = urlId();

	$.ajax({
		url: "/portal/admin/clase/ajax/materii?id=" + idClasa,
		dataType: "json",
		success: function(result) {

			// pune datele auxiliare
			for (var i = 0; i < result.materii.length; i++) {

				result.materii[i].first = (i == 0) ? true : false;
				result.materii[i].nrcrt = i + 1; 

			}

			// pune prin mustache
			var output = "";
			result.materii.forEach(function(item, index) {

				switch (item.TipTeza) {
					case "nu": item.tipTeza = "Nu se da teza"; break;
					case "optional": item.tipTeza = "Teza e la alegere"; break;
					case "obligatoriu": item.tipTeza = "Teza e obligatorie"; break;
				}

				var rendered = Mustache.render($("#materie-template").html(), item);
				output += rendered;

			});

			if (result.materii.length == 0) {
				output = "<div class='row border p-2'><div class='col-md-12'>Nu exista materii in clasa!</div></div>";
			}

			$("#materii-div").html(output);

		}

	});

}

function ajax_updateAdaugaElevModal() {

	// loading indicator
	$("#atribuie-utilizator-modal-spinner")
		.removeClass("d-none");

	// goleste selectul
	$("[form='atribuie-utilizator-form'][name='user-id']")
		.empty();

	$.ajax({
		url: "/portal/admin/clase/ajax/elevi-disponibili",
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {
	
				// populeaza selectul
				result.elevi.forEach(function(item, index) {

					$("[form='atribuie-utilizator-form'][name='user-id']")
						.append(
							$("<option>")
								.attr("value", item.Id)
								.html(item.Nume + " " + item.Prenume + " (" + item.Username + ")"));

				});
				if (result.elevi.length == 0) {
					$("#atribuie-utilizator-modal-unavailable")
						.removeClass("d-none");
					$("[form='atribuie-utilizator-form'][type='submit']")
						.prop("disabled", true);
				} else {
					$("#atribuie-utilizator-modal-unavailable")
						.addClass("d-none");
					$("[form='atribuie-utilizator-form'][type='submit']")
						.prop("disabled", false);
				}
	
			} else {
				console.error("AJAX status: " + result.status);
			}
	
		},
		error: function(req, err) {
			console.error("AJAX error: " + err);
		},
		complete: function() {
			updateFormIds();
				$("#atribuie-utilizator-modal-spinner")
					.addClass("d-none");
		}
	
	});

}

function ajax_updateAdaugaMaterieModal() {

	$("#adauga-materie-modal-spinner")
		.removeClass("d-none");
	$("select[form='adauga-materie-form'][name!='tip-teza']")
		.empty();
	$("[form='adauga-materie-form'][type='submit']")
		.prop("disabled", true);

	$.ajax({
		url: "/portal/admin/clase/ajax/adauga-materie-data",
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {
	
				// fill select
				result.profesori.forEach(function(item, index) {

					$("[form='adauga-materie-form'][name='profesor']")
						.append(
							$("<option>")
								.attr("value", item.Id)
								.html(item.Nume + " " + item.Prenume));

				});

				$("[form='adauga-materie-form'][type='submit']")
					.prop("disabled", false);
	
			} else {
				console.error("AJAX status: " + result.status);
			}
	
		},
		error: function(req, err) {
			console.error("AJAX error: " + err);
		},
		complete: function() {
			$("#adauga-materie-modal-spinner")
				.addClass("d-none");
		}
	
	});

}

function ajax_updateSchimbaDiriginteModal() {

	$("[form='schimba-diriginte-form'][name='profesor']")
		.empty();

	$.ajax({
		url: "/portal/admin/clase/ajax/diriginti-disponibili",
		method: "GET",
		dataType: "json",
		//data: ,
		success: function(result) {
	
			if (result.status == "success") {
	
				result.profesori.forEach(function(item, index) {

					$("[form='schimba-diriginte-form'][name='profesor']")
						.append(
							$("<option>")
								.val(item.Id)
								.html(item.Nume + " " + item.Prenume + " (" + (item.clasa == null ? "nu este diriginte" : "diriginte al " + item.clasa.Nivel + "-" + item.clasa.Sufix) + ")"));

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