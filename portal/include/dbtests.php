<?php 

// DEBUG FILE
require_once($_SERVER["DOCUMENT_ROOT"] . "/portal/include/dbinit.php");

$dbconn = new db_connection();

$res = $dbconn->retrieve_paged_profesori(15, 0);
while ($row = $res->fetch_assoc()) {
	var_dump($row);
	echo '<br>';
}

?>