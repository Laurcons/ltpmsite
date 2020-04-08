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

	<title>Administrare utilizatori - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>

</head>

<body>
	<?php $header_cpage = "admin:utilizatori"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

	<div class="container">

		<?php if ($current_id == -1) : ?>

			<div class="display-4 text-center mb-2">
				Toti utilizatorii
			</div>

			<div data-pagination="utilizatori">

				<!-- filled with javascript -->

			</div>

			<div class="d-none d-md-block"> <!-- header row -->

				<div class="row border font-weight-bold p-2" style="border-bottom-width: 2px !important;">

					<div class="col-md-3">
						Nume si prenume
					</div>

					<div class="col-md-5">
						Detalii
					</div>

					<div class="col-md-4">
						Optiuni
					</div>

				</div> 

			</div> <!-- header row -->

			<div id="utilizatori-table-rows">

				<!-- filled with javascript -->

			</div>

			<div data-pagination="utilizatori">

				<!-- filled with javascript -->

			</div>

		<?php else : // current_id == -1 ?>



		<?php endif; ?>

	</div> <!-- container -->

	<?php if ($current_id == -1) : ?>

	<?php else : // current_id == -1 ?>

	<?php endif; ?>

</body>

<footer>

	<?php if ($current_id == -1) : ?>

		<script src="?p=admin:utilizatori&js=list"></script>
		<?php require_once("utilizatori.list.templ.php"); ?>

		<style>

			.table-row:hover {

				background-color: #ddd;

			}

		</style>

	<?php else : // current_id == -1 ?>

	<?php endif; ?>

</footer>

</html>