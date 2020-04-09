<?php

$db = new db_connection();

$response = new stdClass();

if (isset($_POST["form-id"])) {

	if (!isset($_SESSION["form-id"]) ||
		(isset($_SESSION["form-id"]) && $_POST["form-id"] != $_SESSION["form-id"])) {
	
		$_SESSION["form-id"] = $_POST["form-id"];

		if (isset($_POST["inregistrare"])) {

			$data = array();
			$id = $_POST["user-id"];
			$data["Username"] = $_POST["username"];
			$data["Email"] = $_POST["email"];
			$data["Nume"] = $_POST["nume"];
			$data["Prenume"] = $_POST["prenume"];
			$data["Parola"] = password_hash($_POST["password"], PASSWORD_DEFAULT);

			$db->update_utilizator_inregistrare($id, $data);

			$response->status = "success";

		}

	} else {

		$response->status = "form-id-failed";

	}

}

header("Content-type: text/json");
echo(json_encode($response));

?>