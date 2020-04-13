<?php

$db = new db_connection();

$request = "";
$response = new stdClass();

if (isset($_GET["r"])) {
	$request = $_GET["r"];
}

if ($request == "clase") {

	$clase = $db->retrieve_clase("*");
	$response->clase = array();

	while ($clasa = $clase->fetch_assoc()) {

		$json_elem = $clasa;
		$json_elem["diriginte"] = $db->retrieve_utilizator_where_id("Nume,Prenume", $clasa["IdDiriginte"]);
		$json_elem["nrelevi"] = $db->retrieve_count_elevi_where_clasa($clasa["Id"]);
		$response->clase[] = $json_elem;

	}

	$response->status = "success";

} else if ($request == "profesori-disponibili") {

	$response->profesori_disponibili = $db->retrieve_profesori_where_not_diriginte("Id,Nume,Prenume")->fetch_all(MYSQLI_ASSOC);

	$response->status = "success";

} else if ($request == "elevi-clasa") {

	$id = $_GET["id"];

	$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume", $id);

	$response->elevi = $elevi->fetch_all(MYSQLI_ASSOC);

	$response->status = "success";

} else if ($request == "predari") {

	$id = $_GET["id"];

	$predari = $db->retrieve_predari_where_clasa("*", $id);

	$response->predari = array();

	// ia si celelalte date
	while ($predare = $predari->fetch_assoc()) {

		$materie = $db->retrieve_materie_where_id("*", $predare["IdMaterie"]);
		$profesor = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $predare["IdProfesor"]);

		$pred = $predare;
		$pred["materie"] = $materie;
		$pred["profesor"] = $profesor;
		$response->predari[] = $pred;

	}

	$response->status = "success";

} else if ($request == "elevi-disponibili") {

	$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume,Username", NULL)->fetch_all(MYSQLI_ASSOC);

	$response->elevi = $elevi;
	$response->status = "success";

} else {

	$response->status = "request-not-found";

}

header("Content-type: text/json");
echo json_encode($response);

?>