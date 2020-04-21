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

		$semestru = "1";

		$predare = $db->retrieve_predare_where_id("*", $_GET["id"]);
		$elevi = $db->retrieve_elevi_where_clasa("Id,Nume,Prenume,Username", $predare["IdClasa"]);
		$response->elevi = array();

		while ($elev = $elevi->fetch_assoc()) {

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

			$elev["media"] = averageNoteWithTeza($elev["note"]);
			sortBySchoolDate($elev["note"]);
			sortBySchoolDate($elev["absente"]);

			$response->elevi[] = $elev;

		}

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

	} else {

		$response->status = "request-not-found";

	}

} else {

	$response->status = "request-empty";

}

echo(json_encode($response));

?>