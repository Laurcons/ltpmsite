<?php 

	$db = new db_connection();

	// pai fa requestul la baza de date idfk
	$data = array();
	$data["Text"] = $_POST["text"];
	$data["Autor"] = $_POST["autor"];
	$data["IdUser"] = $db->retrieve_utilizator_where_username("Id", $_SESSION["logatca"])["Id"];
	$data["Comentariu"] = $_POST["obs"];
	$data["Status"] = "propus";

	try {

		$db->insert_citat($data);

	} catch (Exception $e) {

		header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");

	}

 ?>