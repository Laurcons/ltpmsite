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
			cu profesori şi materie”încântătoare.” ,<br> dar dacă nu-i putem schimba , putem sa ne schimbam pe noi sau cel puţin să ne adaptăm .
			Astfel am cautat o solutie care sper să te ajute !<br>
			Iată câteva citate  să te motiveze !<br>
			<br>
			„Un om educat se deosebeşte de un om needucat, asa cum un om viu se deosebeşte de un om mort.”  <br>– Aristotel
			„Invata cate ceva nou in fiecare zi cand soarele iti este deasupra. <br>Daca faci asta, nu vei fi niciodata batran.”
			„Tot ce îţi doreşti aşteaptă să ceri. Tot ce îţi doreşti te doreşte, de asemeni, pe tine.
			 <br>Trebuie însă să acţionezi pentru a obţine tot ce îţi doreşti.”- Jules Renard</p>
			<br></p>
			<img src = "images\logo.png" id="petru">
			<p id="petru_mesaj">
				Petru Maior se naste la data de 1 ianuarie 1756, în Târgu Mureş. <br>
				Esti fiul protopopului de etnie română Gheorghe Maior, iar studiile primare le face la Căpuşu de Câmpie unde tatăl său devine protopop de Iclod.<br>
				 Urmeaza studiile din cadrul Colegiului Reformat din Targu Mures si Blaj, <br>iar dupa acestea studiaza filosofie si teologie la Colegiul "De propaganda Fide" din Roma.<br>
				  Este recunoscut, în special, pentru apartinerea mişcarii cunoscuta sunt numele "Scoala ardeleana" <br>prin care aceste împreuna cu alti adepti ai miscarii lupta pentru drepturile romanilor din Transilvania.<br>
					 Unul dintre citatele sale cunoscute este urmatorul "Am oscilat intre Scoala militara si Scoala ardeleana", <br>
					 vorbe din care reiese dedicarea acestuia pentru Scoala ardeleana si spiritul românesc subjugat în acea perioadă.
			</p>
		<!-- okay stfu-->

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
