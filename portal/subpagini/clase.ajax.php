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

		$predare = $db->retrieve_predare_where_id("*", $_GET["id"]);
		$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume,Username", $predare["IdClasa"]);
		$response->elevi = array();

		while ($elev = $elevi->fetch_assoc()) {

			$response->elevi[] = elevi_getAdditional($db, $elev, $predare, $semestru);

		}

		$response->status = "success";

	} else if ($request == "elev") {

		$semestru = $_GET["sem"] ?? getCurrentSemestru();

		$predare = $db->retrieve_predare_where_id("*", $_GET["pid"]);
		$elev = $db->retrieve_utilizator_where_id("Id,Nume,Prenume,Username", $_GET["uid"]);

		$response->elev = elevi_getAdditional($db, $elev, $predare, $semestru);
		$response->status = "success";

	} else if ($request == "predari") {

		$profesor = $db->retrieve_utilizator_where_username("Id", $_SESSION["logatca"]);

		$predari = $db->retrieve_predari_where_profesor("*", $profesor["Id"]);

		$response->predari = array();
		while ($predare = $predari->fetch_assoc()) {

			$predare["clasa"] = $db->retrieve_clasa_where_id("*", $predare["IdClasa"]);
			$predare["materia"] = $db->retrieve_materie_where_id("*", $predare["IdMaterie"]);
			if ($predare["clasa"]["IdDiriginte"] == $profesor["Id"])
				$predare["calitateDe"] = "diriginte";
			else $predare["calitateDe"] = "profesor";
			$predare["nrelevi"] = $db->retrieve_count_elevi_where_clasa($predare["IdClasa"]);
			$response->predari[] = $predare;

		}

		$response->status = "success";

	} else if ($request == "teze") {

		$teze = $db->retrieve_teze_where_predare("*", $_GET["pid"])
			->fetch_all(MYSQLI_ASSOC);
		$predare = $db->retrieve_predare_where_id("*", $_GET["pid"]);
		$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume", $predare["IdClasa"]);

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

	} else {

		$response->status = "request-not-found";

	}

} else {

	$response->status = "request-empty";

}

echo(json_encode($response));

function elevi_getAdditional($db, $elev, $predare, $semestru) {

	$note = $db->retrieve_note_where_elev_and_materie_and_semestru("*", $elev["Id"], $predare["IdMaterie"], $semestru);
	$elev["note"] = array();
	while ($nota = $note->fetch_assoc()) {

		$nota["profesor"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume,Username", $nota["IdProfesor"]);
		$elev["note"][] = $nota;

	}
	sortBySchoolDate($elev["note"]);

	$absente = $db->retrieve_absente_where_elev_and_materie_and_semestru("*", $elev["Id"], $predare["IdMaterie"], $semestru);
	$elev["absente"] = array();
	while ($absenta = $absente->fetch_assoc()) {

		$absenta["profesor"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume,Username", $absenta["IdProfesor"]);
		$elev["absente"][] = $absenta;

	}

	$elev["hasTeza"] = $db->has_elev_teza_in_predare($elev["Id"], $predare["Id"]);
	//$elev["media"] = averageNoteWithTeza($elev["note"]);
	sortBySchoolDate($elev["note"]);
	sortBySchoolDate($elev["absente"]);

	// vezi mediile pe toate semestrele
	$note_sem1 = $db->retrieve_note_where_elev_and_materie_and_semestru("Nota", $elev["Id"], $predare["IdMaterie"], "1")->fetch_all(MYSQLI_ASSOC);
	$note_sem2 = $db->retrieve_note_where_elev_and_materie_and_semestru("Nota", $elev["Id"], $predare["IdMaterie"], "2")->fetch_all(MYSQLI_ASSOC);
	$elev["media_sem1"] = averageNoteWithTeza($note_sem1);
	$elev["media_sem2"] = averageNoteWithTeza($note_sem2);
	$elev["media_gen"] = 
		($elev["media_sem1"] != 0 && $elev["media_sem2"] != 0) ?
		truncMedie(($elev["media_sem1"] + $elev["media_sem2"]) / 2) :
		0;

	return $elev;

}

?>