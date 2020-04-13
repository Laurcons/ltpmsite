<?php

$db = new db_connection();

$response = new stdClass();

if (isset($_POST["form-id"])) {

	if (!isset($_SESSION["form-id"]) ||
		(isset($_SESSION["form-id"]) && $_POST["form-id"] != $_SESSION["form-id"])) {
	
		$_SESSION["form-id"] = $_POST["form-id"];

		if (isset($_POST["cod-inreg"])) {

		    $newCod = '';

		    // tot genereaza pana e unic
		    do {
			    for($i = 0; $i < 6; $i++) {
			        $newCod .= mt_rand(($i == 0) ? 1 : 0, 9);
			    }
			} while ($db->retrieve_utilizator_where_cod_inregistrare("Id", $newCod) != null);

		    $db->update_utilizator_cod_inregistrare($_POST["user-id"], $newCod);

		    $response->status = "success";
		    $response->newCod = $newCod;

		} else
		if (isset($_POST["update-general"])) {

			$utiliz = $db->retrieve_utilizator_where_id("Functie,Autoritate,Nume,Prenume,Email,NrMatricol,Username", $_POST["user-id"]);

			$utiliz["Functie"] = $_POST["functie"];
			$utiliz["Autoritate"] = $_POST["autoritate"];

			$db->update_utilizator_general_settings($_POST["user-id"], $utiliz);

		    $response->status = "success";

		} else
		if (isset($_POST["update-altele"])) {

			$utiliz = $db->retrieve_utilizator_where_id("Functie,Autoritate,Nume,Prenume,Email,NrMatricol,Username", $_POST["user-id"]);

			$utiliz["Nume"] = $_POST["nume"];
			$utiliz["Prenume"] = $_POST["prenume"];
			$utiliz["Email"] = $_POST["email"];
			$utiliz["NrMatricol"] = $_POST["nr-matricol"];
			$utiliz["Username"] = $_POST["username"];

			$db->update_utilizator_general_settings($_POST["user-id"], $utiliz);

		    $response->status = "success";

		} else if (isset($_POST["adauga-utilizator"])) {

			$avail = $db->is_username_available($_POST["username"]);

			if ($avail) {

				$db->insert_utilizator([
					"Nume" => $_POST["nume"],
					"Prenume" => $_POST["prenume"],
					"Username" => $_POST["username"],
					"Email" => $_POST["email"],
					"Autoritate" => $_POST["autoritate"],
					"Functie" => $_POST["functie"],
					"IdClasa" => (isset($_POST["is-inserted-into-class"])) ? $_POST["insert-into-class"] : "-1"
				]);

			    $response->status = "success";

			} else $response->status = "username-taken";

		} else if (isset($_POST["adauga-predare"])) {

			$db->insert_predare(array(
				"IdProfesor" => $_POST["user-id"],
				"IdClasa" => $_POST["clasa"],
				"IdMaterie" => $_POST["materie"]
			));

			$response->status = "success";

		} else if (isset($_POST["sterge-predare"])) {

			$db->delete_predare($_POST["predare-id"]);

			$response->status = "success";

		} else {
			$response->status = "no-action-specified";
		}

	} else {

		$response->status = "form-id-failed";

	}

}

header("Content-type: text/json");
echo(json_encode($response));

?>