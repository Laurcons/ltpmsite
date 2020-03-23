<?php

$db = new db_connection();

$current_id = -1;

if (isset($_GET["id"])) {
	$current_id = $_GET["id"];
}

?>

<!DOCTYPE html>
<html>

<head>

	<title>Administrare clase - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>

 	<style>
 	.loader {
		animation: spin 1.5s linear infinite;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
 	</style>

</head>

<body>
	<?php $header_cpage = "admin:clase"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

<div class="container">

	<?php if ($current_id == -1) : ?>

		<h3 class="mb-3">Toate clasele liceului</h3>

		<a class="btn btn-default border-primary mb-3" href="#">Adauga clasa</a>

		<?php 
			$i = 0;
			$clase = $db->retrieve_clase("*");
		?>

		<div id="clase-list">

			<i class="fas fa-2x fa-circle-notch loader"></i>

		</div>
	
	<?php else : // current_id == -1 ?>

		<?php
			$clasa = $db->retrieve_clasa_where_id("*", $current_id);
		?>

		<div class="h3 mb-3">Clasa <?= $clasa["Nivel"] . " " . $clasa["Sufix"] ?></div>

	<?php endif; // current_id == -1 ?>

</div>

</body>
<footer>
	<script src="?p=admin:clase&js"></script>
	<templates>

		<template id="clasa-template">

			<div class="col-md-4 mb-2">

					<div class="card"> 

						<div class="card-header">

							<div class="card-title h4">

								Clasa {{Nivel}} {{Sufix}}

								<button type="button" class="close">
									&times;
								</button>

							</div>

						</div>

						<ul class="list-group list-group-flush">

							<li class="list-group-item"><b>Diriginte:</b> {{diriginte.Nume}} {{diriginte.Prenume}}</li>

							<li class="list-group-item"><b>Numar elevi:</b> {{nrelevi}}</li>

						</ul>

						<div class="card-body">

							<a class="btn btn-primary w-100" href="?p=admin:clase&id={{Id}}">Administreaza</a>

						</div>

					</div>

				</div>

		</template>

	</templates>
</footer>

</html>