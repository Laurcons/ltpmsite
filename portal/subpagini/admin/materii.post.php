<?php

var_dump($_SESSION);

$db = new db_connection();

if (isset($_POST["form-id"])) {

	if (!isset($_SESSION["form-id"]) ||
		(isset($_SESSION["form-id"]) && $_POST["form-id"] != $_SESSION["form-id"])) {

		if (isset($_POST["adauga-materie"])) {

			$db->insert_materie(array("Nume" => $_POST["nume"]));

		}

		if (isset($_POST["sterge-materie"])) {

			$db->delete_materie($_POST["materie-id"]);

		}

	}

}

?>