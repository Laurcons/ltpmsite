<?php

$db = new db_connection();

$current_id = -1;

if (isset($_GET["id"])) {
	$current_id = $_GET["id"];
}

if ($current_id != -1) {

	$utilizator = $db->retrieve_utilizator_where_id("Id,Nume,Prenume,Username,Email,Functie,Autoritate,NrMatricol,IdClasa,UltimaLogare,Creat,Activat,CodInregistrare", $current_id);
	$clasa = null;
	if ($utilizator["Functie"] == "elev")
		$clasa = $db->retrieve_clasa_where_id("Id,Nivel,Sufix,IdDiriginte", $utilizator["IdClasa"]);
	else if ($utilizator["Functie"] == "profesor")
		$clasa = $db->retrieve_clasa_where_diriginte("Id,Nivel,Sufix,IdDiriginte", $utilizator["Id"]);

	$functii = array();
	$functii[] = "elev";
	$functii[] = "profesor";
	$functii[] = "neatribuit";
	$autoritati = array();
	$autoritati[] = "normal";
	$autoritati[] = "admin";

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

			<div class="display-4 text-center mb-4">
				Toti utilizatorii
			</div>

			<div data-tag="table-aux">

				<!-- filled with js -->

			</div>

			<div class="d-none d-md-block"> <!-- header row -->

				<div class="row border font-weight-bold p-2" style="border-bottom-width: 2px !important;">

					<div class="col-md-3">
						<span class="badge badge-primary">Nr</span>
						<span class="badge badge-danger">ID</span>
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

			<div id="utilizatori-table-rows" class="mb-3">

				<!-- filled with javascript -->

			</div>

			<div data-tag="table-aux">

				<!-- filled with js -->

			</div>

		<?php else : // current_id == -1 ?>

			<div class="row mb-4">

				<div class="col-sm-3">

					<a class="btn btn-default border-primary" href="?p=admin:utilizatori">Inapoi la utilizatori</a>

				</div>

				<div class="col-sm-6 text-center">

					<div class="display-4">
						Detalii utilizator
					</div>

					<div class="h4">
						<span class="badge badge-danger"><?= $utilizator["Id"] ?></span>
						<?= $utilizator["Nume"] . " " . $utilizator["Prenume"] ?>
						<small>(<?= $utilizator["Username"] ?>)</small>
					</div>

				</div>

			</div>

			<div class="d-none d-md-block h2 mb-3">
				General
			</div>
			<div class="d-block d-md-none text-right h2 mb-3">
				General
			</div>

			<div class="row mb-2">

				<div class="col-md">

					<div class="form-row">

						<div class="col-3">

							<label class="font-weight-bold">
								Functia:
							</label>

						</div>

						<div class="col">

							<select id="update-general-form-functie"
								   class="form-control form-control-sm"
								   form="update-general-form"
								   data-unsave="general"
								   name="functie">

								<?php 

									foreach ($functii as $functie) {

										echo "<option ";
										if ($functie == $utilizator["Functie"])
											echo "selected>";
										else echo ">";
										echo $functie;
										echo "</option>";

									}

								?>

							</select>

						</div>

					</div>

					<div class="form-row">

						<div class="col-3">

							<label class="font-weight-bold">
								Autoritate:
							</label>

						</div>

						<div class="col">

							<select id="update-general-form-autoritate"
								   class="form-control form-control-sm"
								   data-unsave="general"
								   form="update-general-form"
								   name="autoritate">

								<?php 

									foreach ($autoritati as $autoritate) {

										echo "<option ";
										if ($autoritate == $utilizator["Autoritate"])
											echo "selected>";
										else echo ">";
										echo $autoritate;
										echo "</option>";

									}

								?>

							</select>

						</div>

					</div>

				</div>

				<div class="col-md">

					<?php if ($utilizator["Functie"] == "profesor") : ?>

						<?php if ($clasa != null) : ?>

							Utilizatorul este <strong>diriginte</strong>
							al clasei <strong><?= $clasa["Nivel"] . "-" . $clasa["Sufix"] ?></strong>
							.

						<?php else : ?>

							Utilizatorul nu este dirigintele niciunei clase.

						<?php endif; ?>

					<?php elseif ($utilizator["Functie"] == "elev") : ?>

						<?php if ($clasa != null) : ?>

							Utilizatorul este <strong>elev</strong>
							al clasei <strong><?= $clasa["Nivel"] . "-" . $clasa["Sufix"] ?></strong>
							.

						<?php else : ?>

							Utilizatorul nu este elev al vreunei clase.

						<?php endif; ?>

					<?php else : ?>

						Utilizatorul nu este configurat.

					<?php endif; ?>

					<br class="mb-2">

					<a href="?p=admin:clase" class="btn btn-sm btn-default border-dark">Gestionare clase</a>

					<?php if ($clasa != null) : ?>

						<a href="?p=admin:clase&id=<?= $clasa['Id'] ?>" class="btn btn-sm btn-default border-dark">Gestionare <?= $clasa["Nivel"] . "-" . $clasa["Sufix"] ?></a>

					<?php endif; ?>

				</div>

				<div class="col-md">

					<b>Cont creat la:</b> <?= $utilizator["Creat"] ?>

					<br>

					<b>Activat la:</b> <?= $utilizator["Activat"] ?? "neactivat" ?>

					<br>

					<b>Ultima autentificare:</b> <?= $utilizator["UltimaLogare"] ?>

				</div>

			</div>

			<div class="collapse" data-unsave-alert="general">

				<div class="alert alert-danger">

					<div class="d-flex align-items-center">

						<div class="flex-grow-1">
							Aveti modificari nesalvate!
						</div>

						<button type="submit"
								form="update-general-form"
						 		class="btn btn-primary">
						 	Salvati modificarile
						 </button>

					</div>

				</div>

			</div>

			<div class="row">

				<div class="col-md-4">

					<div class="d-none d-md-block h2 mt-3">
						Codul de inregistrare
					</div>
					<div class="d-block d-md-none text-right h2 mt-3">
						Codul de inregistrare
					</div>

					<div class="form-row">

						<div class="col-6">

							<input type="text"
								   id="cod-inregistrare"
								   class="form-control"
								   value="<?= $utilizator['CodInregistrare'] == null ? '<inexistent>' : $utilizator['CodInregistrare'] ?>"
								   readonly>

						</div>

						<div class="col-6">

							<button type="button"
									id="generate-cod-inregistrare"
									class="btn btn-default btn-block border-dark">
								Genereaza
							</button>

						</div>

					</div>

					<p>Acest cod i se va da utilizatorului pentru a se putea inregistra.</p>

				</div>

				<div class="col-md-8">

					<div class="row col">

						<div class="d-none d-md-block h2 mt-3">
							Altele
						</div>
						<div class="d-block d-md-none text-right h2 mt-3">
							Altele
						</div>

					</div>

					<div class="row">

						<div class="col-md-6">

							<div class="form-row">

								<div class="col-6">

									<label class="font-weight-bold mt-2">Numele complet:</label>

								</div>

								<div class="col-6">

									<input type="text"
										   class="form-control"
										   form="update-altele-form"
										   data-unsave="altele"
										   name="nume"
										   placeholder="Numele"
										   value="<?= $utilizator['Nume'] ?>"
										   required>

								</div>

							</div>

							<div class="form-row">

								<div class="col">

									<input type="text"
										   class="form-control"
										   form="update-altele-form"
										   data-unsave="altele"
										   name="prenume"
										   value="<?= $utilizator['Prenume'] ?>"
										   placeholder="Prenumele complet"
										   required>

								</div>

							</div>

							<div class="form-row mt-1">

								<div class="col-3">

									<label class="font-weight-bold mt-2">Username:</label>

								</div>

								<div class="col-9">

									<input type="text"
										   class="form-control"
										   form="update-altele-form"
										   data-unsave="altele"
										   name="username"
										   value="<?= $utilizator['Username'] ?>"
										   placeholder="Numele de utilizator"
										   required>

								</div>

							</div>

						</div>

						<div class="col-md-6 mt-1 mt-md-0">

							<div class="form-row">

								<div class="col-4">

									<label class="font-weight-bold mt-2">E-mail:</label>

								</div>

								<div class="col-8">

									<input type="email"
										   form="update-altele-form"
										   data-unsave="altele"
										   class="form-control"
										   name="email"
										   value="<?= $utilizator['Email'] ?>"
										   required>

								</div>

							</div>

							<div class="form-row">

								<div class="col-4">

									<label class="font-weight-bold mt-2">Nr. matricol:</label>

								</div>

								<div class="col-8">

									<input type="text"
										   form="update-altele-form"
										   data-unsave="altele"
										   class="form-control"
										   name="nr-matricol"
										   value="<?= $utilizator['NrMatricol'] ?? "<niciunul>" ?>"
										   <?= ($utilizator["Functie"] != "elev") ? "readonly" : "" ?>
										   required>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			<div class="collapse" data-unsave-alert="altele">

				<div class="alert alert-danger">

					<div class="d-flex align-items-center">

						<div class="flex-grow-1">
							Aveti modificari nesalvate!
						</div>

						<button type="submit"
								form="update-altele-form"
						 		class="btn btn-primary">
						 	Salvati modificarile
						</button>

					</div>

				</div>

			</div>

		<?php endif; ?>

	</div> <!-- container -->

	<?php if ($current_id == -1) : ?>

	<?php else : // current_id == -1 ?>

		<form id="update-general-form">

			<input type="hidden" id="update-general-form-form-id" name="form-id" value="initial">
			<input type="hidden" name="user-id" value="<?= $current_id ?>">
			<input type="hidden" name="update-general" value="trash">

		</form>

		<form id="update-altele-form">

			<input type="hidden" id="update-altele-form-form-id" name="form-id" value="initial">
			<input type="hidden" name="user-id" value="<?= $current_id ?>">
			<input type="hidden" name="update-altele" value="trash">

		</form>

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

		<script src="?p=admin:utilizatori&js=one"></script>

	<?php endif; ?>

</footer>

</html>