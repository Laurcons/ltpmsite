<?php

$db = new db_connection();

$request = "";
$response = new stdClass();

if (isset($_GET["r"])) {
	$request = $_GET["r"];
}

if ($request == "materii") {

	$materii = $db->retrieve_materii("Id,Nume");
	$response->materii = array();

	while ($materie = $materii->fetch_assoc()) {

		$obj = $materie;
		$obj["profesori"] = $db->retrieve_profesori_where_predare_materie("Id,Nume,Prenume", $materie["Id"])->fetch_all(MYSQLI_ASSOC);
		$response->materii[] = $obj;

	}

}

header("Content-type: text/json");
echo(json_encode($response));

?>
