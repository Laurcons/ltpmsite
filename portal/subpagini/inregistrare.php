<?php 

// dbinit si loginchecks sunt incluse din /portal/index.php

redirect_if_logged_in("/portal/?pagina=panou");
$db = new db_connection();

$errors = 0;
$username = $username_err = "";
$email = $email_err = "";
$password = $password_err = "";
$firstname = $lastname = $name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (!isset($_POST["username"])) {

		$username_err = "notset";
		$errors = 1;

	} else {
		if (empty($_POST["username"])) {

			$username_err = "notset";
			$errors = 1;

		}

		// success
		$username = $_POST["username"];

		// verifica daca nu e luat deja
		$available = $db->is_username_available($username);
		if (!$available) {

			$username_err = "taken";
			$errors = 1;

		}

	}

	if (!isset($_POST["password"]) || !isset($_POST["confirm-password"])) {

		$password_err = "notset";
		$errors = 1;

	} else {

		if (empty($_POST["password"]) || empty($_POST["confirm-password"])) {

			$password_err = "notset";
			$errors = 1;

		}

		if ($_POST["password"] != $_POST["confirm-password"]) {

			$password_err = "notmatch";
			$errors = 1;

		} else {
			// success

			$password = $_POST["password"];

		}

	}

	if (!isset($_POST["email"])) {

		$email_err = "notset";
		$errors = 1;
	} else if (empty($_POST["email"])) {
		$email_err = "notset";
		$errors = 1;
	} else {

		// success
		$email = $_POST["email"];
	}

	if (!isset($_POST["firstname"]) || !isset($_POST["lastname"])) {
		$name_err = "notset";
		$errors = 1;
	} else {
		if (empty($_POST["firstname"]) || empty($_POST["lastname"])) {
			$name_err = "notset";
			$errors = 1;
		} else {
			// success
			$firstname = $_POST["firstname"];
			$lastname = $_POST["lastname"];
		}

	}

	if ($errors == 0) {

		$password_hashed = password_hash($password, PASSWORD_DEFAULT);

		$user = array();
		$user["Username"] = $username;
		$user["Parola"] = $password_hashed;
		$user["Email"] = $email;
		$user["Autoritate"] = "normal";
		$user["Functie"] = "neatribuit";
		$user["NrMatricol"] = null;
		$user["Nume"] = $firstname;
		$user["Prenume"] = $lastname;

		$db->insert_utilizator($user);

		header("location: /portal/?pagina=logare&src=inreg");

	}

}

?>

<!DOCTYPE html>

<html>

<head>

	<title>Inregistrare - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>

</head>

<body style="background-color: #f5f5f5">

	<?php $header_cpage = "inreg"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

	<div class="container mb-5">

		<?php if ($errors != 0) : ?>

			<?php if (!empty($username_err)) : ?>

				<div class="alert alert-danger">

					<strong>Atentie! </strong>

					<?php 

						if ($username_err == "notset") echo "Numele de utilizator nu poate fi gol!";
						else if ($username_err == "taken") echo "Numele de utilizator nu este disponibil!";

					?>

				</div>

			<?php endif ?>
			<?php if (!empty($password_err)) : ?>

				<div class="alert alert-danger">

					<strong>Atentie! </strong>

					<?php 

						if ($password_err == "notset") echo "Parolele nu pot fi goale!";
						else if ($password_err == "notmatch") echo "Parolele nu coincid!";

					?>

				</div>

			<?php endif ?>
			<?php if (!empty($email_err)) : ?>

				<div class="alert alert-danger">

					<strong>Atentie! </strong>

					<?php 

						if ($email_err == "notset") echo "Emailul nu poate fi gol!";

					?>

				</div>

			<?php endif ?>
			<?php if (!empty($name_err)) : ?>

				<div class="alert alert-danger">

					<strong>Atentie! </strong>

					<?php 

						if ($name_err == "notset") echo "Va rugam completati-va numele si prenumele!";

					?>

				</div>

			<?php endif ?>

		<?php endif ?>

		<div class="text-center" style="max-width: 480px; width: 100%; margin: 0 auto;">

			<h3 class="mt-5">Creati-va un cont Portal</h3>
			<h3 class="mb-5 small font-italic">Contul va trebui aprobat de catre conducere</h5>

			<form action="" method="post">

				<div class="form-group">

					<label for="email" class="float-left font-weight-bold">Adresa de e-mail:</label>

					<input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>" />

				</div>

				<div class="form-group">

					<label for="username" class="float-left font-weight-bold">Nume de utilizator:</label>

					<input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>" />

				</div>

				<div class="form-group">

					<label for="name" class="float-left font-weight-bold">Nume si prenume:</label>

					<input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $firstname; ?>" placeholder="Numele de familie" />
					<input type="text" class="form-control" name="lastname" id="lastname"   value="<?php echo $lastname;  ?>" placeholder="Prenumele" />

				</div>

				<div class="form-group">

					<label for="password" class="float-left font-weight-bold">Parola: <small class="font-italic">Creati o parola puternica</small></label>

					<input type="password" class="form-control" name="password" id="password" />

				</div>

				<div class="form-group">

					<label for="password" class="float-left font-weight-bold">Confirma parola:</label>

					<input type="password" class="form-control" name="confirm-password" id="confirm-password" />

				</div>

				<div class="btn-group">

					<a href="/portal" class="btn btn-default border-primary">Inapoi</a>
					<input type="submit" class="btn btn-primary" value="Inregistrare" />

				</div>

			</form>

		</center>

	</div>

</body>

</html>