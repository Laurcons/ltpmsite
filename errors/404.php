
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
	<title>Eroare 404</title>

	<!-- Bootstrap -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<!-- Font Awesome; edward te rog taci -->
	<script src="https://kit.fontawesome.com/4288ed77ca.js" crossorigin="anonymous"></script>

</head>


<body class="container" style="padding-top: 100px">

	<div class="jumbotron text-center">

		<h1>Pagina nu s-a gasit!</h1>
		<h1><small>Portalul nu contine pagina cautata. Ne pare rau.</small></h1>
		<h1><small>Eroare 404: Not Found</small></h1>

		<a class="btn btn-primary" href="javascript:history.back()">Inapoi</a>

	</div>

</body>
</html>


<?php } else { ?>

<!-- Stilul pentru restul site-ului (in afara /portal) -->
<!DOCTYPE html>
<html>
<head>
	<title>Eroare 404</title>
</head>
<body>

<p>edward misca-ti curu si fa o pagina de 404 aici</p>

<p>apropo, 404 Not Found, pagina cautata nu exista, te rog marsh acas</p>

<button onclick="history.back()">Inapoi</button>

</body>
</html>

<?php } ?>