<?php 

include("clase.phphead.php");

$post_href = "/portal/?p=clase&id=" . $predare_id . "&post";

 ?>

 <!DOCTYPE html>
 <html>

 <head>

 	<title>Clasele mele - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>
 	<?php // clase.js.php included at bottom ?>

 </head>
<templates>
 <template id="nota-list-template">

 	{{#note}}
 	
 	<span class="dropdown">

		<span class="float-left border border-secondary bg-white rounded p-1 mr-1 mb-1" style="width: {{size}}rem; cursor: {{cursor}};"
			data-toggle="dropdown" data-boundary="viewport">

			<h4 class="text-center">{{Nota}} <small>{{Ziua}} {{Luna}}</small></h4>

		</span>

		<div class="dropdown-menu">

			<a class="dropdown-item text-weight-bold">Inchide</a>
			<div class="dropdown-divider"></div>
			<!--<a class="dropdown-item">Acordata la {{Ziua}} {{Luna}}</a>-->
			<button class="dropdown-item bg-danger text-light"
				type="submit"
				form="anuleaza-nota-form"
				id="anuleaza-nota-{{Id}}">
				Sterge nota
			</button>

		</div>

		<script>

			$(document).ready(function() {
				var nota_id = {{Id}};
				var elev_id = {{IdElev}} ;
				linkNotaToForms(nota_id, elev_id);
			});

		</script>

	</span>

	{{/note}}

 </template>

 <template id="nota-plus-template">

	<span class="float-left border border-secondary bg-white rounded p-1 mr-1 mb-1" style="width: 2.5rem; cursor: pointer;">

		<h4 class="text-center">+</h4>

	</span>

 </template>

 <template id="absenta-list-template">

 	{{#absente}}

 	<span class="dropdown">

		<div class="d-inline float-left border border-secondary 
			{{^Motivata}}bg-white{{/Motivata}}
			{{#Motivata}}bg-secondary text-light{{/Motivata}}
		 	rounded p-1 mr-1 mb-1" style="width: {{size}}rem; cursor: {{cursor}};"
			data-toggle="dropdown" data-boundary="viewport">

			<h4 class="text-center">{{Ziua}} <small>{{Luna}}</small></h4>

		</div>
		<div class="dropdown-menu">

			<a class="dropdown-item">Inchide</a>
			<button class="dropdown-item bg-primary text-light my-3"
				form="motiveaza-absenta-form"
				type="submit"
				id="motiveaza-absenta-{{Id}}">
				{{#Motivata}}
					Demotiveaza absenta
				{{/Motivata}}
				{{^Motivata}}
					Motiveaza absenta
				{{/Motivata}}
			</button>
			<button class="dropdown-item bg-danger text-light"
				form="anuleaza-absenta-form"
				type="submit"
				id="anuleaza-absenta-{{Id}}">
				Sterge absenta
			</button>

		</div>

		<script>

			$(document).ready(function() {

				var elev_id = {{IdElev}};
				var absenta_id = {{Id}};
				linkAbsentaToForms(elev_id, absenta_id);

			});

		</script>

	</span>

	{{/absente}}

 </template>

 <template id="absenta-plus-template">

	<div class="d-inline float-left border border-secondary bg-white rounded p-1 mr-1 mb-1" style="width: 2.5rem; cursor: pointer;">

		<h4 class="text-center">+</h4>

	</div>

 </template>
</templates>

 <body>

	<?php $header_cpage = "clase"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

	<form class="d-none" id="anuleaza-nota-form">

		<input type="hidden" id="anuleaza-nota-form-user-id" name="user-id" value="who knows">
		<input type="hidden" id="anuleaza-nota-form-nota-id" name="nota-id" value="edwix_suks">
		<input type="hidden" id="anuleaza-nota-form-form-id" name="form-id" value="fill-me-daddy">
		<input type="hidden" name="anuleaza-nota" value="lugu lugu">

	</form>

	<form class="d-none" id="anuleaza-absenta-form">

		<input type="hidden" id="anuleaza-absenta-form-elev-id" name="elev-id" value="banea the best">
		<input type="hidden" id="anuleaza-absenta-form-absenta-id" name="absenta-id" value="badu the best">
		<input type="hidden" id="anuleaza-absenta-form-form-id" name="form-id" value="ltpm the best">
		<input type="hidden" name="anuleaza-absenta" value="WooHoo(tm)">

	</form>

	<form class="d-none" id="noteaza-modal-form">

		<input type="hidden" id="noteaza-modal-user-id" name="user-id" value="insert_js_here">
		<input type="hidden" id="noteaza-modal-form-id" name="form-id" value="helo">
		<!-- celelalte field-uri sunt pe modal -->
		<input type="hidden" name="noteaza" value="covid-19">

	</form>

	<form class="d-none" id="motiveaza-absenta-form"> 

		<input type="hidden" id="motiveaza-absenta-form-user-id" name="user-id" value="ehehehaehea">
		<input type="hidden" id="motiveaza-absenta-form-form-id" name="form-id" value="a zis mama ca daca nu merg acum la masa ma da cu capul de tastatugaerbgoeruagboaerugae">
		<input type="hidden" id="motiveaza-absenta-form-absenta-id" name="absenta-id" value="pornhub.com">
		<input type="hidden" name="motiveaza-absenta" value="idfk">

	</form>

	<form class="d-none" id="adauga-absenta-form">

		<input type="hidden" id="adauga-absenta-form-elev-id" name="elev-id" value="XXL">
		<input type="hidden" id="adauga-absenta-form-form-id" name="form-id" value="MICUTZU">
		<input type="hidden" name="adauga-absenta" value="ehh">

	</form>

	<div class="container">

		<?php if ($predare_id == -1) : ?>

			<h2>Clasele mele</h2>

			<h4 class="mb-3">Profesor: <?= $prof["Nume"] . " " . $prof["Prenume"] ?></h4>

			<?php 

				$predari = $db->retrieve_predari_where_profesor("*", $prof_id);

				$itemnum = -1;

			?>

			<?php while ($predare = $predari->fetch_assoc()) : ?>

				<?php 

					$itemnum++;

					$clasa = $db->retrieve_clasa_where_id("*", $predare["IdClasa"]);

					$materie = $db->retrieve_materie_where_id("*", $predare["IdMaterie"]);

				?>

				<?php if ($itemnum % 3 == 0) : ?>

					<div class="row">

				<?php endif; ?>

				<div class="col-md-4 mb-2">

					<div class="card" style="width: 100%;">

						<div class="card-body">

							<h5 class="card-title">

								<?= "Clasa " . $clasa["Nivel"] . " " . $clasa["Sufix"] ?>
								-
								<?= $materie["Nume"] ?>

							</h5>

						</div>

						<div class="list-group list-group-flush">

							<div class="list-group-item">

								In calitate de:
								<span class="font-weight-bold">
									<?= $clasa["IdDiriginte"] == $prof_id ? "Diriginte" : "Profesor" ?>
								</span>

							</div>

							<div class="list-group-item">

								<a class="btn btn-primary btn-block" href="/portal/?p=clase&id=
									<?= $predare["Id"] ?>
									">Acceseaza</a>

							</div>

						</div>

					</div>

				</div>

				<?php if ($itemnum % 3 == 2) : ?>

					</div> <!-- row -->

				<?php endif; ?>

			<?php endwhile; // predari ?>

			<?php
				// inchide div-ul de la row daca nu s-a umplut randul cu carduri
				if ($itemnum % 3 != 2)
					echo '</div>';
			?>

		<?php else : // predare_id == -1 ?>

			<?php
				$clasa = $db->retrieve_clasa_where_id("*", $predare["IdClasa"]);
				$materie = $db->retrieve_materie_where_id("*", $predare["IdMaterie"]);
			?>

			<h2 class="text-center">Clasa <?= $clasa["Nivel"] . " " . $clasa["Sufix"] ?> - <?= $materie["Nume"] ?></h2>
			<h4 class="text-center">SEMESTRUL 1</h4>
			<h4 class="text-center mb-3">Profesor: <?= $prof["Nume"] . " " . $prof["Prenume"] ?></h4>

			<?php $elevi = $db->retrieve_elevi_where_clasa("*", $clasa["Id"]); ?>

			<!-- randul de antet, doar pe md -->
			<div class="d-none d-md-block">

				<div class="row border p-2">

					<div class="col-md-2 font-weight-bold">

						Elevul

					</div>

					<div class="col-md-6 font-weight-bold">
						
						Note si absente

					</div>

					<div class="col-md-4 font-weight-bold">

						Optiuni

					</div>

				</div>

			</div> <!-- randul de antet -->

			<?php $rowcount = 0; ?>
			<?php while ($elev = $elevi->fetch_assoc()) : ?>

				<?php $rowcount++; ?>

				<div class="row border-left border-bottom border-right <?= ($rowcount == 1 ? 'border-top' : '') ?> px-2 py-3">

					<div class="col-md-2">

						<span class="d-md-none font-weight-bold">

							<h4><span class="badge badge-primary"><?= $rowcount; ?></span>
								<?= $elev["Nume"] . " " . $elev["Prenume"]; ?></h4>

						</span>
						<span class="d-md-block d-none">

							<span class="badge badge-primary"><?= $rowcount; ?></span>
							<?= $elev["Nume"] . " " . $elev["Prenume"]; ?>

						</span>

					</div>

					<div class="col-md-6 mb-2">

						<span class="font-weight-bold">Note:</span>

						<div class="row col">

							<div>

								<span class="d-inline" id="note-<?= $elev['Id'] ?>">

								</span>

								<span class="d-inline" id="note-plus-<?= $elev['Id'] ?>">

								</span>

							</div>

						</div>

						<span class="font-weight-bold">Absente:</span>

						<div class="row col">

							<div>

								<span id="absente-<?= $elev['Id'] ?>">

								</span>

								<span id="absente-plus-<?= $elev['Id'] ?>">

								</span>

							</div>

						</div>

					</div>

					<div class="col-md-4">

						<span class="d-md-none font-weight-bold">
							Optiuni:<br>
						</span>

						<p>
							Nimic aici...
						</p>

					</div>

				</div>

				<script>

					$(document).ready(function() {

						var elev_id = <?= $elev['Id'] ?>;

						ajax_updateNote(<?= $elev["Id"] ?>);
						// pune faza cu "note plus"
						$("#note-plus-<?= $elev['Id'] ?>").html(
							$("#nota-plus-template").html()
						);

						ajax_updateAbsente(<?= $elev["Id"] ?>);
						// pune aialalta faza, cu absente plus
						$("#absente-plus-<?= $elev['Id'] ?>").html(
							$("#absenta-plus-template").html()
						);

						linkElevToNoteazaModal(elev_id);
						linkElevToAdaugaAbsentaModal(elev_id);
					});

				</script>

			<?php endwhile; ?>

			<div class="modal fade" id="noteaza-modal" tabindex="-1" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">

							<div class="modal-title">
								<h4>Trece nota</h4>
							</div>

						</div>
						<div class="modal-body">

							<div class="form-group">

								<div class="input-group">

									<div class="input-group-prepend">

										<div class="input-group-text">

											Nota:

										</div>

									</div>

									<select class="form-control" form="noteaza-modal-form" name="nota" id="noteaza-modal-nota">

										<option>10</option>
										<option>9</option>
										<option>8</option>
										<option>7</option>
										<option>6</option>
										<option>5</option>
										<option>4</option>
										<option>3</option>
										<option>2</option>
										<option>1</option>

									</select>

								</div> <!-- input-group -->

							</div> <!-- form-group -->

							<div class="form-group">

								<div class="input-group">

									<div class="input-group-prepend">

										<div class="input-group-text">
											Data:
										</div>

									</div>

									<select class="form-control" form="noteaza-modal-form" name="ziua" id="noteaza-modal-ziua">

										<?php
											for ($i = 1; $i <= 31; $i++) {
												echo '<option>';
												if ($i < 10) echo '0';
												echo $i;
												echo '</option>';
											}
										?>

									</select>

									<select class="form-control" form="noteaza-modal-form" name="luna" id="noteaza-modal-luna">

										<?php
											for ($i = 1; $i <= 12; $i++) {
												echo '<option value="' . $i . '">';
												echo '&#' . (8543 + $i) . ';';
												echo '</option>';
											}
										?>

									</select>

								</div> <!-- row -->

							</div> <!-- form-group -->

							<div class="d-none alert alert-danger" id="noteaza-modal-validation-error"></div>

							<div class="d-none alert alert-danger" id="noteaza-modal-server-error">A aparut o eroare la trecerea notei. Probabil exista o nota cu aceeasi data?</div>

						</div> <!-- modal-body -->
						<div class="modal-footer">

							<div class="btn-group">

								<button type="button" class="btn btn-default border-primary" data-dismiss="modal">Inapoi</button>

								<input type="submit" form="noteaza-modal-form" class="btn btn-primary" value="Noteaza">

							</div>

						</div>

					</div>

				</div>

			</div>

			<div class="modal fade" id="adauga-absenta-modal">

				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">

							<h4>Pune absenta</h4>

						</div>

						<div class="modal-body">

							<p>Selecteaza data pe care doresti sa treci absenta.</p>

							<div class="form-group">

								<div class="input-group">

									<div class="input-group-prepend">

										<div class="input-group-text">
											Data
										</div>

									</div>

									<select class="form-control" form="adauga-absenta-form" name="ziua" id="adauga-absenta-form-ziua">
											
										<?php
											for ($i = 1; $i <= 31; $i++) {
												echo '<option>';
												if ($i < 10) echo '0';
												echo $i;
												echo '</option>';
											}
										?>

									</select>

									<select class="form-control" form="adauga-absenta-form" name="luna" id="adauga-absenta-form-luna">

										<?php
											for ($i = 1; $i <= 12; $i++) {
												echo '<option value="' . $i . '">';
												echo '&#' . (8543 + $i) . ';';
												echo '</option>';
											}
										?>

									</select>

								</div>

							</div>

							<div class="d-none alert alert-danger" id="adauga-absenta-validation-error"></div>

							<div class="d-none alert alert-danger" id="adauga-absenta-server-error">A aparut o eroare la trecerea absentei. Probabil exista deja o absenta pe aceeasi data?</div>

						</div>

						<div class="modal-footer">

							<div class="btn-group">

								<button type="button" class="btn bg-white border border-primary" data-dismiss="modal">Inapoi</button>

								<input type="submit" class="btn btn-primary" 
									form="adauga-absenta-form"
									value="Adauga absenta">

							</div>

						</div>

					</div>

				</div>

			</div>

		<?php endif; // predare_id == -1 ?>

	</div>

 
 </body>

 <footer>

 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/subpagini/clase.js.php"); ?>

 </footer>

 </html>