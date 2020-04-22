<?php

redirect_if_logged_in("/portal/?p=panou");

?>

<!DOCTYPE html>

<html>

<head>

	<title>Inregistrare - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-include.php"); ?>

</head>

<body>

	<?php $header_cpage = "inreg"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/navbar.php"); ?>

	<div class="container">

		<div style="max-width: 480px; width: 100%; margin: 0 auto;">

			<h3 class="text-center mt-5">Creati-va un cont Portal</h3>
			<h3 class="text-center mb-5 small font-italic">Folositi codul de inregistrare primit</h3>

			<div class="collapse show" id="collapse-step1">

				<div class="form-group">

					<label class="font-weight-bold">Codul de inregistrare:</label>

					<input id="inregistrare-form-cod-inregistrare"
						   type="text"
						   class="form-control">

					<div class="alert alert-danger mt-1 py-1 px-3 d-none" data-form="inregistrare-form" data-for="cod">

					</div>

				</div>

				<button class="btn btn-primary float-right" id="submit-cod-inregistrare">Continua</button>

			</div>

			<div class="collapse" id="collapse-step2">

				<div class="form-group">

					<label class="font-weight-bold">Numele de utilizator: <small>(obligatoriu)</small></label>

					<input id="inregistrare-form-username"
						   type="text"
						   class="form-control"
						   form="inregistrare-form"
						   name="username"
						   placeholder="add-js">

					<div class="alert alert-danger mt-1 py-1 px-3 d-none" data-form="inregistrare-form" data-for="username">

					</div>

				</div>

				<div class="form-group">

					<label class="font-weight-bold mb-0">Numele complet:</label>
					<div class="text-small mb-2">Va rugam completati doar daca administratia v-a gresit numele. Daca diacriticele nu sunt puse corect, le puteti corecta.</div>

					<div class="input-group">

						<input id="inregistrare-form-nume"
							   type="text"
							   class="form-control"
							   form="inregistrare-form"
							   name="nume"
							   value="add-js">

						<input id="inregistrare-form-prenume"
							   type="text"
							   class="form-control"
							   form="inregistrare-form"
							   name="prenume"
							   value="add-js">

					</div>

				</div>

				<div class="form-group">

					<label class="font-weight-bold">E-mail:</label>
					<div class="text-small mb-2">Va rugam completati doar daca administratia v-a gresit emailul.</div>

					<input id="inregistrare-form-email"
						   type="text"
						   class="form-control"
						   form="inregistrare-form"
						   name="email"
						   value="add-js">

				</div>

				<div class="font-weight-bold">Alte detalii asociate contului:</div>

				<p>Contul este un cont de <span class="font-weight-bold" id="detalii-functie"></span> cu autoritate <span class="font-weight-bold" id="detalii-autoritate"></span> si care este inscris in clasa <span class="font-weight-bold" id="detalii-clasa"></span> ca fiind <span class="font-weight-bold" id="detalii-functie-clasa"></span>.</p>

				<p><em>Daca credeti ca aceste detalii sunt eronate, va rugam sa atentionati administratia.</em></p>

				<div class="form-group">

					<label class="font-weight-bold">Parola: <small>Alegeti o parola.</small></label>

					<input type="password"
						   id="inregistrare-form-password"
						   class="form-control"
						   form="inregistrare-form"
						   name="password"
						   placeholder="Parola">

					<input type="password"
						   id="inregistrare-form-confirm-password"
						   class="form-control"
						   placeholder="Confirma parola">

					<div class="alert alert-danger mt-1 px-3 py-1 d-none" data-form="inregistrare-form" data-for="passwords">

					</div>

				</div>

				<div class="btn-group mt-1 float-right">

					<button type="button" class="btn btn-default border-primary" id="prev-step2">Inapoi</button>

					<button type="submit"
							id="submit-inregistrare"
							class="btn btn-primary"
							form="inregistrare-form">
							Inregistrare
					</button>

				</div>

			</div>

		</div>

	</div>

	<form id="inregistrare-form">

		<input type="hidden" id="inregistrare-form-form-id" name="form-id" value="blah">
		<input type="hidden" id="inregistrare-form-user-id" name="user-id" value="bleh">
		<input type="hidden" name="inregistrare" value="hey">

	</form>

</body>

<script src="?p=inreg&js"></script>

</html>