<?php

require $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";
use phpseclib\Net\SFTP;

$response = new stdClass();
$db = new db_connection();

// prelucreaza POST-uri
// POST-URI CU INDEMPOTENTA
if (isset($_POST["form-id"])) {

	if (!isset($_SESSION["form-id"]) ||
		(isset($_SESSION["form-id"]) && $_POST["form-id"] != $_SESSION["form-id"])) {
	
        $_SESSION["form-id"] = $_POST["form-id"];

        if (isset($_POST["resursa"])) {

            // sanitize the input cause i want no XSS thank-you
            $continut = security\xss_clean($_POST["continut"]);

            $resursa_id = $db->retrieve_resursa_nou("Id", $_SESSION["logatid"], $_SESSION["logatca"])["Id"];
            $db->update_resursa_where_id($resursa_id, array(
                "Titlu" => $_POST["titlu"],
                "ContinutHtml" => $continut,
                "IdProfesor" => $_SESSION["logatid"],
                "Nivel" => $_POST["nivel"],
                "Meta" => "{}",
                "Adaugat" => date("Y-m-d H:i:s")
            ));

            // add the files
            // upload the files to the SFTP server and create the database entries
            $response->files = $_FILES;
            $file_num = count($_FILES["file"]["name"]);

            if ($file_num > 0) {
                $conf = require($_SERVER["DOCUMENT_ROOT"] . "/portal/include/dbconfig.php");
                $sftp = new SFTP($conf["sftp-host"]);
                $sftp->login($conf["sftp-user"], $conf["sftp-pass"]);
                $sftp->mkdir("/writable/resurse/" . $resursa_id, 0775);
            }

            for ($i = 0; $i < $file_num; $i++) {

                // upload to SFTP
                $sftp->put(
                    "/writable/resurse/" . $resursa_id . "/" . $_FILES["file"]["name"][$i],
                    $_FILES["file"]["tmp_name"][$i],
                    SFTP::SOURCE_LOCAL_FILE
                );
                // add to db
                $db->insert_resursa_file([
                    "ResursaId" => $resursa_id,
                    "Filepath" => "https://laurcons.ddns.net:444/media/resurse/" . $resursa_id . "/" . $_FILES["file"]["name"][$i]
                ]);

            }

        }
        
    } else {

		$response->status = "form-id-failed";

	}

} else {

	$response->status = "form-id-not-found";

}

echo(json_encode($response));