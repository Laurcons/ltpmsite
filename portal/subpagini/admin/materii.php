<?php

$db = new db_connection();

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

		<h3>Toate materiile liceului</h3>

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

				</div>

				<div class="modal-footer">

					<div class="btn-group">

						<button type="button" class="btn btn-default border-primary" data-dismiss="modal">Inapoi</button>

						<button type="button" class="btn btn-primary">Adauga materie</button>

					</div>

				</div>

			</div>

		</div>

	</div>

	<form id="adauga-materie-form">

		<input type="hidden" id="adauga-materie-form-form-id" name="form-id" value="default-value">
		<input type="hidden" name="adauga-materie-form" value=".">

	</form>

</body>
<footer>
	<script src="?p=admin:materii&js"></script>
	<?php require_once("materii.templ.php"); ?>

</footer>

</html>