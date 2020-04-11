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

	$response->status = "success";

} else if ($request == "utilizatori-pages") {

	$epp = $_GET["epp"];

	$result = $db->retrieve_utilizatori_pagination_titles($epp);

	$response->pages = $result;
	$response->status = "success";

} else if ($request == "clase-list") {

	$clase = $db->retrieve_clase("*");
	$response->clase = array();

	// ia detalii aditionale pentru fiecare
	while ($clasa = $clase->fetch_assoc()) {

		$newobj = $clasa;
		$newobj["diriginte"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $clasa["IdDiriginte"]);
		$newobj["nr_elevi"] = $db->retrieve_count_elevi_where_clasa($clasa["Id"]);
		$response->clase[] = $newobj;

	}

	$response->status = "success";

} else {

	$response->status = "request-not-found";

}

header("Content-type: application/json");
echo(json_encode($response));

?>