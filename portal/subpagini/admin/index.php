<?php

if ($subpagina == "clase") {

	if ($post_redir)
		include("clase.post.php");
	else if ($ajax_redir)
		include("clase.ajax.php");
	else if ($js_redir) {
		header("Content-type: text/javascript");
		include("clase.js");
	}
	else include("clase.php");
}

?>