<?php

$db = new db_connection();

$current_id = -1;

if (isset($_GET["id"])) {
	$current_id = $_GET["id"];
}

?>

<!DOCTYPE html>
<html>

<head>

	<title>Administrare clase - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>

</head>

<body>
	<?php $header_cpage = "admin:clase"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

<div class="container">

	<?php if ($current_id == -1) : ?>

		<?php
			$profesori_disponibili = $db->retrieve_profesori_where_not_diriginte("Id,Nume,Prenume");

		?>

		<h3 class="mb-3">Toate clasele liceului</h3>

		<a class="btn btn-default border-primary mb-3" href="#" data-toggle="modal" data-target="#creeaza-clasa-modal">Adauga clasa</a>

		<?php 
			$i = 0;
			$clase = $db->retrieve_clase("*");
		?>

		<div id="clase-list">
			<!-- filled with javascript & ajax -->
		</div>

		<div class="modal fade" id="creeaza-clasa-modal">

			<div class="modal-dialog">

				<div class="modal-content" id="creeaza-clasa-modal-content">

					<!-- added with javascript and ajax -->

				</div>

			</div>

		</div>

		<div class="modal fade" id="sterge-clasa-modal">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header bg-danger">

						<div class="modal-title text-white h4">
							Sterge clasa
						</div>

						<button class="close text-white" data-dismiss="modal">
							&times;
						</button>

					</div> <!-- modal-header -->

					<div class="modal-body">

						<p>Sunteti sigur ca doriti sa stergeti clasa? Aceasta actiune nu poate fi anulata!</p>

					</div>

					<div class="modal-footer">

						<div class="btn-group">

							<button class="btn btn-default bg-white border-danger" data-dismiss="modal">Inapoi</button>

							<input type="submit"
								   form="sterge-clasa-form"
								   class="btn btn-danger"
								   value="Sterge clasa">

						</div>

					</div>

				</div>

			</div>

		</div>

		<form id="creeaza-clasa-form" method="POST" action="?p=admin:clase&post">

			<input type="hidden" id="creeaza-clasa-form-form-id" name="form-id" value="fillwithjs please">
			<input type="hidden" name="creeaza-clasa" value="whatever">

		</form>

		<form id="sterge-clasa-form" method="POST" action="?p=admin:clase&post">

			<input type="hidden" id="sterge-clasa-form-form-id" name="form-id" value="fillwithjs please">
			<input type="hidden" id="sterge-clasa-form-clasa-id" name="clasa-id" value="fillwithjs please">
			<input type="hidden" name="sterge-clasa" value="ANAETHING">

		</form>
	
	<?php else : // current_id == -1 ?>

		<?php
			$clasa = $db->retrieve_clasa_where_id("*", $current_id);
			$diriginte = $db->retrieve_utilizator_where_id("*", $clasa["IdDiriginte"]);
		?>

		<div class="row">

			<div class="col-sm-4">

				<a class="btn btn-default border-primary" href="?p=admin:clase">Inapoi la clase</a>

			</div>

			<div class="col-sm-4 text-center">

				<div class="h3">
					Clasa <?= $clasa["Nivel"] . " " . $clasa["Sufix"] ?>
				</div>

			</div>

		</div>

		<p class="mb-3">

			<div class="font-weight-bold d-inline">Dirigintele clasei: </div>

			<?= $diriginte["Nume"] . " " . $diriginte["Prenume"] ?>

			<a class="btn btn-sm bg-white border d-inline">Schimba</a>

		</p>

		<div class="h4">Elevii clasei</div>

		<div class="d-none d-md-block"> <!-- header row -->

			<div class="row border p-2">

				<div class="col-md-4">
					
					<span class="font-weight-bold">Numele elevului</span>

				</div>

				<div class="col-md-6">

					<span class="font-weight-bold">Detalii si optiuni</span>	

				</div>

			</div>

		</div> <!-- header row -->

		<div id="elevi-div">

			<!-- filled with js -->

		</div>

		<div class="row border border-top-0 p-2 mb-3">

			<div class="col-md-12">

				<button class="btn btn-sm border-primary">Adauga elev</button>

			</div>

		</div>

		<div class="h4">Predarile clasei</div>

		<div class="d-none d-md-block"> <!-- header row -->

			<div class="row border p-2">

				<div class="col-md-1">
					
					<span class="font-weight-bold">Numar</span>

				</div>

				<div class="col-md-3">

					<span class="font-weight-bold">Materia predata</span>	

				</div>

				<div class="col-md-3">

					<span class="font-weight-bold">Profesorul care preda</span>	

				</div>

				<div class="col-md-5">

					<span class="font-weight-bold">Optiuni</span>	

				</div>

			</div>

		</div> <!-- header row -->

		<div id="predari-div">

			<!-- filled with js -->

		</div>

		<div class="row border border-top-0 p-2">

			<div class="col-md-12">

				<button class="btn btn-sm border-primary">Adauga predare</button>

			</div>

		</div>

	<?php endif; // current_id == -1 ?>

</div>

</body>
<footer>
	<?php if ($current_id == -1) : ?>

	<script src="?p=admin:clase&js=list"></script>
	<templates>

		<template id="clasa-template">

			<div class="col-md-4 mb-2">

					<div class="card" style="/*box-shadow: 5px 5px 5px #aaa;*/"> 

						<div class="card-header">

							<div class="card-title h4">

								Clasa {{Nivel}} {{Sufix}}

								<button type="button" class="close" id="sterge-clasa-button-{{Id}}">
									&times;
								</button>

							</div>

						</div>

						<ul class="list-group list-group-flush">

							<li class="list-group-item"><b>Diriginte:</b> {{diriginte.Nume}} {{diriginte.Prenume}}</li>

							<li class="list-group-item"><b>Numar elevi:</b> {{nrelevi}}</li>

						</ul>

						<div class="card-body">

							<a class="btn btn-primary w-100" href="?p=admin:clase&id={{Id}}">Administreaza</a>

						</div>

					</div>

				</div>

		</template>

		<template id="creeaza-clasa-modal-allowed-template">

			<div class="modal-header">

				<div class="modal-title h4">
					Adaugare clasa
				</div>

			</div> <!-- modal-header -->

			<div class="modal-body">

				<p>Pentru inceput, vom avea nevoie de putine detalii despre clasa.</p>

				<div class="form-group">

					<label>Denumirea clasei:</label>

					<div class="input-group">

						<input id="creeaza-clasa-form-nivel"
						       form="creeaza-clasa-form"
						       name="nivel"
						       class="form-control"
						       type="text"
						       placeholder="Nivelul (ex. 0, 1, 10, 12, etc.)">

						<input id="creeaza-clasa-form-sufix"
						       form="creeaza-clasa-form"
						       name="sufix"
						       class="form-control"
						       type="text"
						       placeholder="Sufixul (ex. A, B, C, etc.)">

					</div>

				</div>

				<div class="form-group">

					<label>Anul scolar:</label>

					<div class="input-group">

						<input id="creeaza-clasa-form-an"
							   form="creeaza-clasa-form"
							   name="an"
							   class="form-control"
							   type="number"
							   min="<?= date('Y') - 10 ?>"
							   max="<?= date('Y') + 10 ?>"
							   placeholder="Anul de inceput">

						<div class="input-group-append">

							<div class="input-group-text" id="creeaza-clasa-modal-an-extra">

								An invalid

							</div>

						</div>

					</div>

				</div>

				<div class="form-group">

					<label>Profesorul diriginte:</label>

					<select id="creeaza-clasa-form-idprofesor"
							form="creeaza-clasa-form"
							name="iddiriginte"
							class="form-control">

						<?php while ($prof = $profesori_disponibili->fetch_assoc()) : ?>

							<option value="<?= $prof['Id'] ?>"><?= $prof["Nume"] . " " . $prof["Prenume"] ?></option>

						<?php endwhile; ?>

					</select>

				</div>

			</div> <!-- modal-body -->

			<div class="modal-footer">

				<div class="btn-group">

					<button class="btn btn-default bg-white border-primary" data-dismiss="modal">Inapoi</button>

					<input type="submit"
						   form="creeaza-clasa-form"
						   class="btn btn-primary"
						   value="Adauga clasa">

				</div>

			</div>

		<template id="creeaza-clasa-modal-disallowed-template">

			<div class="modal-body">

				<p>Nu puteti crea clase noi, deoarece nu aveti profesori disponibili care sa le fie diriginti!</p>

				<p>Va rugam sa creati conturi noi pentru profesori, si incercati din nou.</p>

			</div>

			<div class="modal-footer">

				<button class="btn btn-default bg-white border-primary" data-dismiss="modal">Inapoi</button>

			</div>

		</template>

	</templates>

	<?php else : ?>

		<script src="?p=admin:clase&js=one"></script>
		<templates>

			<template id="elev-template">

				<div class="row border{{^first}} border-top-0{{/first}} p-2">

					<div class="col-md-4">

						<div class="d-md-none font-weight-bold">
							Elevul:
						</div>

						<span class="badge badge-primary mr-1">{{nrcrt}}</span>

						{{Nume}} {{Prenume}}

					</div>

					<div class="col-md-6">

						<div class="d-md-none font-weight-bold">
							Optiuni:
						</div>

						<button class="btn btn-sm border-danger">Sterge din clasa</button>

					</div>

				</div>

			</template>

			<template id="predare-template">

				<div class="row border p-2 {{^first}}border-top-0{{/first}}">

					<div class="col-md-1">

						<span class="badge badge-primary">
							{{nrcrt}}
						</span>

					</div>

					<div class="col-md-3">

						{{materie.Nume}}

					</div>

					<div class="col-md-3">
						{{profesor.Nume}} {{profesor.Prenume}}
					</div>

					<div class="col-md-5">

						<button class="btn btn-sm border-danger">Sterge predare</button>

					</div>

				</div>

			</template>

		</templates>

	<?php endif; ?>
</footer>

</html>