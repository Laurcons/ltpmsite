<?php 

// subpagina e declarat in /portal/index.php

if ($subpagina == "") {

	$subpagina = "utiliz";

}

if ($subpagina == "utiliz") {

	include("lista-utilizatori.php");

} else if ($subpagina == "materii") {

	include("lista-materii.php");

}

 ?>