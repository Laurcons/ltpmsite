<?php

$db = new db_connection();

$response = new stdClass();

if (isset($_POST["form-id"])) {

	if (!isset($_SESSION["form-id"]) ||
		(isset($_SESSION["form-id"]) && $_POST["form-id"] != $_SESSION["form-id"])) {

		if (isset($_POST["adauga-materie"])) {

			$db->insert_materie(array("Nume" => $_POST["nume"]));

			$response->status = "success";

		}

		if (isset($_POST["sterge-materie"])) {

			// verifica parola

			$user = $db->retrieve_utilizator_where_id("Id,Parola", $_POST["admin-id"]);
			$passwordCorrect = password_verify($_POST["password"], $user["Parola"]);

			if ($passwordCorrect) {

				$db->delete_materie($_POST["materie-id"]);

				$response->status = "success";

			} else {

				$response->status = "password-failed";

			}

		}

	} else {

		$response->status = "form-id-failed";

	}

} else {

	$response->status = "form-id-not-found";

}

header("Content-type: application/json");
echo(json_encode($response));

?>