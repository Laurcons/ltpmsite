
<?php
	redirect_if_logged_in("/portal/panou");
?>

<!DOCTYPE html>

<html lang="en">

<head>

	<title>Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-include.php"); ?>
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

	<?php $header_cpage = "logare"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/navbar.php"); ?>

	<div class="container mb-5">

		<center style="max-width: 360px; width: 100%; margin: 0 auto;">

			<h3 class="my-5">Intrați în contul Portal</h3>

			<form id="login-form" action="" method="POST">

				<div class="form-group">

					<input type="text" class="form-control login-control-top" name="username" placeholder="Numele de utilizator"/>

					<input type="password" class="form-control login-control-bottom" name="parola" placeholder="Parola"/>

				</div>

				<div class="alert alert-danger py-1 px-2 d-none text-left" data-form="login-form" data-for="login">
				</div>

				<div class="btn-group">

					<a href="/portal" class="btn-default btn border-primary">Înapoi</a>
					<button type="submit" class="btn btn-primary" id="login-form-submit">
						Autentificare
					</button>

				</div>

			</form>

		</center>


	</div>

</body>

<script src="/portal/js"></script>
<script src="/portal/logare/js"></script>

</html>