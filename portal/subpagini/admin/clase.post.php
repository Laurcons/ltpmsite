<?php

$db = new db_connection();

$response = new stdClass();

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

			$response->status = "success";

		} else if (isset($_POST["sterge-clasa"])) {

			$db->delete_clasa($_POST["clasa-id"]);

			$response->status = "success";

		} else if (isset($_POST["atribuie-utilizator"])) {

			try {
				$db->update_utilizator_set_clasa($_POST["user-id"], $_POST["clasa-id"]);
			} catch (Exception $e) {
				$response->status = "exception";
				$response->exception = $e;
			}

			$response->status = "success";

		} else if (isset($_POST["deatribuie-utilizator"])) {

			$db->update_utilizator_set_clasa($_POST["user-id"], NULL);

			$response->status = "success";

		} else if (isset($_POST["adauga-predare"])) {

			$db->insert_predare(array(
				"IdMaterie" => $_POST["materie"],
				"IdProfesor" => $_POST["profesor"],
				"IdClasa" => $_POST["clasa-id"]
			));

			$response->status = "success";

		} else {

			$response->status = "request-not-found";

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