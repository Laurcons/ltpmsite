<?php 

// DEBUG FILE
////

require_once($_SERVER["DOCUMENT_ROOT"] . "/portal/include/dbinit.php");

$db = new db_connection();

$res = $db->retrieve_utilizatori_pagination_titles(5);

echo(json_encode($res));

?>