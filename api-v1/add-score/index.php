<?php 

session_start();

require_once($_SERVER["DOCUMENT_ROOT"] . "/portal/include/dbinit.php");

$db = new db_connection();
$conn = $db->get_conn(); // i'm not adding the whole functions

$json_response = new stdClass(); // prevent warning
$json_response->status = 0;

if (isset($_POST["s"])) {
	$post_score = $_POST["s"];

	// check if user is logged in
	if (isset($_SESSION["logat"]) && $_SESSION["logat"] == true) {

		// obtine userid
		$user_id = 0;
		{

			$stmt = $conn->prepare("SELECT Id FROM utilizatori WHERE Username=?;");
			$stmt->bind_param("s", $_SESSION["logatca"]);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$user_id = $row["Id"];
		}
		// adauga scor
		{
			$stmt = $conn->prepare("INSERT INTO game1_scores (UserId, Score) VALUES (?, ?);");
			$stmt->bind_param("is", $user_id, $post_score);
			$stmt->execute();
		}
		$json_response->status = 0;
		$json_response->type = "none";

	} else {

		$json_response->status = 2;
		$json_response->type = "text";
		$json_response->content = "No user is logged in.";

	}

} else {

	$json_response->status = 1;
	$json_response->type = "text";
	$json_response->content = "The request was incomplete.";

}

echo json_encode($json_response);

 ?>