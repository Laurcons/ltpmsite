<?php

session_start();

require_once($_SERVER["DOCUMENT_ROOT"] . "/portal/include/dbinit.php");

$db = new db_connection();
$conn = $db->get_conn();

$json_response = new stdClass();
$json_response->status = 0;

// ia datele din baza de date
$stmt = $conn->prepare("SELECT * FROM game1_scores;");
$stmt->execute();
$json_response->type = "array[scoreData]";
$json_response->content = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo json_encode($json_response);

?>