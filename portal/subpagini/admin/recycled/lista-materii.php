<?php

redirect_if_not_autoritate("admin", "/portal/");

$db = new db_connection();

$entriesPerPage = 15;
$page = 0;

if (isset($_GET['pag'])) {
	$page = $_GET["pag"];
}

$profesori = $db->retrieve_profesori('*');

$materii = $db->retrieve_materii('*');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Materii - Administrare - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>

	<script>
		$(document).ready(function(){

			$('#add-materie-coll').on('show.bs.collapse', function () {

				$('#add-materie-btn').html("Anuleaza");
				$('#add-materie-btn').attr("class", "btn btn-danger");

			});

			$('#add-materie-coll').on('hide.bs.collapse', function () {

				$('#add-materie-btn').html("Adauga materie");
				$('#add-materie-btn').attr("class", "btn btn-primary");

			});

		});
	</script>

</head>

<body style="background-color: #f5f5f5;">

	<?php $header_cpage = "admin"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

	<div class="container">

		<h2 class="mb-4">Administrare platforma</h2>

		<nav class="nav nav-pills nav-fill m-2">

			<a class="nav-item nav-link" href="/portal/?p=admin&sp=utiliz">Utilizatori</a>
			<a class="nav-item nav-link active" href="">Materii</a>

		</nav>

		<hr />

		<div class="container border rounded p-1 my-2">

			<button data-toggle="collapse" data-target="#add-materie-coll" class="btn btn-primary" id="add-materie-btn">Adauga materie</button>

			<div class="collapse" id="add-materie-coll">

				<form action="" method="POST">

					<div class="form-group">

						<label>Numele materiei:</label>

						<input type="text" name="nume" class="form-control" />

					</div>

					<div class="form-group">

						<label>Selectati profesorii care predau aceasta materie:</label>

						<?php
							while ($row = $profesori_result->fetch_assoc()) {
						?>

							<div class="form-check">

								<div class="form-check-label">

									<input type="checkbox" class="form-check-input" name="profesori[]" value="<?= $row['Id'] ?>" />
									<?= $row["Nume"] . " " . $row["Prenume"] ?>

								</div>

							</div>

						<?php } ?>

					</div>

					<input type="submit" name="add-form" class="btn btn-primary" value="Adauga materie" />

				</form>

			</div>

		</div>

		<table class="table table-striped">

			<thead>

				<th>#</th>
				<th>Nume materie</th>
				<th>Profesori care predau</th>
				<th>Suplimentar</th>

			</thead>

			<?php
				$rownum = 1;
				while ($materie = $materii_result->fetch_assoc()) {

					$profesori_result = $db->retrieve_profesori_where_predare_materie('Nume,Prenume', $materie["Id"]);
					$profesori_materie = array();
					while ($profesor = $profesori_result->fetch_assoc()) {

						$profesori_materie[] = $profesor["Nume"] . " " . $profesor["Prenume"];

					}

				// while-ul cu materii se continua
			?>
			<tr>
				<td><?= $rownum++ ?></td>
				<td><?= $materie["Nume"] ?></td>
				<td><?= implode(", ", $profesori_materie) ?></td>
				<td>

					<button class="btn btn-sm btn-info">Editeaza</button>

					<button class="btn btn-sm btn-danger">Sterge</button>

				</td>
			</tr>

			<?php } ?>

		</table>

	</div>

</body>
</html>