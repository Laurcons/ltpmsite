<?php

include("clase.phphead.php");

// prelucreaza POST-uri
// POST-URI CU INDEMPOTENTA
if (isset($_POST["form-id"])) {

	if (!isset($_SESSION["form-id"]) ||
		(isset($_SESSION["form-id"]) && $_POST["form-id"] != $_SESSION["form-id"])) {
	
		$_SESSION["form-id"] = $_POST["form-id"];

		if (isset($_POST["noteaza"])) {

			$nota_data = array();
			$nota_data["IdElev"] = $_POST["user-id"];
			$nota_data["Nota"] = $_POST["nota"];
			$nota_data["IdMaterie"] = $predare["IdMaterie"];
			$nota_data["IdClasa"] = $predare["IdClasa"];
			$nota_data["Semestru"] = "1";
			$nota_data["Ziua"] = $_POST["ziua"];
			$nota_data["Luna"] = $_POST["luna"];

			var_dump($nota_data);

			try {

				$db->insert_nota($nota_data);

			} catch (Exception $e) {

				header($_SERVER["SERVER_PROTOCOL"] . " 409 Conflict");
 
			}

		}

		if (isset($_POST["anuleaza-nota"])) {

			if ($_POST["nota-id"] != "insert_js_here") {

				try {

					$db->delete_nota_where_id($_POST["nota-id"]);

				} catch (Exception $e) {

					header($_SERVER["SERVER_PROTOCOL"] . " 409 Conflict");

				}

			}

		}

		if (isset($_POST["absent-azi"])) {

			$azi = new DateTime();
			$ab = array();
			$ab["IdElev"] = $_POST["user-id"];
			$ab["IdMaterie"] = $predare["IdMaterie"];
			$ab["IdClasa"] = $predare["IdClasa"];
			$ab["Ziua"] = $azi->format("j");
			$ab["Luna"] = $azi->format("n");
			$ab["Semestru"] = "1";

			try {
			
				$db->insert_absenta($ab);

			} catch (Exception $e) {

				header($_SERVER["SERVER_PROTOCOL"] . " 409 Conflict");

			}

		}

		if (isset($_POST["anuleaza-absenta"])) {

			$ab = $_POST["absenta-id"];

			var_dump($_POST);

			try {

				$db->delete_absenta($ab);

			} catch (Exception $e) {

				header($_SERVER["SERVER_PROTOCOL"] . " 409 Conflict");

			}

		}

		if (isset($_POST["motiveaza-absenta"])) {

			// vezi starea motivarii si pune invers fata de cum e
			$absenta_id = $_POST["absenta-id"];
			$absenta = $db->retrieve_absenta_where_id("Motivata", $absenta_id);
			$motiv = $absenta["Motivata"];

			if ($motiv == 1)
				$motiv = 0;
			else $motiv = 1;

			try {

				$db->update_absenta_motivare($absenta_id, $motiv);

			} catch (Exception $e) {

				header($_SERVER["SERVER_PROTOCOL"] . " 409 Conflict");

			}

		}

		if (isset($_POST["adauga-absenta"])) {

			$ab = array();
			$ab["IdElev"] = $_POST["elev-id"];
			$ab["IdMaterie"] = $predare["IdMaterie"];
			$ab["IdClasa"] = $predare["IdClasa"];
			$ab["Ziua"] = $_POST["ziua"];
			$ab["Luna"] = $_POST["luna"];
			$ab["Semestru"] = "1";

			try {
			
				$db->insert_absenta($ab);

			} catch (Exception $e) {

				header($_SERVER["SERVER_PROTOCOL"] . " 409 Conflict");

			}

		}

	} 

}

?>