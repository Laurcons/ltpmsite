<?php 

redirect_if_not_logged_in("/portal");
$db = new db_connection();

$tab = "note";

if (isset($_GET["tab"])) {
	$tab = $_GET["tab"];
}

$semestru = "1";

if (isset($_GET["sem"])) {
	$semestru = $_GET["sem"];
}

$prevclase_index = 0;

if (isset($_GET["an"])) {
	$prevclase_index = $_GET["an"];
}

$user = $db->retrieve_utilizator_where_username("Id,IdClasa", $_SESSION["logatca"]);

$prevclase = $db->retrieve_utilizator_where_id("PrevClase", $user['Id'])["PrevClase"];
if ($prevclase != null)
	$prevclase = explode(",", $prevclase);

$prevclasa = null;

if ($prevclase_index != 0) {

	// ia id-ul clasei
	$nr = count($prevclase);
	$index = $nr - $prevclase_index;
	$prevclasa = $db->retrieve_clasa_where_id("*", $prevclase[$index]);

}

?>

 <!DOCTYPE html>
 <html>

 <head>

 	<title>Situatia elevului - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>

 </head>

 <body>

 	<header>
	<?php $header_cpage = "situatia"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>
	<script>
		// asta e aici ca sa mearga tooltipurile
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});

	</script>
	</header>

	<div class="container">

		<?php

			if ($prevclase_index == 0)
				$clasa = $db->retrieve_clasa_where_id("*", $user["IdClasa"]);
			else $clasa = $prevclasa;

		?>

		<center>

			<h3>

				<!--<?php if ($prevclase == null || $prevclase_index == count($prevclase)) : ?>
					<a class="text-muted">
				<?php else : ?>
					<a href="?p=situatia&an=<?= $prevclase_index + 1 ?>" style="text-decoration: none;">
				<?php endif; ?>

						<i class="far fa-caret-square-left"></i>
					</a>
				-->

				&nbsp;
				<?php echo "CLASA " . $clasa["Nivel"] . " " . $clasa["Sufix"]; ?>
				&nbsp;

				<!--<?php if ($prevclase_index == 0) : ?>
					<a class="text-muted">
				<?php else : ?>
					<a href="?p=situatia&an=<?= $prevclase_index - 1 ?>" style="text-decoration: none;">
				<?php endif; ?>

						<i class="far fa-caret-square-right" disabled></i>
					</a>
				-->

			</h3>

			<h5 class="mb-1">
				<?php if ($semestru == "2") : ?>
					<a href="?p=situatia&tab=<?= $tab ?>&sem=1" style="text-decoration: none;">
				<?php else : ?>
					<a class="text-muted">
				<?php endif; ?>

						<i class="far fa-caret-square-left"></i>
					</a>

				&nbsp;
				SEMESTRUL <?= $semestru ?>
				&nbsp;

				<?php if ($semestru == "1") : ?>
					<a href="?p=situatia&tab=<?= $tab ?>&sem=2" style="text-decoration: none;">
				<?php else : ?>
					<a class="text-muted">
				<?php endif; ?>

						<i class="far fa-caret-square-right" disabled></i>
					</a>

			</h5>
			<h5>

				<?php echo $clasa["AnScolar"] . " - " . ($clasa["AnScolar"] + 1); ?>
					
			</h5>

		</center>

		<div class="nav nav-tabs">

			<li class="nav-item"><a class="nav-link<?= ($tab == 'note' ? ' active' : '') ?>" href="/portal/?p=situatia&tab=note&sem=<?= $semestru ?>">
				Note
			</a></li>

			<li class="nav-item"><a class="nav-link<?= ($tab == 'absente' ? ' active' : '') ?>" href="/portal/?p=situatia&tab=absente&sem=<?= $semestru ?>">
				Absente
			</a></li>

		</div>

		<?php

			$materii = $db->retrieve_materii_where_predare_elev("*", $user["Id"]);

		?>

		<?php if ($tab == "note") : ?>

			<!-- randul de antet, doar pe md+ -->
			<div class="d-none d-md-block">

				<div class="row border p-2">

					<div class="col-md-2 font-weight-bold">

						Materia

					</div>

					<div class="col-md-6 font-weight-bold">
						
						Note

					</div>

					<div class="col-md-4 font-weight-bold">

						Altele

					</div>

				</div>

			</div> <!-- randul de antet -->

			<?php $rowcount = 0; ?>
			<?php while ($materie = $materii->fetch_assoc()) : ?>

				<?php $rowcount++; ?>

				<div class="row border-left border-bottom border-right <?= ($rowcount == 1 ? 'border-top' : '') ?> p-2">

					<div class="col-md-2">

						<span class="d-inline d-md-none font-weight-bold font-italic">Materia:</span>
						<?= $materie["Nume"]; ?>

					</div>

					<div class="col-md-6">

						<span class="d-md-none font-weight-bold">Note:</span>

						<div class="row col">
							<?php 

								$note = $db->retrieve_note_where_utilizator_and_materie_and_semestru("Nota,Ziua,Luna", $user["Id"], $materie["Id"], $semestru);

								if ($note->num_rows != 0) {

									while ($nota = $note->fetch_assoc()) {

										insert_nota($nota);

									}

								} else {

									echo '<span>Nu exista</span>';

								}

							?>
						</div>

					</div>

					<div class="col-md-4">

						<div> <!-- inline-ul cu activitatea -->

							<?php $activitate = $db->retrieve_activitate_where_utilizator_and_materie("*", $user["Id"], $materie["Id"]); ?>

							<span class="d-inline font-weight-bold">Activitate:</span>

							<div class="d-inline">
								<i class="far fa-plus-square"></i>&nbsp;<?= $activitate["Plusuri"] == null ? 0 : $activitate["Plusuri"] ?>
							</div>

							<div class="d-inline">
								<i class="far fa-minus-square"></i>&nbsp;<?= $activitate["Minusuri"] == null ? 0 : $activitate["Minusuri"] ?>
							</div>

						</div>

						<div> <!-- inline-ul cu media -->

							<?php $medie = $db->calculate_medie_where_utilizator_and_materie_and_semestru($user["Id"], $materie["Id"], $semestru); ?>

							<span class="d-inline font-weight-bold">Media semestriala:</span>

							<div class="d-inline"> <?= $medie != 0 ? $medie : "Nu exista" ?> </div>

						</div>

					</div>

				</div>

			<?php endwhile; ?>

		<?php elseif ($tab == "absente") : ?>

			<!-- randul de antet, doar pe md+ -->
			<div class="d-none d-md-block">

				<div class="row border p-2">

					<div class="col-md-2 font-weight-bold">

						Materia

					</div>

					<div class="col-md-6 font-weight-bold">
						
						Absente

					</div>

					<div class="col-md-4 font-weight-bold">

						Altele

					</div>

				</div>

			</div> <!-- randul de antet -->

			<?php $rowcount = 0; ?>
			<?php while ($materie = $materii->fetch_assoc()) : ?>

				<?php $rowcount++; ?>

				<div class="row border-left border-bottom border-right <?= ($rowcount == 1 ? 'border-top' : '') ?> p-2">

					<div class="col-md-2">

						<span class="d-inline d-md-none font-weight-bold font-italic">Materia:</span>
						<?= $materie["Nume"]; ?>

					</div>

					<div class="col-md-6">

						<span class="d-md-none font-weight-bold">Absente:</span>

						<div class="row col">
							<?php 

								$note = $db->retrieve_absente_where_utilizator_and_materie_and_semestru("Ziua,Luna", $user["Id"], $materie["Id"], $semestru);

								if ($note->num_rows != 0) {

									while ($nota = $note->fetch_assoc()) {

										insert_absenta($nota);

									}

								} else {

									echo '<span>Nu exista</span>';

								}

							?>
						</div>

					</div>

					<div class="col-md-4">



					</div>

				</div>

			<?php endwhile; ?>

		<?php endif ?> <!-- if note -->

	</div>

 
 </body>

 </html>