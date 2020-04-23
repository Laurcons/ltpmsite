<?php 

	// asta e prezenta si in clase.php si in clase.post.php si in clase.ajax.php

	// if this comment is a security issue thing, or if it restricts more than it should, yeah just uncomment it;
	// commenting this was just a quick decision
	//if (isset($_GET["ajax"]) || isset($_GET["post"])) {

		if (!is_functie("profesor")) {

			header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
			die("Sesiunea a expirat. Reautentificati-va.");

		}

	//}

	redirect_if_not_functie("profesor", "/portal/panou");

	$db = new db_connection();

	$is_list = true;
	$materie_id = -1;

	if (isset($_GET["id"])) {

		$materie_id = $_GET["id"];
		$is_list = false;

	}

	$semestru = getCurrentSemestru();
	if (isset($_GET["sem"])) {
		$semestru = $_GET["sem"];
	}

	// ia date
	$prof = $db->retrieve_utilizator_where_username("*", $_SESSION["logatca"]);
	$prof_id = $prof["Id"];

	$materie = $db->retrieve_materie_where_id("*", $materie_id);

	if ($materie == null) {

		$materie_id = -1;
		$is_list = true;

	} else if ($materie["IdProfesor"] != $prof_id) {

		$materie_id = -1;
		$is_list = true;

	}

?>