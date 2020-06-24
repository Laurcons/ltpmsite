<?php

$response = new stdClass();
$db = new db_connection();

$request = "";
if (isset($_GET["r"])) {
    $request = $_GET["r"];
}

if ($request == "ultimele") {

    $resurse = $db->retrieve_resurse_newest_pdo("*", 5);

    $response->resurse = array();
    foreach ($resurse as $resursa) {
        $resursa["profesor"] = $db->retrieve_utilizator_where_id("Nume,Prenume", $resursa["IdProfesor"]);
        $resursa["atasamente"] = $db->retrieve_resursa_files_count_where_resursa_id($resursa["Id"]);
        $response->resurse[] = $resursa;
    }

    $response->status = "success";

} else {
    $response->status = "request-not-found";
}

header("Content-type: application/json");
echo(json_encode($response));

?>