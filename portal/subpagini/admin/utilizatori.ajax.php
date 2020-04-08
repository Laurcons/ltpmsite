<?php

$db = new db_connection();

$request = "";
$response = new stdClass();

if (isset($_GET["r"])) {
	$request = $_GET["r"];
}

if ($request == "utilizatori") {

	$epp = $_GET["epp"];
	$pag = $_GET["pag"];

	$utiliz = $db->retrieve_paged_utilizatori("Id,Nume,Prenume,Username,Email,Functie,Autoritate,NrMatricol,IdClasa", $epp, $pag);
	$response->utilizatori = array();

	while ($utilizator = $utiliz->fetch_assoc()) {

		$obj = $utilizator;

		if ($obj["Functie"] == "elev")
			$obj["clasa"] = $db->retrieve_clasa_where_id("Id,Nivel,Sufix,IdDiriginte", $obj["IdClasa"]);

		if ($obj["Functie"] == "profesor")
			$obj["clasa"] = $db->retrieve_clasa_where_diriginte("Id,Nivel,Sufix,IdDiriginte", $obj["Id"]);

		$response->utilizatori[] = $obj;

	}

}

header("Content-type: text/json");
echo(json_encode($response));

?>