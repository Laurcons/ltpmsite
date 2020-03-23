<?php

// processing of GET ajax requests

include("clase.phphead.php");

$request = "";

if (isset($_GET["r"])) {
	$request = $_GET["r"];
}

if ($request != "") {

	$user_id = 0;
	$materie_id = 0;
	$semestru = "";

	if (isset($_GET["uid"]))
		$user_id = $_GET["uid"];
	if (isset($_GET["mid"]))
		$materie_id = $_GET["mid"];
	if (isset($_GET["sem"]))
		$semestru = $_GET["sem"];

	if ($request == "note") {

		if ($user_id == 0 || $materie_id == 0 || $semestru == "") {
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
		} else {

			$data = $db->retrieve_note_where_utilizator_and_materie_and_semestru("*", $user_id, $materie_id, $semestru);

			echo json_encode($data->fetch_all(MYSQLI_ASSOC));

		}

	} else if ($request = "absente") {

		if ($user_id == 0 || $materie_id == 0 || $semestru == "") {
			header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
		} else {

			$data = $db->retrieve_absente_where_utilizator_and_materie_and_semestru("*", $user_id, $materie_id, $semestru);

			echo json_encode($data->fetch_all(MYSQLI_ASSOC));

		}

	} else {

	header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");

	}

} else {

	header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");

}


?>