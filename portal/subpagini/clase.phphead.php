<?php 

	// asta e prezenta si in clase.php si in clase.post.php si in clase.ajax.php

	if (isset($_GET["ajax"]) || isset($_GET["post"])) {

		if (!is_functie("profesor")) {

			header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
			die("Sesiunea a expirat. Reautentificati-va.");

		}

	}

	redirect_if_not_functie("profesor", "/portal/?p=panou");

	$db = new db_connection();

	$predare_id = -1;

	if (isset($_GET["id"])) {

		$predare_id = $_GET["id"];

	}

	// ia date
	$prof = $db->retrieve_utilizator_where_username("*", $_SESSION["logatca"]);
	$prof_id = $prof["Id"];

	$predare = $db->retrieve_predare_where_id("*", $predare_id);

	if ($predare == null) {

		$predare_id = -1;

	} else if ($predare["IdProfesor"] != $prof_id) {

		$predare_id = -1;

	}

?>