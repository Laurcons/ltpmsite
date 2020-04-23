<?php 

// DEBUG FILE
////

require_once($_SERVER["DOCUMENT_ROOT"] . "/portal/include/dbinit.php");

$db = new db_connection();

$teze = array(
	array(
		"IdElev" => 7,
		"IdPredare" => 33),
	array(
		"IdElev" => 14,
		"IdPredare" => 33,
		"Teza" => "nu")
);

$res = $db->update_teze($teze);

echo(json_encode($res));

?>