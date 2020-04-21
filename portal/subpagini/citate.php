<!DOCTYPE html>
<html>

<head>

	<title>Citate - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-include.php"); ?>

</head>

<body>
	<?php $header_cpage = "citate"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/navbar.php"); ?>

	<div class="container">

		<div class="jumbotron">

			<div class="h1">Citatele celebre <small>ale profesorilor</small></div>

			<p class="lead">

				Fiecare profesor are o vorba cunoscuta. Hai sa le aratam recunostinta!

			</p>

			<hr>

			<p>

				Pe unele pagini ale Portalului (momentan doar <a href="/portal/panou">panoul</a>) este afisat cate un citat al zilei, care contine cate o vorba "celebra" a profesorilor din scoala. Doresti sa contribui la colectia noastra de citate?

			</p>

		</div>

		<?php if (is_logged_in()) : ?>

			<div class="jumbotron">

				<div class="h4 mb-3">Propune un citat!</div>

				<form id="citat-form" action="/portal/citate/post" method="POST">

					<input type="hidden" id="citat-form-form-id" name="form-id" value="eh">
					<input type="hidden" name="citat-form" value="whatever">

					<textarea class="form-control mb-2" rows="3" placeholder="Citatul celebru" id="citat-form-text" name="text"></textarea>

					<input type="text" class="form-control mb-2" placeholder="Autorul (profesorul)" id="citat-form-autor" name="autor">

					<input type="text" class="form-control mb-2" placeholder="Observatii sau precizari (optional)" id="citat-form-obs" name="obs">

					<div class="form-text text-muted mb-2">Numele tau (ca propunator) nu va fi facut public.</div>

					<button type="submit" class="btn btn-primary mb-2" id="citat-form-submit">Propune!</button>

				</form>

				<div class="alert alert-success d-none" id="form-success">
					Iti multumim! Propunerea ta va fi evaluata in cel mai scurt timp.
				</div>

				<div class="alert alert-danger d-none" id="form-error">
					A aparut o eroare pe partea serverului. Incearca din nou!
				</div>

			</div>

		<?php else: ?>

			<div class="jumbotron">

				<div class="h4">Trebuie sa fii autentificat pentru a lasa un citat.</div>

				<p class="lead">Nu-ti face griji, propunerea citatelor se face in mod anonim, dar aceasta masura exista pentru a preveni spamul.</p>

				<a class="btn btn-lg btn-primary text-light" href="/portal/logare&redir=<?= urlencode("/portal/citate"); ?>">Autentificare</a>

			</div>

		<?php endif; ?>

		<?php if (is_autoritate("admin")) : ?>

			<div class="jumbotron">

				<div class="h4">Administrare citate</div>

				<p>Neimplementat.</p>

			</div>

		<?php endif; ?>

	</div>

</body>
<footer>

	<script>

		$(document).ready(function() {

			$("#citat-form").submit(function(e) {

				e.preventDefault();

				$("#citat-form-submit").attr("disabled", "");
				$("#citat-form-submit").html("Te rugam asteapta...");
				$("#form-success").addClass("d-none");
				$("#form-error").addClass("d-none");

				$.ajax({
					url: $(this).attr("action"),
					data: $(this).serialize(),
					method: "POST",
					success: function() {

						$("#form-success").removeClass("d-none");

					},
					error: function() {

						$("#form-error").removeClass("d-none");

					},
					complete: function() {

						$("#citat-form-submit").html("Propune!");
						$("#citat-form-submit").removeAttr("disabled");
						$("#citat-form")[0].reset();

					}

				});

			})

		});

	</script>

</footer>

</html>