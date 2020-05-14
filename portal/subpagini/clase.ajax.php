<?php

// processing of GET ajax requests

include("clase.phphead.php");

$request = "";
$response = new stdClass();

if (isset($_GET["r"])) {
	$request = $_GET["r"];
}

if ($request != "") {

	if ($request == "elevi") {

		$semestru = $_GET["sem"] ?? getCurrentSemestru();

		$materie = $db->retrieve_materie_where_id("*", $_GET["id"]);
		$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume,Username", $materie["IdClasa"]);
		$response->elevi = array();

		while ($elev = $elevi->fetch_assoc()) {

			$response->elevi[] = elevi_getAdditional($db, $elev, $materie, $semestru);

		}

		$response->status = "success";

	} else if ($request == "elev") {

		$semestru = $_GET["sem"] ?? getCurrentSemestru();

		$materie = $db->retrieve_materie_where_id("*", $_GET["pid"]);
		$elev = $db->retrieve_utilizator_where_id("Id,Nume,Prenume,Username", $_GET["uid"]);

		$response->elev = elevi_getAdditional($db, $elev, $materie, $semestru);
		$response->status = "success";

	} else if ($request == "materii") {

		$profesor = $db->retrieve_utilizator_where_username("Id", $_SESSION["logatca"]);

		$materii = $db->retrieve_materii_where_profesor("*", $profesor["Id"]);

		$response->materii = array();
		while ($materie = $materii->fetch_assoc()) {

			$materie["clasa"] = $db->retrieve_clasa_where_id("*", $materie["IdClasa"]);
			if ($materie["clasa"]["IdDiriginte"] == $profesor["Id"])
				$materie["calitateDe"] = "diriginte";
			else $materie["calitateDe"] = "profesor";
			$materie["nrelevi"] = $db->retrieve_count_elevi_where_clasa($materie["IdClasa"]);
			$response->materii[] = $materie;

		}

		$response->status = "success";

	} else if ($request == "teze") {

		$teze = $db->retrieve_teze_where_materie("*", $_GET["mid"])
			->fetch_all(MYSQLI_ASSOC);
		$materie = $db->retrieve_materie_where_id("*", $_GET["mid"]);
		$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume", $materie["IdClasa"]);

		$teze = array_map(function($item) {
			return $item["IdElev"];
		}, $teze);

		$response->elevi = array();

		while ($elev = $elevi->fetch_assoc()) {

			if (array_search($elev["Id"], $teze) === false) {

				$elev["teza"] = false;
				$response->elevi[] = $elev;

			} else {

				$elev["teza"] = true;
				$response->elevi[] = $elev;

			}

		}

		$response->status = "success";

	} else if ($request == "motivari") {

		$materie_id = $_GET["id"];
		$materie = $db->retrieve_materie_where_id("*", $materie_id);

		$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume", $materie["IdClasa"]);

		$response->elevi = array();

		while ($elev = $elevi->fetch_assoc()) {

			$abs = $db->retrieve_absente_count_where_elev_and_materie($elev["Id"], $materie["Id"]);
			$elev["absenteMotivate"] = $abs["Motivate"];
			$elev["absenteNemotivate"] = $abs["Nemotivate"];
			$elev["nr_motivari"] = $db->retrieve_motivari_where_elev("Id", $elev["Id"])->num_rows;
			$response->elevi[] = $elev;

		}

		$response->status = "success";

	} else if ($request == "motivari-elev") {

		$materie_id = $_GET["id"];
		$materie = $db->retrieve_materie_where_id("*", $materie_id);

		$elev = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $_GET["uid"]);

		$motivari = $db->retrieve_motivari_where_elev("*", $elev["Id"]);
		$elev["motivari"] = array();

		while ($motivare = $motivari->fetch_assoc()) {

			if ($motivare["Tip"] == "materie")
				$motivare["materie"] = $db->retrieve_materie_where_id("Id,Nume", $motivare["IdMaterie"]);
			$elev["motivari"][] = $motivare;

		}

		$response->elev = $elev;
		$response->status = "success";

	} else {

		$response->status = "request-not-found";

	}

} else {

	$response->status = "request-empty";

}

header("Content-type: application/json");
echo(json_encode($response));

function elevi_getAdditional($db, $elev, $materie, $semestru) {

	$note = $db->retrieve_note_where_elev_and_materie_and_semestru("*", $elev["Id"], $materie["Id"], $semestru);
	$elev["note"] = array();
	while ($nota = $note->fetch_assoc()) {

		$nota["profesor"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume,Username", $nota["IdProfesor"]);
		$elev["note"][] = $nota;

	}

	$absente = $db->retrieve_absente_where_elev_and_materie_and_semestru("*", $elev["Id"], $materie["Id"], $semestru);
	$elev["absente"] = array();
	while ($absenta = $absente->fetch_assoc()) {

		$absenta["profesor"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume,Username", $absenta["IdProfesor"]);
		$elev["absente"][] = $absenta;

	}

	$elev["hasTeza"] = $db->has_elev_teza_in_materie($elev["Id"], $materie["Id"]);
	//$elev["media"] = averageNoteWithTeza($elev["note"]);
	sortBySchoolDate($elev["note"]);
	sortBySchoolDate($elev["absente"]);

	// vezi mediile pe toate semestrele
	$note_sem1 = $db->retrieve_note_where_elev_and_materie_and_semestru("Nota", $elev["Id"], $materie["Id"], "1")->fetch_all(MYSQLI_ASSOC);
	$note_sem2 = $db->retrieve_note_where_elev_and_materie_and_semestru("Nota", $elev["Id"], $materie["Id"], "2")->fetch_all(MYSQLI_ASSOC);
	$elev["media_sem1"] = averageNoteWithTeza($note_sem1);
	$elev["media_sem2"] = averageNoteWithTeza($note_sem2);
	$elev["media_gen"] = 
		($elev["media_sem1"] != 0 && $elev["media_sem2"] != 0) ?
		truncMedie(($elev["media_sem1"] + $elev["media_sem2"]) / 2) :
		0;

	return $elev;

}

?>