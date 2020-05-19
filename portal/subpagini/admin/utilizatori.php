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

}

$functii = $CONFIG["functii"];
$autoritati = $CONFIG["autoritati"];

?>

<!DOCTYPE html>

<html>

<head>

	<title>Administrare utilizatori - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-include.php"); ?>

</head>

<body>
	<?php $header_cpage = "admin:utilizatori"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/navbar.php"); ?>

	<div class="container">

		<?php if ($current_id == -1) : ?>

			<div class="h1 text-center mb-4">
				Toți utilizatorii
			</div>

			<div data-tag="table-aux">

				<!-- filled with js -->

			</div>

			<div class="d-none d-md-block"> <!-- header row -->

				<div class="row border font-weight-bold p-2" style="border-bottom-width: 2px !important;">

					<div class="col-md-3">
						<span class="badge badge-primary">Nr</span>
						<span class="badge badge-danger">ID</span>
						Nume și prenume
					</div>

					<div class="col-md-5">
						Detalii
					</div>

					<div class="col-md-4">
						Opțiuni
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

					<a class="btn btn-default border-primary" href="/portal/admin/utilizatori">Înapoi la utilizatori</a>

				</div>

				<div class="col-sm-6 text-center">

					<div class="h1">
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

					<a href="/portal/admin/clase" class="btn btn-sm btn-default border-dark">Gestionare clase</a>

					<?php if ($clasa != null) : ?>

						<a href="/portal/admin/clase/<?= $clasa['Id'] ?>" class="btn btn-sm btn-default border-dark">Gestionare <?= $clasa["Nivel"] . "-" . $clasa["Sufix"] ?></a>

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

					<div class="row">

						<div class="col">

							<div class="d-none d-md-block h2 mt-3">
								Altele
							</div>
							<div class="d-block d-md-none text-right h2 mt-3">
								Altele
							</div>

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

			<?php if ($utilizator["Functie"] == "profesor") : ?>

				<div class="d-none d-md-block h2 mt-3">
					Materii predate de profesor
				</div>
				<div class="d-block d-md-none text-right h2 mt-3">
					Materii predate de profesor
				</div>

				<div class="d-none d-md-block"> <!-- header row -->

					<div class="row border p-2">

						<div class="col-md-3">

							<div class="font-weight-bold">Materia predată</div>

						</div>

						<div class="col-md-3">

							<div class="font-weight-bold">Clasele la care preda</div>

						</div>

						<div class="col-md-2">

							<div class="font-weight-bold">Tip teză</div>

						</div>

						<div class="col-md-4">

							<div class="font-weight-bold">Opțiuni</div>

						</div>

					</div>

				</div> <!-- header row -->

				<div id="materii-rows">

					<!-- filled with javascript -->

				</div>

				<div class="row border p-2">

					<div class="col">

						<button class="btn btn-default border-primary btn-sm"
								data-toggle="modal"
								data-target="#adauga-materie-modal">
							Adaugă materie
						</button>

					</div>

				</div>

			<?php endif; ?>

			<div class="d-none d-md-block h2 mt-3">
				Actiuni
			</div>
			<div class="d-block d-md-none text-right h2 mt-3">
				Actiuni
			</div>

			<div class="row">

				<div class="col">

					<button id="delete-utilizator-button"
							class="btn btn-default border-danger"
							data-toggle="modal"
							data-target="#sterge-utilizator-modal">
						Sterge utilizator
					</button>

				</div>

			</div>

		<?php endif; ?>

	</div> <!-- container -->

	<?php if ($current_id == -1) : ?>

		<div class="modal fade" id="adauga-utilizator-modal">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<h4 class="modal-title">Adaugă utilizator</h4>

					</div>

					<div class="modal-body">

						<p>Va rugam sa configurati utilizatorul. Toate aceste optiuni pot fi modificate mai tarziu.</p>

						<div class="form-group">

							<label class="font-weight-bold">Nume și prenume:</label>

							<div class="input-group">

								<input type="text"
									   class="form-control"
									   form="adauga-utilizator-form"
									   name="nume"
									   placeholder="Numele de familie">

								<input type="text"
									   class="form-control"
									   form="adauga-utilizator-form"
									   name="prenume"
									   placeholder="Toate prenumele">

							</div>

							<div class="alert alert-danger py-1 px-3 d-none" data-form="adauga-utilizator" data-for="nume">
							</div>

						</div>

						<div class="form-group">

							<label class="font-weight-bold">Numele de utilizator:</label>

							<input type="text"
								   class="form-control"
								   form="adauga-utilizator-form"
								   name="username"
								   placeholder="Doar litere, numere si '_'">

							<div class="alert alert-danger py-1 px-3 d-none" data-form="adauga-utilizator" data-for="username">
							</div>

						</div>

						<div class="form-group">

							<label class="font-weight-bold">Adresa de e-mail:</label>

							<input type="email"
								   class="form-control"
								   form="adauga-utilizator-form"
								   name="email">

							<div class="alert alert-danger py-1 px-3 d-none" data-form="adauga-utilizator" data-for="email">
								error
							</div>

						</div>

						<div class="form-group">

							<label class="font-weight-bold">Funcția și autoritatea:</label>

							<div class="input-group">

								<select class="form-control"
										form="adauga-utilizator-form"
										name="functie">

									<?php foreach ($functii as $functie) : ?>

										<?= "<option " . (($functie == "elev") ? "selected>" : ">") ?>
										<?= $functie ?>
										<?= "</option>" ?>

									<?php endforeach; ?>

								</select>

								<select class="form-control"
										form="adauga-utilizator-form"
										name="autoritate">

									<?php foreach ($autoritati as $autorit) : ?>

										<?= "<option " . (($autorit == "normal") ? "selected>" : ">") ?>
										<?= $autorit ?>
										<?= "</option>" ?>

									<?php endforeach; ?>

								</select>

							</div>

						</div>

						<div class="form-group">

							<div class="form-check">

								<input type="checkbox"
									   class="form-check-input"
									   form="adauga-utilizator-form"
									   id="adauga-utilizator-form-is-inserted-into-class"
									   name="is-inserted-into-class"
									   checked>

								<label class="font-weight-bold font-check-label" for="adauga-utilizator-form-is-inserted-into-class">
									Insereaza în clasă:

									<span class="spinner-border spinner-border-sm text-primary mx-2 d-none"
										  id="adauga-utilizator-modal-clase-spinner">
									</span>

								</label>

							</div>

							<select class="form-control"
									form="adauga-utilizator-form"
									name="insert-into-class">

							</select>

						</div>

					</div>

					<div class="modal-footer">

						<div class="alert alert-danger px-3 py-1 d-none" data-form="adauga-utilizator" data-for="submit">

						</div>

						<div class="btn-group">

							<button type="button" data-dismiss="modal" class="btn btn-default border-primary">
								Înapoi
							</button>

							<button type="submit"
									form="adauga-utilizator-form"
									class="btn btn-primary">
								Adaugă utilizator
							</button>

						</div>

					</div>

				</div>

			</div>

		</div>

		<form id="adauga-utilizator-form">

			<input type="hidden" name="form-id">
			<input type="hidden" name="adauga-utilizator">

		</form>

	<?php else : // current_id == -1 ?>

		<div class="modal fade" id="adauga-materie-modal">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<h4 class="modal-title">
							Adauga materie
						</h4>

					</div>

					<div class="modal-body">

						<p>Precizeaza materia ce se va preda, si clasa.</p>

						<div class="form-group">

							<label class="font-weight-bold">Materia predata:</label>

							<input type="text"
								   class="form-control"
								   form="adauga-materie-form"
								   name="materie">

						</div>

						<div class="form-group">

							<label class="font-weight-bold">Clasa la care se preda:</label>

							<select class="form-control"
									name="clasa"
									form="adauga-materie-form">

								<!-- filled with javascript -->

							</select>

						</div>

						<div class="form-group form-row">

							<div class="col-3 col-form-label">
								<label class="font-weight-bold">Tip teza:</label>
							</div>

							<div class="col-9">

								<select class="form-control"
										name="tip-teza"
										form="adauga-materie-form">

									<option value="nu">Nu se da teza</option>
									<option value="optional">Teza e la alegere</option>
									<option value="obligatoriu">Teza e obligatorie</option>

								</select>

							</div>

						</div>

					</div>

					<div class="modal-footer">

						<span class="spinner-border spinner-border-sm text-primary" id="adauga-materie-modal-spinner"></span>

						<div class="btn-group">

							<button class="btn btn-default border-primary" data-dismiss="modal">Înapoi</button>

							<button type="submit"
									form="adauga-materie-form"
									class="btn btn-primary">
								Adauga materie
							</button>

						</div>

					</div>

				</div>

			</div>

		</div>

		<div class="modal fade" id="sterge-materie-modal">
		
			<div class="modal-dialog">
		
				<div class="modal-content">
		
					<div class="modal-header bg-danger text-white">
		
						<h4 class="modal-title">
							Sterge materie
						</h4>
		
					</div>
		
					<div class="modal-body">
		
						<p>Sunteti sigur ca doriti sa stergeti materia?</p>

						<p>Toate notele, absentele si punctele de activitate ce tin de materie vor fi sterse!</p>
		
					</div>
		
					<div class="modal-footer">
		
						<div class="btn-group">
		
							<button type="button" class="btn btn-default border-danger" data-dismiss="modal">Înapoi</button>
		
							<button type="submit"
									form="sterge-materie-form"
									class="btn btn-danger">
								Sterge materie
							</button>
		
						</div>
		
					</div>
		
				</div>
		
			</div>
		
		</div>

		<div class="modal fade" id="sterge-utilizator-modal">
		
			<div class="modal-dialog">
		
				<div class="modal-content">
		
					<div class="modal-header bg-danger">
		
						<h4 class="modal-title text-white">
							Sterge utilizator
						</h4>
		
					</div>
		
					<div class="modal-body">

						<div class="alert alert-warning">

							<strong>Atentie!</strong> Aceasta actiune este inalt destructiva! <strong>Toate datele care tin de acest utilizator,</strong> precum toate notele, absentele, sau activitatea elevului sau ale profesorului, <strong>vor fi sterse complet</strong>!

						</div>

						<span class="spinner-border text-primary mx-2"
							  data-variant="loading">
						</span>

						<div class="d-none" data-variant="available">

							<p>Pentru a continua, va rugam sa va confirmati parola si sa rescrieti numele de utilizator al utilizatorului.</p>

							<div class="form-group">

								<label class="font-weight-bold">Confirmati parola dvs:</label>

								<input type="password"
									   class="form-control"
									   form="sterge-utilizator-form"
									   name="password">

							</div>

							<div class="form-group">

								<label class="font-weight-bold">Scrieti numele de utilizator (<code><?= $utilizator["Username"] ?></code>) mai jos:</label>

								<input type="text"
									   class="form-control"
									   id="sterge-utilizator-username">

							</div>

							<div class="alert alert-danger p-1 px-2 d-none" data-form="sterge-utilizator" data-for="form">

							</div>

						</div>

						<div class="d-none" data-variant="unavailable">

							<div class="alert alert-danger">

								Acest utilizator <strong>nu poate fi sters</strong> deoarece este dirigintele unei clase. Pentru a putea sterge utilizatorul, schimbati dirigintele clasei sau stergeti clasa, si incercati din nou.

							</div>

						</div>
		
					</div>
		
					<div class="modal-footer">
		
						<div class="btn-group">
		
							<button type="button" class="btn btn-default border-danger" data-dismiss="modal">Înapoi</button>
		
							<button type="submit"
									form="sterge-utilizator-form"
									class="btn btn-danger"
									disabled>
								Sterge utilizator
							</button>
		
						</div>
		
					</div>
		
				</div>
		
			</div>
		
		</div>

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

		<form id="adauga-materie-form">

			<input type="hidden" name="form-id" value="initial">
			<input type="hidden" name="user-id" value="<?= $current_id ?>">
			<input type="hidden" name="adauga-materie" value="trash">

		</form>

		<form id="sterge-materie-form">

			<input type="hidden" name="form-id" value="initial">
			<input type="hidden" name="predare-id">
			<input type="hidden" name="sterge-materie" value="trash">

		</form>

		<form id="sterge-utilizator-form">

			<input type="hidden" name="form-id" value="initial">
			<input type="hidden" name="user-id" value="<?= $current_id ?>">
			<input type="hidden" name="sterge-utilizator">

		</form>

	<?php endif; ?>

</body>

<footer>

	<?php if ($current_id == -1) : ?>

		<script src="/portal/admin/utilizatori/js/list"></script>
		<?php require_once("utilizatori.list.templ.php"); ?>

	<?php else : // current_id == -1 ?>

		<script src="/portal/admin/utilizatori/js/one"></script>
		<?php require_once("utilizatori.one.templ.php"); ?>

		<script>

			var utilizator_functie = "<?= $utilizator['Functie'] ?>";
			var utilizator_username = "<?= $utilizator['Username'] ?>";

		</script>

	<?php endif; ?>

	<style>

		.table-row:hover {

			background-color: #ddd;

		}

	</style>

</footer>

</html>