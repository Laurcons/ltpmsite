

var currentPage = 0; // indexat cu 0
var entriesPerPage = 25;

var pagination_pages = null;

$(document).ready(function() {

	// pune templateurile la auxiliarele tabelului
	$("[data-tag='table-aux'")
		.html($("#table-auxiliaries-template").html());

	// genereaza form ids
	updateFormIds();

	$("#adauga-utilizator-modal").on("show.bs.modal", function() {

		ajax_updateClaseList();
		hideFormErrors("adauga-utilizator");

	});

	$("#adauga-utilizator-form-is-inserted-into-class").click(function() {

		$("[form='adauga-utilizator-form'][name='insert-into-class']")
			.prop("disabled", ! $(this).prop("checked"));

	});

	// configureaza numericu ala de la epp
	$("[data-tag='pagination-epp']")
		.val(entriesPerPage)
		.change(function() {

			if (this.value < 3)
				this.value = 3;
			if (this.value > 200)
				this.value = 200;

			entriesPerPage = this.value;

			$("[data-tag='pagination-epp']")
				.val(entriesPerPage);

			currentPage = 0;
			ajax_updateUtilizatori(true);

	});

	// pune handling la selectu de pagina
	$("[data-pagination='utilizatori']").change(function() {

		// vezi ce pagina s-a selectat
		// nu stiu de ce sunt nevoit sa il fac asa, sigur jquery are o modalitate mai ok dar nu-mi
		//  merge frate nicicum futu-i ceapa ma-sii
		var selected = $(this).children("select").children("option:selected").data("page");
		// fa ajax
		currentPage = selected;
		ajax_updateUtilizatori(false);

	});

	$("#adauga-utilizator-form").submit(function(e) {

		e.preventDefault();

		hideFormErrors("adauga-utilizator");
		if (!validate_adaugaUtilizator())
			return;

		$("[type='submit'][form='adauga-utilizator-form']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		$.ajax({
			url: "?p=admin:utilizatori&post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {

				if (result.status == "success") {

					ajax_updateUtilizatori(true);
					$("#adauga-utilizator-modal").modal("hide");

				} else if (result.status == "username-taken") {

					showFormError("adauga-utilizator", "username", "Numele de utilizator dat exista deja! Alegeti altul!");

				} else {
					showFormError("adauga-utilizator", "submit", "A aparut o eroare necunoscuta. Va rugam incercati din nou.<br>Cod: status: " + result.status);
				}

			},
			error: function(req, err) {
				showFormError("adauga-utilizator", "submit", "A aparut o eroare necunoscuta. Va rugam incercati din nou.<br>Cod: ajax_error: " + err);
			},
			complete: function() {
				updateFormIds();
				$("[type='submit'][form='adauga-utilizator-form']")
					.children("span")
						.remove();
			}

		})

	});

	ajax_updateUtilizatori();

});

function validate_adaugaUtilizator() {

	var nume = $("[form='adauga-utilizator-form'][name='nume']").val().trim();
	var prenume = $("[form='adauga-utilizator-form'][name='prenume']").val().trim();
	var username = $("[form='adauga-utilizator-form'][name='username']").val().trim();
	var email = $("[form='adauga-utilizator-form'][name='email']").val().trim();
	var usernameRegex = /^[a-zA-Z0-9_]+$/;

	if (nume == "" || prenume == "") {

		showFormError("adauga-utilizator", "nume", "Numele si prenumele nu pot fi goale!");
		return false;

	}
	if (username == "") {
		showFormError("adauga-utilizator", "username", "Numele de utilizator nu poate fi gol!");
		return false;
	}
	if (!usernameRegex.test(username)) {
		showFormError("adauga-utilizator", "username", "Numele de utilizator poate contine doar litere ale alfabetului englez, numere si caracterul <kbd>_</kbd>!");
		return false;
	}
	if (email == "") {
		showFormError("adauga-utilizator", "email", "Adresa de e-mail nu poate fi goala!");
		return false;
	}

	return true;

}

function ajax_updatePagination(updateList = false) {

	if (pagination_pages == null)
		updateList = true;

	var updateView = function() {

		$select = 
			$("<select>")
				.addClass("form-control form-control-sm");

		pagination_pages.forEach(function(item, index) {

			$select
				.append(
					$("<option>")
						.attr("data-page", item.page)
						.html((item.page + 1) + ": " + item.first + " - " + item.last));

		});

		// adauga in divurile cu paginatie
		$("[data-pagination='utilizatori']")
			.empty();
		$("[data-pagination='utilizatori']")
			.html($select);

		// adauga event handlers
		// adaugate deja pentru tot selectul
		/*$("[data-page]").click(function() {

			currentPage = $(this).attr("data-page");
			ajax_updateUtilizatori(false);

		});*/

		// pune selected pe unde trebe
		$("option[data-page='" + currentPage + "']")
			.attr("selected", "selected");

	}

	if (updateList) {

		$.ajax({
			url: "?p=admin:utilizatori&ajax&r=utilizatori-pages&epp=" + entriesPerPage,
			dataType: "json",
			success: function(result) {

				pagination_pages = result.pages;
				updateView();

			}

		});

	} else {

		updateView();

	}

}

function ajax_updateUtilizatori(updatePaginationList = false) {

	ajax_updatePagination(updatePaginationList);

	$("[data-tag='data-loading']").removeClass("d-none");

	$.ajax({
		url: "?p=admin:utilizatori&ajax&r=utilizatori&epp=" + entriesPerPage + "&pag=" + currentPage,
		dataType: "json",
		success: function(result) {

			utilizatori = result.utilizatori;

			var template = $("#utilizatori-table-row-template").html();

			result.utilizatori.forEach(function(item, index) {

				item.nrcrt = (currentPage * entriesPerPage) + index + 1;
				item.isProfesor = (item.Functie == "profesor") ? true : false;
				item.isElev = (item.Functie == "elev") ? true : false;

			});

			var output = "";
			result.utilizatori.forEach(function(item, index) {

				output += Mustache.render(template, item);

			});

			$("#utilizatori-table-rows").html(output);

		},
		complete: function() {

			$("[data-tag='data-loading']").addClass("d-none");

		}

	});

}

function ajax_updateClaseList() {

	// indicatorul de incarcare
	$("#adauga-utilizator-modal-clase-spinner").removeClass("d-none");

	$.ajax({
		url: "?p=admin:utilizatori&ajax&r=clase-list",
		dataType: "json",
		success: function(result) {

			if (result.status == "success") {

				// creeaza obiecte si pune-le in selectul de clasa
				result.clase.forEach(function(item, index) {

					var $opt =
						$("<option>")
							.attr("value", item.Id)
							.html("Clasa  " + item.Nivel + "-" + item.Sufix + ", diriginte " + item.diriginte.Nume + " " + item.diriginte.Prenume + " (" + item.nr_elevi + " elevi)");
					$("[form='adauga-utilizator-form'][name='insert-into-class']")
						.append($opt);

				});

			} else alert("AJAX status: " + result.status);

		},
		error: function(req, err) {
			alert("AJAX error: " + err);
		},
		complete: function() {
			// indicatorul de incarcare
			$("#adauga-utilizator-modal-clase-spinner").addClass("d-none");
		}

	})

}