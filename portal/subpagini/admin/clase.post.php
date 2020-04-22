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
				"IdClasa" => $_POST["clasa-id"],
				"TipTeza" => $_POST["tip-teza"]
			));

			$response->status = "success";

		} else if (isset($_POST["sterge-predare"])) {

			$db->delete_predare($_POST["predare-id"]);

			$response->status = "success";

		} else if (isset($_POST["schimba-diriginte"])) {

			$clasa_id = $_POST["clasa-id"];
			$target_prof_id = $_POST["profesor"];

			// vezi daca profesorul tinta e diriginte
			$clasa_other = $db->retrieve_clasa_where_diriginte("Id,Nivel,Sufix", $target_prof_id);

			if ($clasa_other == null) {

				// profesorul tinta NU este diriginte, il punem aici
				$db->update_clasa_set_diriginte($clasa_id, $target_prof_id);
				// celalalt profesor nu mai este diriginte acum

			} else {

				// profesorul tinta ESTE diriginte, si trebuie sa facem schimbul
				// obtine dirigintele clasei curente
				$clasa_diriginte = $db->retrieve_clasa_where_id("Id,Nivel,Sufix,IdDiriginte", $clasa_id);
				// fa schimbul
				$db->update_clasa_set_diriginte($clasa_other["Id"], $clasa_diriginte["IdDiriginte"]);
				$db->update_clasa_set_diriginte($clasa_id, $target_prof_id);

			}

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