<?php

include("clase.phphead.php");

$response = new stdClass();

// prelucreaza POST-uri
// POST-URI CU INDEMPOTENTA
if (isset($_POST["form-id"])) {

	if (!isset($_SESSION["form-id"]) ||
		(isset($_SESSION["form-id"]) && $_POST["form-id"] != $_SESSION["form-id"])) {
	
		$_SESSION["form-id"] = $_POST["form-id"];

		if (isset($_POST["noteaza"])) {

			$predare = $db->retrieve_predare_where_id("*", $_POST["predare-id"]);

			$nota_data = array();
			$nota_data["IdElev"] = $_POST["elev-id"];
			$nota_data["Nota"] = $_POST["nota"];
			$nota_data["IdMaterie"] = $predare["IdMaterie"];
			$nota_data["IdClasa"] = $predare["IdClasa"];
			$nota_data["IdProfesor"] = $_SESSION["logatid"];
			$nota_data["Semestru"] = $_POST["semestru"];
			$nota_data["Ziua"] = $_POST["ziua"];
			$nota_data["Luna"] = $_POST["luna"];

			if ($_POST["tip"] == "teza")
				$nota_data["Teza"] = 'da';
			else $nota_data["Teza"] = NULL;
			$nota_data["Tip"] = $_POST["tip"];

			try {

				$db->insert_nota($nota_data);

				$response->status = "success";

			} catch (Exception $e) {

				$response->status = "exception";
				$response->exception = $e->getMessage();
 
			}

		} else if (isset($_POST["anuleaza-nota"])) {

			$user = $db->retrieve_utilizator_where_username("Id,Parola", $_SESSION["logatca"]);

			if (password_verify($_POST["password"], $user["Parola"])) {

				try {

					$db->delete_nota_where_id($_POST["nota-id"]);

					$response->status = "success";

				} catch (Exception $e) {

					$response->status = "exception";
					$response->exception = $e->getMessage();

				}

			} else {

				$response->status = "password-failed";

			}

		} else if (isset($_POST["absent-azi"])) {

			// UNUSED CURRENTLY

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

				$response->status = "exception";
				$response->exception = $e->getMessage();

			}

			// ENDOF UNUSED CURRENTLY

		} else if (isset($_POST["anuleaza-absenta"])) {

			$ab = $_POST["absenta-id"];

			try {

				$db->delete_absenta($ab);

				$response->status = "success";

			} catch (Exception $e) {

				$response->status = "exception";
				$response->exception = $e->getMessage();

			}

		} else if (isset($_POST["motiveaza-absenta"])) {

			// vezi starea motivarii si pune invers fata de cum e
			$absenta_id = $_POST["absenta-id"];
			$absenta = $db->retrieve_absenta_where_id("Motivata", $absenta_id);
			$motiv = $absenta["Motivata"];

			if ($motiv == 1)
				$motiv = 0;
			else $motiv = 1;

			try {

				$db->update_absenta_motivare($absenta_id, $motiv);

				$response->status = "success";

			} catch (Exception $e) {

				$response->status = "exception";
				$response->exception = $e->getMessage();

			}

		} else if (isset($_POST["adauga-absenta"])) {

			$predare = $db->retrieve_predare_where_id("*", $_POST["predare-id"]);

			$ab = array();
			$ab["IdElev"] = $_POST["elev-id"];
			$ab["IdMaterie"] = $predare["IdMaterie"];
			$ab["IdClasa"] = $predare["IdClasa"];
			$ab["IdProfesor"] = $_SESSION["logatid"];
			$ab["Ziua"] = $_POST["ziua"];
			$ab["Luna"] = $_POST["luna"];
			$ab["Semestru"] = $_POST["semestru"];

			try {
			
				$db->insert_absenta($ab);

				$response->status = "success";

			} catch (Exception $e) {

				$response->status = "exception";
				$response->exception = $e->getMessage();

			}

		} else if (isset($_POST["preferinte-teza"])) {

			$teze = array();

			$teze_post = array_map(function($key, $value) {
				return array(
					"id" => $key,
					"teza" => $value
				);
			}, array_keys($_POST["elev"]), $_POST["elev"]);

			foreach ($teze_post as $teza) {

				$teze[] = array(
					"IdElev" => $teza["id"],
					"IdPredare" => $_POST["predare-id"],
					"Teza" => $teza["teza"]
				);

			}

			$db->update_teze($teze);

			$response->teze = $teze_post;
			$response->status = "success";

		} else {

			$response->status = "action-not-found";

		}

	} else {

		$response->status = "form-id-failed";

	}

} else {

	$response->status = "form-id-not-found";

}

echo(json_encode($response));

?>