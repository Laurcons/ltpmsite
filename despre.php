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

	<div class = "box">

		<div class = "image">
			
			<img src = "https://cdn.discordapp.com/attachments/674650468319887363/693118609223843931/vrxo0yfx97p41.png">

		</div>
		<div class = "mesaj">

			<h1>Mesajul Doamnei Director </h1>
			<p>
			Mi s-a întâmplat ,dar cel mult pana la începutul  orei când profa a început să vorbească singură sau cu trei,
			în zilele bune , patru elevi şi  aşa a continuat 50 de minute de educaţie. Minunat ! asta fară sa ne gândim ca unii au în program ore consecutive cu profesori şi materie”încântătoare.”,dar dacă nu-i putem schimba , putem sa ne schimbam pe noi sau cel puţin să ne adaptăm.
			</p>

		</div>
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
