<?php

redirect_if_not_logged_in("/portal");

?>

<!DOCTYPE html>

<html>

<head>

	<title>Resurse - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-include.php"); ?>

</head>

<body>

	<?php $header_cpage = "resurse"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/navbar.php"); ?>

	<div class="container">

		<div class="jumbotron">

			<h1>Resursele elevilor</h1>

			<p>Locul centralizat unde profesorii își pot încărca resursele educaționale, pentru
            a putea fi folosite în mod nelimitat de către elevi</p>

		</div>

        <a class="float-right btn btn-default border-primary" href="/portal/resurse/nou">Adaugă resursă</a>

	</div>


</body>

</html>