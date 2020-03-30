
<?php
// pagina pentru erorile 404
// este customizata pentru Portal, respectiv pentru restul site-ului

// https://stackoverflow.com/questions/7118823
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

// cazul cand se acceseaza din portal
if (strpos($url, "/portal") !== false) { ?>


<!DOCTYPE html>
<html>
<head>
	<title>Eroare 503</title>

	<!-- Bootstrap -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>


<body class="container" style="padding-top: 100px; background-color: ">

	<div class="jumbotron text-center">

		<h1 class="mb-3">

			<span class="badge badge-danger">HTTP 503</span>
			Serviciu indisponibil!

		</h1>

		<p style="max-width: 50rem; margin: auto;">
			Pagina a returnat codul 503: Serviciu indisponibil. De cele mai multe ori, asta inseamna ca baza de date nu este disponibila. Te rugam sa incerci mai tarziu.
		</p>

		<p><b>// pentru loserii coderi: spuneti-i lu bub sa porneasca serverul</b></p>

		<a class="btn btn-primary" href="javascript:history.back()">Inapoi</a>

	</div>

</body>
</html>


<?php } else { ?>

<!-- Stilul pentru restul site-ului (in afara /portal) -->
<!DOCTYPE html>
<html>
<head>
	<title>Eroare 503</title>
</head>
<body>

<h1>Eroare 503 SERVICE UNAVAILABLE: Baza de date nu e disponibila</h1>

<p><b>// pentru loserii coderi: spuneti-i lu bub sa porneasca serverul</b></p>

<button onclick="history.back()">Inapoi</button>

</body>
</html>

<?php } ?>