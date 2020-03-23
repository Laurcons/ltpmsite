<?php

redirect_if_logged_in("/portal/?p=panou&src=prima");

?>

<!DOCTYPE html>

<html>

<head>

	<title>Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>

</head>

<body>

	<?php $header_cpage = "prima"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

	<div class="container">

		<div class="jumbotron">

			<h1>Kanboard - Echipa IT</h1>

			<a href="/team" class="btn btn-lg btn-info">Kanboard (/team)</a>

		</div>

		<div class="jumbotron">

			<h1>Creat de elevi, pentru elevi</h1>

			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

		</div>

	</div>


</body>

</html>