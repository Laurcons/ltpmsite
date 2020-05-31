<!DOCTYPE html>

<html>

<head>

	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title>Liceul Teoretic Petru Maior - Ocna Mures</title>

	<link href="style/main.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" type="text/css" href="style/mobile.css" media="screen and (max-width: 768px)" />

	<link rel="stylesheet" type="text/css" href="style/main.css" media="screen and (min-width: 769px)" />

	<link href="style/main.css" rel="stylesheet" type="text/css" media="screen and (min-width: 769px)" />

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

		<div class="image">
			
			<img src = "https://cdn.discordapp.com/attachments/674650468319887363/693118609223843931/vrxo0yfx97p41.png">

		</div>

		<div class = "mesaj">

			<h1 id="h1_id">Mesajul Doamnei Director </h1>

			<div >
			
			<img src = "https://cdn.discordapp.com/attachments/674650468319887363/693118609223843931/vrxo0yfx97p41.png" id = "image">

			</div>

			<p id="mesaj_paraghraps">
			Mi s-a întâmplat, dar cel mult pana la începutul  orei când profa a început să vorbească singură sau cu trei,
			în zilele bune , patru elevi şi  aşa a continuat 50 de minute de educaţie. Minunat  asta fară sa ne gândim ca unii au în program ore consecutive cu profesori şi materie”încântătoare.”,dar dacă nu-i putem schimba , putem sa ne schimbam pe noi sau cel puţin să ne adaptăm.Mi s-a întâmplat, dar cel mult pana la începutul  orei când profa a început să vorbească singură sau cu trei, în zilele bune , patru elevi şi  aşa a continuat 50 de minute de educaţie. Minunat! asta fară sa ne gândim ca unii au în program ore consecutive cu profesori şi materie”încântătoare.”,dar dacă nu-i putem schimba , putem sa ne schimbam pe noi sau cel puţin să ne adaptăm.Mi s-a întâmplat, dar cel mult pana la începutul  orei când profa a început să vorbească singură sau cu trei, în zilele bune , patru elevi şi  aşa a continuat 50 de minute de educaţie. Mi s-a întâmplat, dar cel mult pana la începutul  orei când profa a început să vorbească singură sau cu trei,
			</p>

		</div>

		<br>
		
	</div>

	<!--<div class = "box_petru">
		<div class = "image_petru">
			
			<img src = "https://cdn.discordapp.com/attachments/674650468319887363/693118609223843931/vrxo0yfx97p41.png">

		</div>

		<div class = "mesaj_petru">

			<p>
			Petru Maior se naste la data de 1 ianuarie 1756, în Târgu Mureş. Esti fiul protopopului de etnie română Gheorghe Maior, iar studiile primare le face la Căpuşu de Câmpie unde tatăl său devine protopop de Iclod.
			Urmeaza studiile din cadrul Colegiului Reformat din Targu Mures si Blaj, iar dupa acestea studiaza filosofie si teologie la Colegiul "De propaganda Fide" din Roma. Este recunoscut, în special, pentru apartinerea mişcarii cunoscuta sunt numele 
			"Scoala ardeleana" prin care aceste împreuna cu aladepai miscarii lupta pentru drepturile romanilor din Transilvania.
			Unul dintre citatele sale cunoscute este urmatorul "Am oscilat intre Scoala militara si Scoala ardeleana", 
			vorbe din care reiese dedicarea acestuia pentru Scoala ardeleana si spiritul românesc subjugat în acea perioadă.
			</p>

		<hr>
		</div>

	</div>-->
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
