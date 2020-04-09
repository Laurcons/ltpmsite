<?php

$db = new db_connection();

$response = new stdClass();

if (isset($_POST["form-id"])) {

	if (!isset($_SESSION["form-id"]) ||
		(isset($_SESSION["form-id"]) && $_POST["form-id"] != $_SESSION["form-id"])) {
	
		$_SESSION["form-id"] = $_POST["form-id"];

		if (isset($_POST["cod-inreg"])) {

		    $newCod = '';

		    for($i = 0; $i < 6; $i++) {
		        $newCod .= mt_rand(0, 9);
		    }

		    $db->update_utilizator_cod_inregistrare($_POST["user-id"], $newCod);

		    $response->status = "success";
		    $response->newCod = $newCod;

		}

	} else {

		$response->status = "form-id-failed";

	}

}

header("Content-type: text/json");
echo(json_encode($response));

?>