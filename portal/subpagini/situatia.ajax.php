<?php

$response = new stdClass();
$db = new db_connection();

$request = "";
if (isset($_GET["r"])) {
    $request = $_GET["r"];
}

if ($request == "materii") {

    $sem = getCurrentSemestru();
    if (isset($_GET["sem"]))
        $sem = $_GET["sem"];
    $elev = $db->retrieve_utilizator_where_id("Id,IdClasa", $_GET["uid"]);
    $clasa = $db->retrieve_clasa_where_id("*", $elev["IdClasa"]);
    $materii = $db->retrieve_materii_where_clasa("*", $clasa["Id"]);

    $response->materii = array();
    while ($materie = $materii->fetch_assoc()) {

        $materie["note"] = array();
        $note = $db->retrieve_note_where_elev_and_materie_and_semestru("*", $elev["Id"], $materie["Id"], $sem);
        while ($nota = $note->fetch_assoc()) {
            $nota["profesor"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $nota["IdProfesor"]);
            $materie["note"][] = $nota;
        }
        $materie["absente"] = array();
        $absente = $db->retrieve_absente_where_elev_and_materie_and_semestru("*", $elev["Id"], $materie["Id"], $sem);
        while ($absenta = $absente->fetch_assoc()) {
            $absenta["profesor"] = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $absenta["IdProfesor"]);
            $materie["absente"][] = $absenta;
        }
        $note_sem1 = $db->retrieve_note_where_elev_and_materie_and_semestru("Nota,Tip", $elev["Id"], $materie["Id"], "1")->fetch_all(MYSQLI_ASSOC);
        $note_sem2 = $db->retrieve_note_where_elev_and_materie_and_semestru("Nota,Tip", $elev["Id"], $materie["Id"], "2")->fetch_all(MYSQLI_ASSOC);
        $materie["medie_sem1"] = roundMedie(averageNoteWithTeza($note_sem1));
        $materie["medie_sem2"] = roundMedie(averageNoteWithTeza($note_sem2));
        $materie["medie_gen"] = truncMedie(($materie["medie_sem1"] + $materie["medie_sem2"]) / 2);
        $response->materii[] = $materie;

    }

    $response->status = "success";
    $response->semestru = $sem;

} else {

    $response->status = "request-not-found";

}

//header("Content-type: application/json");
echo(json_encode($response));

?>