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

</head>

<body>
	<?php $header_cpage = "admin:clase"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

<div class="container">

	<?php if ($current_id == -1) : ?>

		<?php
			$profesori_disponibili = $db->retrieve_profesori_where_not_diriginte("Id,Nume,Prenume");

		?>

		<h3 class="mb-3">Toate clasele liceului</h3>

		<a class="btn btn-default border-primary mb-3" href="#" data-toggle="modal" data-target="#creeaza-clasa-modal">Adauga clasa</a>

		<?php 
			$i = 0;
			$clase = $db->retrieve_clase("*");
		?>

		<div id="clase-list">
			<!-- filled with javascript & ajax -->
		</div>

		<div class="modal fade" id="creeaza-clasa-modal">

			<div class="modal-dialog">

				<div class="modal-content" id="creeaza-clasa-modal-content">

					<!-- added with javascript and ajax -->

				</div>

			</div>

		</div>

		<div class="modal fade" id="sterge-clasa-modal">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header bg-danger">

						<div class="modal-title text-white h4">
							Sterge clasa
						</div>

						<button class="close text-white" data-dismiss="modal">
							&times;
						</button>

					</div> <!-- modal-header -->

					<div class="modal-body">

						<p>Sunteti sigur ca doriti sa stergeti clasa? Aceasta actiune nu poate fi anulata!</p>

					</div>

					<div class="modal-footer">

						<div class="btn-group">

							<button class="btn btn-default bg-white border-danger" data-dismiss="modal">Inapoi</button>

							<input type="submit"
								   form="sterge-clasa-form"
								   class="btn btn-danger"
								   value="Sterge clasa">

						</div>

					</div>

				</div>

			</div>

		</div>

		<form id="creeaza-clasa-form" method="POST" action="?p=admin:clase&post">

			<input type="hidden" id="creeaza-clasa-form-form-id" name="form-id" value="fillwithjs please">
			<input type="hidden" name="creeaza-clasa" value="whatever">

		</form>

		<form id="sterge-clasa-form" method="POST" action="?p=admin:clase&post">

			<input type="hidden" id="sterge-clasa-form-form-id" name="form-id" value="fillwithjs please">
			<input type="hidden" id="sterge-clasa-form-clasa-id" name="clasa-id" value="fillwithjs please">
			<input type="hidden" name="sterge-clasa" value="ANAETHING">

		</form>
	
	<?php else : // current_id == -1 ?>

		<?php
			$clasa = $db->retrieve_clasa_where_id("*", $current_id);
			$diriginte = $db->retrieve_utilizator_where_id("*", $clasa["IdDiriginte"]);
		?>

		<div class="row">

			<div class="col-sm-4">

				<a class="btn btn-default border-primary" href="?p=admin:clase">Inapoi la clase</a>

			</div>

			<div class="col-sm-4 text-center">

				<div class="display-4">
					Clasa <?= $clasa["Nivel"] . " " . $clasa["Sufix"] ?>
				</div>

			</div>

		</div>

		<p class="text-center mb-3">

			<span class="font-weight-bold">Diriginte: </span>

			<?= $diriginte["Nume"] . " " . $diriginte["Prenume"] ?>

			<a class="btn btn-sm bg-white border">Schimba</a>

		</p>

		<div class="d-block d-md-none h4 text-right">Elevii clasei</div>
		<div class="d-none d-md-block h4">Elevii clasei</div>

		<div class="d-none d-md-block"> <!-- header row -->

			<div class="row border p-2">

				<div class="col-md-4">
					
					<span class="font-weight-bold">Numele elevului</span>

				</div>

				<div class="col-md-6">

					<span class="font-weight-bold">Detalii si optiuni</span>	

				</div>

			</div>

		</div> <!-- header row -->

		<div id="elevi-div">

			<!-- filled with js -->

		</div>

		<div class="row border border-top-0 p-2 mb-3">

			<div class="col-md-12">

				<button class="btn btn-sm border-primary">Adauga elev</button>

			</div>

		</div>

		<div class="d-block d-md-none h4 text-right">Predarile clasei</div>
		<div class="d-none d-md-block h4">Predarile clasei</div>

		<div class="d-none d-md-block"> <!-- header row -->

			<div class="row border p-2">

				<div class="col-md-4">

					<span class="font-weight-bold">Materia predata</span>	

				</div>

				<div class="col-md-3">

					<span class="font-weight-bold">Profesorul care preda</span>	

				</div>

				<div class="col-md-5">

					<span class="font-weight-bold">Optiuni</span>	

				</div>

			</div>

		</div> <!-- header row -->

		<div id="predari-div">

			<!-- filled with js -->

		</div>

		<div class="row border border-top-0 p-2">

			<div class="col-md-12">

				<button class="btn btn-sm border-primary">Adauga predare</button>

			</div>

		</div>

	<?php endif; // current_id == -1 ?>

</div>

</body>
<footer>
	<?php if ($current_id == -1) : ?>

		<script src="?p=admin:clase&js=list"></script>

	<?php else : // current_id == -1 ?>

		<script src="?p=admin:clase&js=one"></script>

	<?php endif; ?>

	<?php include("clase.templ.php"); ?>

</footer>

</html>