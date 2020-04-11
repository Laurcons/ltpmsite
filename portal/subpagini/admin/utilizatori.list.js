

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

	$("#adauga-utilizator-form").submit(function(e) {

		e.preventDefault();

		$("[type='submit'][form='adauga-utilizator-form']")
			.append(
				$("<span>")
					.addClass("spinner-border spinner-border-sm"));

		hideFormErrors("adauga-utilizator");

		$.ajax({
			url: "?p=admin:utilizatori&post",
			method: "POST",
			dataType: "json",
			data: $(this).serialize(),
			success: function(result) {

				if (result.status == "success") {

					ajax_updateUtilizatori(true);
					$("#adauga-utilizator-modal").modal("hide");

				} else alert("AJAX status: " + result.status);

			},
			error: function(req, err) {
				alert("AJAX error: " + err);
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
		$("[data-page]").click(function() {

			currentPage = $(this).attr("data-page");
			ajax_updateUtilizatori(false);

		});

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