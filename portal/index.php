<?php

session_start();

include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/loginchecks.php");
include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/dbinit.php");
include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/note-style.php");
include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/security.php");

$pagina = "";
$subpagina = "";
$post_redir = false;
$ajax_redir = false;
$js_redir = false;

// pagina
if (isset($_GET["pagina"])) {
	
	$pagina = $_GET["pagina"];

} else if (isset($_GET["p"])) {

	$pagina = $_GET["p"];

}

$pagina_tree = explode(":", $pagina);
$pagina = $pagina_tree[0];
if (isset($pagina_tree[1]))
	$subpagina = $pagina_tree[1];

if (isset($_GET["subp"])) {

	$subpagina = $_GET["subp"];

} else if (isset($_GET["sp"])) {

	$subpagina = $_GET["sp"];

}

if (isset($_GET["post"])) {

	$post_redir = true;

}
if (isset($_GET["ajax"])) {

	$ajax_redir = true;

}
if (isset($_GET["js"])) {

	$js_redir = true;

}

if ($pagina == "" || $pagina == "prima") {

	if ($js_redir) {
		header("Content-type: application/javascript");
		include("include/utility.js");
	}
	else include("subpagini/primapagina.php");

} else if ($pagina == "logare") {

	include("subpagini/logare.php");

} else if ($pagina == "inreg") {

	include("subpagini/inregistrare.php");

} else if ($pagina == "panou") {

	include("subpagini/panou.php");

} else if ($pagina == "logout") {

	include("subpagini/logout.php");

} else if ($pagina == "admin") {

	include("subpagini/admin/index.php");

} else if ($pagina == "situatia") {

	include("subpagini/situatia.php");

} else if ($pagina == "clase") {

	if ($post_redir)
		include("subpagini/clase.post.php");
	else if ($ajax_redir)
		include("subpagini/clase.ajax.php");
	else include("subpagini/clase.php");

} else if ($pagina == "citate") {

	if ($post_redir)
		include("subpagini/citate.post.php");
	else include("subpagini/citate.php");

} else {

	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	include($_SERVER["DOCUMENT_ROOT"] . "/errors/404.php");

}

?>