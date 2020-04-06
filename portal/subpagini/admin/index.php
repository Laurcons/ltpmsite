<?php

redirect_if_not_autoritate("admin", "?");

if ($subpagina == "clase") {

	if ($post_redir)
		include("clase.post.php");
	else if ($ajax_redir)
		include("clase.ajax.php");
	else if ($js_redir) {
		header("Content-type: text/javascript");
		$file = $_GET["js"];
		include("clase." . $file . ".js");
	}
	else include("clase.php");

} else if ($subpagina == "materii") {

	if ($post_redir)
		include("materii.post.php");
	else if ($ajax_redir)
		include("materii.ajax.php");
	else if ($js_redir) {
		header("Content-type: text/javascript");
		include("materii.js");
	} else include("materii.php");

}

?>