<?php

$db = new db_connection();

$request = "";
$response_json = new stdClass();

if (isset($_GET["r"])) {
	$request = $_GET["r"];
}

if ($request == "clase") {

	$clase = $db->retrieve_clase("*");
	$response_json->clase = array();

	while ($clasa = $clase->fetch_assoc()) {

		$json_elem = $clasa;
		$json_elem["diriginte"] = $db->retrieve_utilizator_where_id("Nume,Prenume", $clasa["IdDiriginte"]);
		$json_elem["nrelevi"] = $db->retrieve_count_elevi_where_clasa($clasa["Id"]);
		$response_json->clase[] = $json_elem;

	}

} else if ($request == "profesori-disponibili") {

	$response_json->profesori_disponibili = $db->retrieve_profesori_where_not_diriginte("Id,Nume,Prenume")->fetch_all(MYSQLI_ASSOC);

} else if ($request == "elevi") {

	$id = $_GET["id"];

	$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume", $id);

	$response_json->elevi = $elevi->fetch_all(MYSQLI_ASSOC);

} else if ($request == "predari") {

	$id = $_GET["id"];

	$predari = $db->retrieve_predari_where_clasa("*", $id);

	$response_json->predari = array();

	// ia si celelalte date
	while ($predare = $predari->fetch_assoc()) {

		$materie = $db->retrieve_materie_where_id("*", $predare["IdMaterie"]);
		$profesor = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $predare["IdProfesor"]);

		$pred = $predare;
		$pred["materie"] = $materie;
		$pred["profesor"] = $profesor;
		$response_json->predari[] = $pred;

	}

}

header("Content-type: text/json");
echo json_encode($response_json);

?>