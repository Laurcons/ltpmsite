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

	header("Content-type: text/json");
	$response_json->profesori_disponibili = $db->retrieve_profesori_where_not_diriginte("Id,Nume,Prenume")->fetch_all(MYSQLI_ASSOC);

}

echo json_encode($response_json);

?>