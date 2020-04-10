

var currentPage = 0; // indexat cu 0
var entriesPerPage = 5;

var pagination_pages = null;

$(document).ready(function() {

	// pune templateurile la auxiliarele tabelului
	$("[data-tag='table-aux'")
		.html($("#table-auxiliaries-template").html());

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