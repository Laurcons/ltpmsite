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
		
		<h1 id="title">Noutati</h1>

	</div>

	<?php include("snips/menu-html.php"); ?>

	<div class="container" onclick="menu(this)">
		
		<div class="bar1"></div>

		<div class="bar2"></div>

		<div class="bar3"></div>

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