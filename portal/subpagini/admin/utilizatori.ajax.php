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
	$filter = array();
	if (isset($_GET["filter-profs"]))
		$filter[] = "profesori";
	if (isset($_GET["filter-elevi"]))
		$filter[] = "elevi";

	$utiliz = $db->retrieve_paged_utilizatori("Id,Nume,Prenume,Username,Email,Functie,Autoritate,NrMatricol,IdClasa", $epp, $pag, $filter);
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
	$filter = array();
	if (isset($_GET["filter-profs"]))
		$filter[] = "profesori";
	if (isset($_GET["filter-elevi"]))
		$filter[] = "elevi";

	$result = $db->retrieve_utilizatori_pagination_titles($epp, $filter);

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

} else if ($request == "materii") {

	$materii = $db->retrieve_materii_where_profesor("*", $_GET["id"]);

	$response->materii = array();

	while ($materie = $materii->fetch_assoc()) {

		$clasa = $db->retrieve_clasa_where_id("*", $materie["IdClasa"]);

		$clasa["diriginte"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $clasa["IdDiriginte"]);

		$materie["clasa"] = $clasa;

		$response->materii[] = $materie;

	}

	$response->status = "success";

} else if ($request == "adauga-materie-data") {

	$clase = $db->retrieve_clase("*");
	$response->clase = array();

	// ia detalii aditionale pentru fiecare
	while ($clasa = $clase->fetch_assoc()) {

		$clasa["diriginte"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $clasa["IdDiriginte"]);
		$clasa["nr_elevi"] = $db->retrieve_count_elevi_where_clasa($clasa["Id"]);
		$response->clase[] = $clasa;

	}

	$response->status = "success";

} else if ($request == "is-diriginte") {

	$clasa = $db->retrieve_clasa_where_diriginte("Id", $_GET["id"]);

	$response->is_diriginte = ($clasa != NULL);
	$response->status = "success";

} else {

	$response->status = "request-not-found";

}

header("Content-type: application/json");
echo(json_encode($response));

?>