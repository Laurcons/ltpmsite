<?php

$db = new db_connection();

$username = $username_err = "";
$parola = $parola_err = "";

$redir = "/portal/?p=panou";
if (isset($_GET["redir"])) {
	$redir = $_GET["redir"];
}

/* toata validarea necesita un POST request
 * todo: muta o parte din validare pe javascript
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// validare
	if (isset($_POST["username"])) {

		$username = trim($_POST["username"]);

		if (empty($username))
			$username_err = "notset";
	}
	if (isset($_POST["parola"])) {

		$parola = trim($_POST["parola"]);

	}

	if (empty($username_err)) {

		// cauta usernameul in baza de date
		/*$stmt = $conn->prepare("SELECT Parola,Autoritate FROM utilizatori WHERE Username = ?");
		if ($stmt == false) {
			var_dump($conn->error_list);
		}
		$stmt->bind_param('s', $username);

		$stmt->execute();
		$result = $stmt->get_result();*/
		$user = $db->retrieve_utilizator_where_username('Parola,Autoritate,Functie', $username);

		if ($user == null) {

			$username_err = "notfound";

		} else {

			$success = false;

			if (false/*$username == "root"*/) {
				// pass is in text
				if ($parola == $user["Parola"]) 
					$success = true;

			} else {

				if (password_verify($parola, $user["Parola"]))
					$success = true;
			}

			if ($success) {
				$_SESSION["logatca"] = $username;
				$_SESSION["logat"] = true;
				$_SESSION["autoritate"] = $user["Autoritate"];
				$_SESSION["functie"] = $user["Functie"];

				/*
				// get last login time
				$logintime_result = $conn->query("SELECT UltimaLogare FROM utilizatori WHERE Username = '" . $_SESSION["logatca"] . "';");
				$logintime_row = $logintime_result->fetch_assoc();
				$last_login_time = $logintime_row["UltimaLogare"];

				$_SESSION["ultimalogare"] = $last_login_time;
				// push to the database the last login time
				$stmt = $conn->prepare("UPDATE utilizatori SET UltimaLogare = current_timestamp() WHERE Username=?;");
				$stmt->bind_param("s", $username);
				$stmt->execute();*/
				$_SESSION["ultimalogare"] = $db->retrieve_utilizator_ultima_logare($username);
				$db->update_utilizator_ultima_logare($username);

				header("location: $redir");

			} else {
				$password_err = "incorrect";
			}

		}

		//$stmt->close();

	}
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

	<title>Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>
 	<style>
 		/* imbina cele doua controale de la login */
 		.login-control-top {
 			margin-bottom: -1px;
 			border-bottom-left-radius: 0;
 			border-bottom-right-radius: 0;
 		}
 		.login-control-bottom {

 			border-top-left-radius: 0; 
 			border-top-right-radius: 0;
 		}

 	</style>

</head>

<body style="background-color: #f5f5f5">

	<?php $header_cpage = "logare"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

	<div class="container mb-5">

		<?php
			if (!empty($username_err)) {
				echo '<div class="alert alert-danger alert-lg"><strong>Atentie! </strong>';
				if ($username_err == "notset")
					echo "Nu ati pus niciun nume de utilizator!";
				if ($username_err == "notfound")
					echo "Numele de utilizator nu a fost gasit!";
				echo "</div>";
			}

			if (!empty($password_err)) {
				echo '<div class="alert alert-danger alert-lg"><strong>Atentie! </strong>';
				if ($password_err == "incorrect")
					echo "Parola nu se potriveste!";
				echo "</div>";
			}

			if (isset($_GET["src"]) && $_GET["src"] == "inreg") {


				echo '<div class="alert alert-info alert-lg">';

				echo "Inregistrarea a avut loc cu succes! Acum e nevoie sa intri in cont.";

				echo "</div>";

			}
		?>

		<center style="max-width: 360px; width: 100%; margin: 0 auto;">

			<h3 class="my-5">Intrati in contul Portal</h3>

			<form action="" method="POST">

				<div class="form-group">

					<input type="text" class="form-control login-control-top" name="username" value="<?php echo $username; ?>" placeholder="Numele de utilizator"/>

					<input type="password" class="form-control login-control-bottom" name="parola" placeholder="Parola"/>
				</div>

				<p>Ati uitat parola? Pacat. Nu va putem ajuta.</p>

				<div class="btn-group">

					<a href="/portal" class="btn-default btn border-primary">Inapoi</a>
					<input type="submit" class="btn btn-primary" value="Autentificare">

				</div>

			</form>

		</center>


	</div>

</body>

</html>