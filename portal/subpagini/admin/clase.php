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

		<h1 class="mb-3">Toate clasele liceului</h1>

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

				<div class="h1">
					Clasa <?= $clasa["Nivel"] . "-" . $clasa["Sufix"] ?>
				</div>

			</div>

		</div>

		<p class="text-center mb-3">

			<span class="font-weight-bold">Diriginte: </span>

			<?= $diriginte["Nume"] . " " . $diriginte["Prenume"] ?>

			<a href="?p=admin:utilizatori&id=<?= $diriginte['Id'] ?>" class="btn btn-sm bg-white border-info">Detalii</a>

			<button class="btn btn-sm bg-white border-warning"
					onclick="alert('Neimplementat. Asta se face direct din baza de date momentan.');">
				Schimba
			</button>

		</p>

		<div class="d-block d-md-none h4 text-right">Elevii clasei</div>
		<div class="d-none d-md-block h4">Elevii clasei</div>

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

				<button class="btn btn-sm border-primary" data-toggle="modal" data-target="#atribuie-utilizator-modal">Atribuie elev</button>

			</div>

		</div>

		<div class="d-block d-md-none h4 text-right">Predarile clasei</div>
		<div class="d-none d-md-block h4">Predarile clasei</div>

		<div class="d-none d-md-block"> <!-- header row -->

			<div class="row border p-2">

				<div class="col-md-4">

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

				<button class="btn btn-sm border-primary"
						data-toggle="modal"
						data-target="#adauga-predare-modal">
					Adauga predare
				</button>

			</div>

		</div>

	<?php endif; // current_id == -1 ?>

</div>

<?php if ($current_id == -1) : ?>

<?php else : ?>

	<div class="modal fade" id="atribuie-utilizator-modal">
	
		<div class="modal-dialog">
	
			<div class="modal-content">
	
				<div class="modal-header">
	
					<h4 class="modal-title">
						Atribuie elev
					</h4>
	
				</div>
	
				<div class="modal-body">

					<div class="alert alert-info">

						Din acest panou puteti selecta un utilizator si sa il atribuiti clasei.<br>
						Daca utilizatorul pe care doriti sa il atribuiti nu exista si doriti sa il creati, va rugam sa accesati pagina de <a href="?p=admin:utilizatori" class="alert-link">administrare a utilizatorilor</a> si sa creati si sa atribuiti un nou utilizator de acolo.

					</div>

					<div class="alert alert-info">

						In lista de mai jos apar doar utilizatorii care nu sunt atribuiti deja unor clase. Pentru a-i putea atribui aici, trebuie mai intai sa ii stergeti din clasele din care fac parte. Notele si absentele nu vor fi transferate.

					</div>

					<div class="form-group">

						<label class="font-weight-bold">Alegeti utilizatorul:</label>

						<select class="form-control"
								name="user-id"
								form="atribuie-utilizator-form">

						</select>

					</div>

					<div class="alert alert-danger d-none" id="atribuie-utilizator-modal-unavailable">

						Nu exista utilizatori disponibili! Va rugam sa creati utilizatori noi din pagina de administrare a utilizatorilor!

					</div>
	
				</div>
	
				<div class="modal-footer">

					<span class="spinner-border spinner-border-sm text-primary d-none" id="atribuie-utilizator-modal-spinner"></span>
	
					<div class="btn-group">
	
						<button type="button" class="btn btn-default border-primary" data-dismiss="modal">Inapoi</button>
	
						<button type="submit"
								form="atribuie-utilizator-form"
								class="btn btn-primary">
							Atribuie elev
						</button>
	
					</div>
	
				</div>
	
			</div>
	
		</div>
	
	</div>

	<div class="modal fade" id="deatribuie-utilizator-modal">
	
		<div class="modal-dialog">
	
			<div class="modal-content">
	
				<div class="modal-header bg-danger">
	
					<h4 class="modal-title text-white">
						Sterge din clasa
					</h4>
	
				</div>
	
				<div class="modal-body">
	
					<p>Sunteti sigur ca doriti sa stergeti elevul din clasa?</p>

					<p>Retineti ca aceasta actiune nu are ca efect stergerea completa a utilizatorului, ci doar <strong>deatribuirea</strong> lui din cadrul clasei. Il puteti re-atribui oricand in cursul anului scolar curent, si isi va pastra toate notele si absentele.</p>
	
				</div>
	
				<div class="modal-footer">
	
					<div class="btn-group">
	
						<button type="button" class="btn btn-default border-danger" data-dismiss="modal">Inapoi</button>
	
						<button type="submit"
								form="deatribuie-utilizator-form"
								class="btn btn-danger">
							Sterge din clasa
						</button>
	
					</div>
	
				</div>
	
			</div>
	
		</div>
	
	</div>

	<div class="modal fade" id="adauga-predare-modal">
	
		<div class="modal-dialog">
	
			<div class="modal-content">
	
				<div class="modal-header">
	
					<h4 class="modal-title">
						Adauga predare
					</h4>
	
				</div>
	
				<div class="modal-body">
		
					<p>Selecteaza materia predata, si profesorul care o preda.</p>

					<div class="form-group">

						<label class="font-weight-bold">Materia predata:</label>

						<select class="form-control"
								form="adauga-predare-form"
								name="materie">

						</select>

					</div>

					<div class="form-group">

						<label class="font-weight-bold">Profesorul care o preda:</label>

						<select class="form-control"
								form="adauga-predare-form"
								name="profesor">

						</select>

					</div>
	
				</div>
	
				<div class="modal-footer">

					<span class="spinner-border text-primary d-none" id="adauga-predare-modal-spinner"></span>
	
					<div class="btn-group">
	
						<button type="button" class="btn btn-default border-primary" data-dismiss="modal">Inapoi</button>
	
						<button type="submit"
								form="adauga-predare-form"
								class="btn btn-primary">
							Adauga predare
						</button>
	
					</div>
	
				</div>
	
			</div>
	
		</div>
	
	</div>

	<div class="modal fade" id="sterge-predare-modal">
	
		<div class="modal-dialog">
	
			<div class="modal-content">
	
				<div class="modal-header bg-danger">
	
					<h4 class="modal-title text-white">
						Sterge predare
					</h4>
	
				</div>
	
				<div class="modal-body">
	
					Sunteti sigur ca doriti sa stergeti aceasta predare? Nimic altceva, in afara de predare, nu va fi afectat!
	
				</div>
	
				<div class="modal-footer">
	
					<div class="btn-group">
	
						<button type="button" class="btn btn-default border-danger" data-dismiss="modal">Inapoi</button>
	
						<button type="submit"
								form="sterge-predare-form"
								class="btn btn-danger">
							Sterge predare
						</button>
	
					</div>
	
				</div>
	
			</div>
	
		</div>
	
	</div>

	<form id="atribuie-utilizator-form">

		<input type="hidden" name="form-id">
		<input type="hidden" name="atribuie-utilizator">
		<input type="hidden" name="clasa-id" value="<?= $current_id ?>">

	</form>

	<form id="deatribuie-utilizator-form">

		<input type="hidden" name="form-id">
		<input type="hidden" name="deatribuie-utilizator">
		<input type="hidden" name="user-id">

	</form>

	<form id="adauga-predare-form">

		<input type="hidden" name="form-id">
		<input type="hidden" name="clasa-id" value="<?= $current_id ?>">
		<input type="hidden" name="adauga-predare">

	</form>

	<form id="sterge-predare-form">

		<input type="hidden" name="form-id">
		<input type="hidden" name="predare-id">
		<input type="hidden" name="sterge-predare">

	</form>

<?php endif; // current_id == -1 ?>

</body>
<footer>
	<?php if ($current_id == -1) : ?>

		<script src="?p=admin:clase&js=list"></script>

	<?php else : // current_id == -1 ?>

		<script src="?p=admin:clase&js=one"></script>

	<?php endif; ?>

	<?php include("clase.templ.php"); ?>

</footer>

</html>