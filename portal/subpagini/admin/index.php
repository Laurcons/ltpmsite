<?php

redirect_if_not_autoritate("admin", "/portal/");

if ($subpagina == "clase") {

	if ($post_redir)
		include("clase.post.php");
	else if ($ajax_redir)
		include("clase.ajax.php");
	else if ($js_redir) {
		header("Content-type: application/javascript");
		$file = $_GET["js"];
		include("clase." . $file . ".js");
	}
	else include("clase.php");

}/* else if ($subpagina == "materii") {

	if ($post_redir)
		include("materii.post.php");
	else if ($ajax_redir)
		include("materii.ajax.php");
	else if ($js_redir) {
		header("Content-type: application/javascript");
		include("materii.js");
	} else include("materii.php");

}*/ else if ($subpagina == "utilizatori") {

	if ($post_redir)
		include("utilizatori.post.php");
	else if ($ajax_redir)
		include("utilizatori.ajax.php");
	else if ($js_redir) {
		header("Content-type: application/javascript");
		$file = $_GET["js"];
		include("utilizatori." . $file . ".js");
	} else include("utilizatori.php");

} else {

	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	include($_SERVER["DOCUMENT_ROOT"] . "/errors/404.php");

}

?>