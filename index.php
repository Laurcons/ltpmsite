<!DOCTYPE html>

<html>

<head>

	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<link rel="icon" type="image/png" href="http://laurcons.ddns.net/media/favicon-16x16.ico" />

	<link rel="icon" type="image/png" href="http://laurcons.ddns.net/media/favicon-32x32.ico" />

	<title>Liceul Teoretic Petru Maior - Ocna Mures</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://unpkg.com/diapositive@latest/dist/diapositive.js"></script>

	<!-- custom script, added by bub, minor modifications -->
	<script type="text/javascript" src="media.js"></script>

	<link href="style/main.css" rel="stylesheet" type="text/css" media="screen and (min-width: 769px)" />

	<link rel="stylesheet" type="text/css" href="style/mobile.css" media="screen and (max-width: 768px)" />

</head>

<body>

	<div id="title_div">
		
		<h1 id="title">Liceul Teoretic Petru Maior - Ocna-Mures</h1>

	</div>

	<?php include("snips/menu-html.php"); ?>

	<div class="container" onclick="menu(this)">
		
		<div class="bar1"></div>

		<div class="bar2"></div>

		<div class="bar3"></div>

	</div>

	<div id="center_div">
		
		<div id="center_image_mobile"></div>

		<div id="slideshow">
			
			<div class="slides">
				
				<img src="http://laurcons.ddns.net/media/poze/poza1.png" id="center_image_main" />

			</div>

			<div class="slides">
				
				<img src="http://laurcons.ddns.net/media/poze/poza2.png" id="center_image_main" />
				
			</div>

			<div class="slides">
				
				<img src="http://laurcons.ddns.net/media/poze/poza3.png" id="center_image_main" />
				
			</div>

			<div class="slides">
				
				<img src="http://laurcons.ddns.net/media/poze/poza4.jpg" id="center_image_main" />
				
			</div>

			<div class="slides">
				
				<img src="http://laurcons.ddns.net/media/poze/poza5.jpg" id="center_image_main" />
				
			</div>

		</div>

		<br />

		<div id="slideshow_dots_container">
			
			<span class="slideshow_dots"></span>

			<span class="slideshow_dots"></span>

			<span class="slideshow_dots"></span>

			<span class="slideshow_dots"></span>

			<span class="slideshow_dots"></span>

		</div>

		<p id="center_image_paragraph">	

								"Am oscilat între Şcoala Ardeleană şi Şcoala Militară."


	A fost fiul protopopului român unit Gheorghe Maior, originar din Diciosânmartin (azi Târnăveni). Și-a efectuat studiile primare la Căpușu de Câmpie, unde se stabilise tatăl său, devenit protopop de Iclod (Mureș). După studii la Colegiul Reformat din Târgu Mureș (1769-1772) și la Blaj (1771-1774) a urmat studiul filosofiei și teologiei la Colegiul „De Propaganda Fide” din Roma (1774-1779), apoi a făcut studii de drept la Universitatea din Viena (1779-1780).
	Devine profesor de logică, metafizică și dreptul firii la gimnaziul din Blaj (între 1780 - 1785), preot în Reghin-sat și protopop al Gurghiului (între 1785 - 1809), „crăiesc revizor” (revizor crăiesc) și corector al cărților românești care se tipăreau la Buda (1809 - 1821).
	A fost un important militant pentru drepturile românilor din Transilvania, participând – alături de alți reprezentanți ai Școlii Ardelene - la redactarea celebrei declarații de emancipare a românilor transilvăneni, Supplex Libellus Valachorum.
	În lucrarea Procanon a exprimat unele poziții anticuriale, pe fondul conflictului său cu episcopul Ioan Bob. Aceste poziții au fost prezentate în mod diacronic în timpul perioadei comuniste ca fiind îndreptate împotriva dogmei primatului papal, deși această dogmă a fost adoptată de-abia în anul 1870.
	A publicat o serie de lucrări teologice, istorice, filologice, predici; a tradus și prelucrat lucrări cu caracter economic. În lucrările sale istorice a combătut opiniile lui Franz Josef Sulzer, Josef Karl Eder, Johann Christian von Engel și Jernej Kopitar, care contestau romanitatea și continuitatea românilor pe teritoriul fostei Dacii.
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

	var slideIndex = 0;
	showSlides();

	function showSlides() {

	  var i;
	  var slides = document.getElementsByClassName("slides");
	  var dots = document.getElementsByClassName("slideshow_dots");

	  for (i = 0; i < slides.length; i++) {

	    slides[i].style.display = "none";  

	  }

	  slideIndex++;

	  if (slideIndex > slides.length) {

	  	slideIndex = 1;

	  }  

	  for (i = 0; i < dots.length; i++) {

	    dots[i].className = dots[i].className.replace(" active", "");

	  }

	  slides[slideIndex - 1].style.display = "block"; 
	  dots[slideIndex - 1].className += " active";
	  setTimeout(showSlides, 6000);

	}

</script>

</html>