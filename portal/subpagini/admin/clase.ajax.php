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

} else if ($request == "materii") {

	$id = $_GET["id"];

	$materii = $db->retrieve_materii_where_clasa("*", $id);

	$response->materii = array();

	// ia si celelalte date
	while ($materie = $materii->fetch_assoc()) {

		$profesor = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $materie["IdProfesor"]);

		$materie["profesor"] = $profesor;
		$response->materii[] = $materie;

	}

	$response->status = "success";

} else if ($request == "elevi-disponibili") {

	$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume,Username", NULL)->fetch_all(MYSQLI_ASSOC);

	$response->elevi = $elevi;
	$response->status = "success";

} else if ($request == "adauga-materie-data") {

	// returneaza toti profesorii
	$response->profesori = $db->retrieve_profesori("Id,Nume,Prenume,Username")->fetch_all(MYSQLI_ASSOC);

	$response->status = "success";

} else if ($request == "diriginti-disponibili") {

	$profs = $db->retrieve_profesori("Id,Nume,Prenume");
	$response->profesori = array();

	while ($prof = $profs->fetch_assoc()) {

		$obj = $prof;
		$obj["clasa"] = $db->retrieve_clasa_where_diriginte("Id,Nivel,Sufix", $prof["Id"]);
		$response->profesori[] = $obj;

	}

	$response->status = "success";

} else {

	$response->status = "request-not-found";

}

header("Content-type: text/json");
echo json_encode($response);

?>