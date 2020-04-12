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

} else if ($request == "predari") {

	$predari = $db->retrieve_predari_where_profesor("*", $_GET["id"])->fetch_all(MYSQLI_ASSOC);

	$materii_ids = 
		array_unique(
			array_map(
				function($item) {
					return $item["IdMaterie"];
				},
				$predari));

	$response->materii = array();

	foreach ($materii_ids as $materie_id) {

		$materie = $db->retrieve_materie_where_id("*", $materie_id);

		$func = function($item) use ($materie_id) {
					//echo ($item["IdMaterie"] . " " . $materie_id . " " . (($item["IdMaterie"] == $materie_id)?"true":"false") . "\n");
					return ($item["IdMaterie"] == $materie_id);
				};

		// obtine toate predarile cu materia data
		$filtered_predari = 
			array_filter($predari,
				$func);

		// pune toate clasele predarilor alora
		$materie["clase"] = array();
		foreach ($filtered_predari as $predare) {

			$clasa = $db->retrieve_clasa_where_id("*", $predare["IdClasa"]);
			$clasa["diriginte"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $clasa["IdDiriginte"]);

			$materie["clase"][] = $clasa;

		}

		$response->materii[] = $materie;

	}

	usort($response->materii,
		function($a, $b) {
			return strcmp($a["Nume"], $b["Nume"]);
		});

	$response->status = "success";

} else if ($request == "adauga-predare-data") {

	$materii = $db->retrieve_materii("*");

	$response->materii = $materii->fetch_all(MYSQLI_ASSOC);

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