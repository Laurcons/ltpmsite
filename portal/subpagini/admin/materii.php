<?php

$db = new db_connection();

$loggeduser = $db->retrieve_utilizator_where_username("Id", $_SESSION["logatca"]);

?>

<!DOCTYPE html>

<html>

<head>

	<title>Administrare materii - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>

</head>

<body>
	<?php $header_cpage = "admin:materii"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

	<div class="container">

		<h1>Toate materiile liceului</h3>

		<div class="d-none d-md-block"> <!-- header row -->

			<div class="row border p-2" style="border-bottom-width: 2px !important;">

				<div class="col-md-2">

					<div class="font-weight-bold">Nume materie</div>

				</div>

				<div class="col-md-3">

					<div class="font-weight-bold">Profesori atribuiti</div>

				</div>

				<div class="col-md-7">

					<div class="font-weight-bold">Optiuni</div>

				</div>

			</div>

		</div> <!-- header row -->

		<div id="table-rows">
			
			<!-- filled with javascript -->

		</div>

		<div class="row border border-top-0 p-2">

			<div class="col-md-12">

				<button type="button" class="btn btn-sm btn-default border-primary" data-toggle="modal" data-target="#adauga-materie-modal">Adauga materie</button>

			</div>

		</div>

	</div>

	<div class="modal fade" id="adauga-materie-modal">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">

					<div class="modal-title h4">Adauga o materie noua</div>

				</div>

				<div class="modal-body">

					<div class="form-group">

						<label>Denumirea materiei:</label>

						<input id="adauga-materie-form-nume"
							   type="text"
							   class="form-control"
							   form="adauga-materie-form"
							   name="nume"
							   placeholder="Denumirea cu diacritice">

						<div class="alert alert-danger d-none mt-1 p-1 pl-3"
							 data-form="adauga-materie"
							 data-for="nume">

							 <!-- filled with javascript -->

						</div>

					</div>

				</div>

				<div class="modal-footer">

					<div class="btn-group">

						<button type="button" class="btn btn-default border-primary" data-dismiss="modal">Inapoi</button>

						<input type="submit"
							   class="btn btn-primary"
							   form="adauga-materie-form"
							   value="Adauga materie">

					</div>

				</div>

			</div>

		</div>

	</div>

	<div class="modal fade" id="sterge-materie-modal">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header bg-danger">

					<h4 class="modal-title text-light">Sterge materie</h4>

				</div>

				<div class="modal-body">

					<p>Sunteti sigur ca doriti sa stergeti materia <span id="sterge-materie-modal-nume-materie"></span>?</p>

					<div class="alert alert-warning"><strong>Atentie!</strong> Toate notele, absentele si predarile care depind de aceasta materie vor fi <strong>sterse</strong>! Va rugam asigurati-va ca doriti sa faceti asta!</p></div>

					<div class="form-group">

						<label class="font-weight-bold">Va rugam sa tastati parola contului:</label>

						<input id="sterge-materie-modal-password"
							   type="password"
							   name="password"
							   form="sterge-materie-form"
							   class="form-control">

						<div class="alert alert-danger p-1 px-2 d-none" data-form="sterge-materie" data-for="password"></div>

					</div>

				</div>

				<div class="modal-footer">

					<div class="btn-group">

						<button type="button" class="btn btn-default border-danger" data-dismiss="modal">Inapoi</button>

						<input type="submit"
							   class="btn btn-danger"
							   form="sterge-materie-form"
							   value="Sterge materie">

					</div>

				</div>

			</div>

		</div>

	</div>

	<form id="adauga-materie-form">

		<input type="hidden" id="adauga-materie-form-form-id" name="form-id" value="default-value">
		<input type="hidden" name="adauga-materie" value=".">

	</form>

	<form id="sterge-materie-form">

		<input type="hidden" id="sterge-materie-form-form-id" name="form-id" value="default-value">
		<input type="hidden" id="sterge-materie-form-materie-id" name="materie-id">
		<input type="hidden" name="admin-id" value="<?= $loggeduser['Id'] ?>">
		<input type="hidden" name="sterge-materie" value=".">

	</form>

</body>
<footer>
	<script src="?p=admin:materii&js"></script>
	<?php require_once("materii.templ.php"); ?>

</footer>

</html>