<!DOCTYPE html>

<html>

<head>

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title>Liceul Teoretic Petru Maior - Ocna Mures</title>

	<link href="style/main.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" type="text/css" href="style/mobile.css" media="screen and (max-width: 768px)" />

</head>

<body>

	<div id="title_div">


	</div>

	<?php include("snips/menu-html.php"); ?>

	<div class="container" onclick="menu(this)">

		<div class="bar1"></div>

		<div class="bar2"></div>

		<div class="bar3"></div>

	</div>

		<h1 id = "titlu_despre" > Doamna Hitler Alina</h1>

		<img src = "images\pustai.jpg" id="pustai">

		<p id="pustai_mesaj">
			Mi s-a întâmplat ,dar cel mult pana la începutul  orei când profa a început să vorbească singură sau cu trei,<br>
			în zilele bune , patru elevi şi  aşa a continuat 50 de minute de educaţie.<br> Minunat ! asta fară sa ne gândim ca unii au în program ore consecutive
			cu profesori şi materie”încântătoare.” ,<br> dar dacă nu-i putem schimba , putem sa ne schimbam pe noi sau cel puţin să ne adaptăm.
		<p>

</body>

<script type="text/javascript">

	function menu(x) {

		x.classList.toggle("change");

		if (document.getElementById('menu_div').style.visibility === "visible") {

			document.getElementById('menu_div').style.visibility = "hidden";

			if (window.innerWidth < 768) {

				$("#center_div").show();
				$("#menu_div").show();

			}

		} else {

			if (window.innerWidth > 767) {

				$("#center_div").show();
				$("#menu_div").show();

			}

			document.getElementById('menu_div').style.visibility = "visible";

			$(document).ready(function() {

				$("#center_div").hide();

			});

		}

	}

</script>

</html>
