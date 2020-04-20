<?php

// LICENSE:
// cine se atinge de codul meu e gay
// -bub

$db = new db_connection();

redirect_if_not_logged_in("/portal/");

?>

<!DOCTYPE html>

<html>

<head>
	<title>Panou control - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>
</head>

	<script>

		$(window).on('load', function() {

			$("#alert-login-coll").collapse("show");

			$("#alert-login-coll").on("hidden.bs.collapse", function() {

				$("#alert-login-alert").alert('close');

			});

			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			});

		});



	</script>

<body style="background-color: #f5f5f5;">

	<?php $header_cpage = "panou"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

	<div class="container">

		<?php if (isset($_GET["src"]) && $_GET["src"] == "prima") : ?>

			<!-- HIDDEN, DISABLED -->

			<div class="d-none collapse" id="alert-login-coll">

				<div class="alert alert-danger">

					<button type="button" class="close" onclick="$('#alert-login-coll').collapse('hide');" id="alert-login-alert">&times;</button>

					Daca doriti sa ajungeti pe prima pagina a portalului, va rugam sa <a href="/portal/?pagina=logout" class="alert-link">iesiti din cont</a>.

				</div>
			</div>

		<?php endif ?>

		<?php

			// incarca un citat aleator
			$citat = $db->retrieve_citat_random("*");

		?>

		<div class="border p-3 mb-4">

			<?php if ($citat != null) : ?>

				<div class="blockquote text-center mt-sm-2">

					<div class="text-muted font-italic mb-2">Citatul zilei <small><span class="text-muted">// </span><a href="/portal/citate">propune un citat</a></small></div>

					<p class="mb-0"><?= utf8_for_xml($citat["Text"]); //$citat["Text"] ?></p>
					<footer class="blockquote-footer"><?= $citat["Autor"] ?></footer>

				</div>

			<?php else : ?>

				<div class="text-center">

					<p>Inca nu avem citate celebre ale profesorilor in baza de date.</p>

					<a href="/portal/citate">Propune unul!</a>

				</div>

			<?php endif; ?>

		</div>

		<?php if ($_SESSION["autoritate"] == "admin"): ?>

			<div class="border p-3">
			
				<div class="row">

						<div class="col-md">

							<h3>Sunteti logat ca Administrator</h3>

							<p>Asta inseamna ca aveti control total asupra datelor din Portalul LTPM.</p>
							
							<div class="alert alert-warning">Va rugam sa va asigurati ca iesiti din cont dupa ce terminati treaba!</div>

							<div class="alert alert-info">Ultima logare: <?php echo $_SESSION["ultimalogare"]; ?></div>
								
						</div>

				</div>

			</div>

		<?php endif ?> <!-- autoritate: admin -->

		<?php if ($_SESSION["functie"] == "elev") : ?>

			<div class="well">

				<div class="row">

					<div class="col-sm-6">

						<h1>Situatia la zi</h1>

						<p>Nimic aici. Intra la 'Situatie' din meniu.</p>

					</div>

				</div>

			</div>

		<?php endif ?><!-- functie: elev -->

		<div> 

		</div>

	</div>

</body>
</html>