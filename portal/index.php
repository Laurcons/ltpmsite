<?php

session_start();

require($_SERVER["DOCUMENT_ROOT"] . "/portal/include/loginchecks.php");
require($_SERVER["DOCUMENT_ROOT"] . "/portal/include/dbinit.php");
require($_SERVER["DOCUMENT_ROOT"] . "/portal/include/utility.php");
require($_SERVER["DOCUMENT_ROOT"] . "/portal/include/security.php");

$CONFIG = require("include/config.php");

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
		require("include/utility.js");
	} else if (isset($_GET["css"])) {
		header("Content-type: text/css");
		require("include/additions.css");
	}
	else require("subpagini/primapagina.php");

} else if ($pagina == "logare") {

	if ($js_redir) {
		header("Content-type: application/javascript");
		require("subpagini/logare.js");
	} else if ($post_redir) {
		require("subpagini/logare.post.php");
	} else require("subpagini/logare.php");

} else if ($pagina == "inreg") {

	if ($js_redir) {
		header("Content-type: application/javascript");
		require("subpagini/inregistrare.js");
	} else if ($post_redir) {
		require("subpagini/inregistrare.post.php");
	} else if ($ajax_redir) {
		require("subpagini/inregistrare.ajax.php");
	} else require("subpagini/inregistrare.php");

} else if ($pagina == "panou") {

	require("subpagini/panou.php");

} else if ($pagina == "logout") {

	require("subpagini/logout.php");

} else if ($pagina == "admin") {

	require("subpagini/admin/index.php");

} else if ($pagina == "situatia") {

	if ($js_redir) {
		header("Content-type: application/javascript");
		require("subpagini/situatia.js");
	} else if ($ajax_redir)
		require("subpagini/situatia.ajax.php");
	else if ($post_redir)
		require("subpagini/situatia.post.php");
	else require("subpagini/situatia.php");

} else if ($pagina == "topsecret") {

	echo "<img src='https://laurcons.ddns.net/media/dickbutt.jpg'>";

} else if ($pagina == "clase") {

	if ($post_redir)
		require("subpagini/clase.post.php");
	else if ($ajax_redir)
		require("subpagini/clase.ajax.php");
	else if ($js_redir) {
		header("Content-type: application/javascript");
		require("subpagini/clase." . $_GET["js"] . ".js");
	} else require("subpagini/clase.php");

} else if ($pagina == "citate") {

	if ($post_redir)
		require("subpagini/citate.post.php");
	else require("subpagini/citate.php");

} else if ($pagina == "resurse") {

    require("subpagini/resurse/index.php");

} else {

	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
	require($_SERVER["DOCUMENT_ROOT"] . "/errors/404.php");

}

?>