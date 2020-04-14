<?php

$db = new db_connection();

$request = "";
$response = new stdClass();

if (isset($_GET["r"])) {
	$request = $_GET["r"];
}

// no form id required here
if ($request == "cod-inreg") {

	$cod = $_POST["cod"];
	$user = $db->retrieve_utilizator_where_cod_inregistrare("Id,Nume,Prenume,Email,Username,IdClasa,Functie,Autoritate", $cod);

	$response->utilizator = $user;

	if ($user != null) {

		if ($user["Functie"] == "profesor") {
			$response->utilizator["clasa"] = $db->retrieve_clasa_where_diriginte("Id,Nivel,Sufix", $user["Id"]);
		} else if ($user["Functie"] == "elev") {
			$response->utilizator["clasa"] = $db->retrieve_clasa_where_id("Id,Nivel,Sufix", $user["IdClasa"]);
		}

	}

}

header("Content-type: text/json");
echo(json_encode($response));

?>