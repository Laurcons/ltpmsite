<?php

// functii ajutatoare, care sa manipuleze URL-ul in ceea ce priveste
//  paginile pe care utilizatorii (logati/nelogati) au/nu au acces

function redirect_if_logged_in($dest_page) {

	if (is_logged_in()) {

		header("location: " . $dest_page);

	}

}

function redirect_if_not_logged_in($dest_page) {

	if (!is_logged_in()) {

		header("location: " . $dest_page);

	}

}

function redirect_if_not_autoritate($autoritate, $dest_page) {

	redirect_if_not_logged_in($dest_page);

	if (!is_autoritate($autoritate)) {

		header("location: " . $dest_page);

	}

}

function redirect_if_not_functie($functie, $dest_page) {

	redirect_if_not_logged_in($dest_page);

	if (!is_functie($functie)) {

		header("location: " . $dest_page);
		
	}

}

function is_logged_in() {

	return (isset($_SESSION["logat"]) && $_SESSION["logat"] == true);

}

function is_functie($functie) {

	if (!is_logged_in())
		return false;

	return (isset($_SESSION["functie"]) && $_SESSION["functie"] == $functie);

}

function is_autoritate($autorit) {

	if (!is_logged_in())
		return false;

	return (isset($_SESSION["autoritate"]) && $_SESSION["autoritate"] == $autorit);

}

?>