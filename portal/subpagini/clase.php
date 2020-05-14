<?php 

include("clase.phphead.php");

 ?>

 <!DOCTYPE html>
 <html>

 <head>

 	<title>Clasele mele - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-include.php"); ?>
 	<?php // clase.js included at bottom ?>

 </head>

 <body>

	<?php $header_cpage = "clase"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/navbar.php"); ?>

	<div class="container">

		<?php if ($is_list) : ?>

			<h2>Clasele mele</h2>

			<h4 class="mb-3">Profesor: <?= $prof["Nume"] . " " . $prof["Prenume"] ?></h4>

			<div class="row row-cols-1 row-cols-md-3" id="clase-cards">

			</div>

		<?php else : // is_list ?>

			<?php
				$clasa = $db->retrieve_clasa_where_id("*", $materie["IdClasa"]);
				$diriginte = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $clasa["IdDiriginte"]);
				$is_prof_diriginte = $clasa["IdDiriginte"] == $prof["Id"];
			?>

			<div class="row">

				<div class="col-md-4">

					<a class="btn btn-default border-primary"
					   href="/portal/clase">
					    Inapoi la clasele mele
					</a>

				</div>

				<div class="col-md-4">

					<h2 class="text-center">Clasa <?= $clasa["Nivel"] . " " . $clasa["Sufix"] ?> - <?= $materie["Nume"] ?></h2>
					<h4 class="text-center">
						<?php if ($semestru == "2") : ?>
							<a href="?sem=1" class="text-decoration-none">&lt;</a>
						<?php endif; ?>
						SEMESTRUL <?= $semestru ?>
						<?php if ($semestru == "1") : ?>
							<a href="?sem=2" class="text-decoration-none">&gt;</a>
						<?php endif; ?>
					</h4>
					<!--<h5 class="text-center">Profesor: <?= $prof["Nume"] . " " . $prof["Prenume"] ?></h5>-->
					<h5 class="text-center mb-3">Diriginte: <?= $diriginte["Nume"] . " " . $diriginte["Prenume"] ?></h5>

				</div>

			</div>

			<div class="accordion" id="options-accordion">

				<div class="d-flex flex-wrap">

					<button type="button" data-toggle="collapse" data-target="#teza-options-collapse" class="btn btn-default btn-sm border-info mx-1">
						Detalii teza
					</button>

					<?php if ($is_prof_diriginte) : ?>

						<button type="button"
								class="btn btn-sm btn-default border-info mx-1"
								id="motivari-button">
								<!-- collapse toggled from js -->
							Motivari si scutiri
						</button>

					<?php endif; ?>

				</div>

				<div class="collapse" id="teza-options-collapse" data-parent="#options-accordion">

					<div class="border p-3">

						<p>

							<?php
								$tezaString = "";
								switch ($materie["TipTeza"]) {
									case "nu": $tezaString = "Clasa nu da teza;"; break;
									case "optional": $tezaString = "Teza este la alegere;"; break;
									case "obligatoriu": $tezaString = "Teza este obligatorie;"; break;
								}
							?>
							<?= $tezaString ?>

						<p>

						<?php if ($materie["TipTeza"] == "optional") : ?>

							<button type="button" data-toggle="modal" data-target="#preferinte-teza-modal" class="btn btn-default btn-sm border-info mx-1">
								Seteaza preferinte teza
							</button>

						<?php endif; ?>

					</div>

				</div>

				<?php if ($is_prof_diriginte) : ?>

					<div class="collapse" id="motivari-collapse" data-parent="#options-accordion">

						<div class="border p-3">

							<div class="table-responsive">

								<table class="table table-bordered table-hover table-sm" id="motivari-table">

									<thead class="table-header">

										<tr>

											<th>Elevul</th>
											<th>
												<span class="d-none d-md-block">Absente motivate</span>
												<span class="d-md-none">Ab. mot.</span>
											</th>
											<th>
												<span class="d-none d-md-block">Absente nemotivate</span>
												<span class="d-md-none">Ab. nemot.</span>
											</th>
											<th>Motivari</th>

										</tr>

									</thead>

									<tbody>

									</tbody>

								</table>

							</div>

						</div>

					</div>

				<?php endif; ?>

			</div>

			<?php $elevi = $db->retrieve_elevi_where_clasa("*", $clasa["Id"]); ?>

			<!-- randul de antet, doar pe md -->
			<div class="d-none d-md-block mt-3">

				<div class="row border p-2" style="border-bottom-width: 2px !important;">

					<div class="col-md-3 font-weight-bold">

						Elevul

					</div>

					<div class="col-md-5 font-weight-bold">
						
						Note si absente

					</div>

					<div class="col-md-4 font-weight-bold">

						Optiuni

					</div>

				</div>

			</div> <!-- randul de antet -->

			<div id="elevi-rows" style="min-height: 5rem;">

			</div>

		<?php endif; // is_list ?>

	</div>

 
 </body>

 <?php require("clase.footer.php"); ?>

 </html>