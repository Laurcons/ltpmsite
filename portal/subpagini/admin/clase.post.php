<?php

$db = new db_connection();

if (isset($_POST["form-id"])) {

	if (!isset($_SESSION["form-id"]) ||
		(isset($_SESSION["form-id"]) && $_POST["form-id"] != $_SESSION["form-id"])) {

		if (isset($_POST["creeaza-clasa"])) {

			$clasa = array();
			$clasa["Nivel"] = $_POST["nivel"];
			$clasa["Sufix"] = $_POST["sufix"];
			$clasa["IdDiriginte"] = $_POST["iddiriginte"];
			$clasa["AnScolar"] = $_POST["an"];

			$db->insert_clasa($clasa);

		}

		if (isset($_POST["sterge-clasa"])) {

			$db->delete_clasa($_POST["clasa-id"]);

		}

	}

}

?>