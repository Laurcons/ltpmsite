<?php

$db = new db_connection();

$username = $_POST["username"];
$parola = $_POST["parola"];

$redir = "/portal/panou";
if (isset($_GET["redir"])) {
	$redir = $_GET["redir"];
}

$response = new stdClass();

$user = $db->retrieve_utilizator_where_username('Id,Parola,Autoritate,Functie', $username);

if ($user == null) {

    $response->status = "username-not-found";

} else {

    $success = false;
    $isroot = false;
    //$isroot = $username == "root";

    if ($isroot) {
        // pass is in text
        if ($parola == $user["Parola"]) 
            $success = true;

    } else {

        if (password_verify($parola, $user["Parola"]))
            $success = true;
    }

    if ($success) {
        $_SESSION["logatca"] = $username;
        $_SESSION["logatid"] = $user["Id"];
        $_SESSION["logat"] = true;
        $_SESSION["autoritate"] = $user["Autoritate"];
        $_SESSION["functie"] = $user["Functie"];
        $_SESSION["ultimalogare"] = $db->retrieve_utilizator_ultima_logare($username);
        $db->update_utilizator_ultima_logare($username);

        $response->status = "success";
        $response->redir = $redir;

    } else {
        $response->status = "password-failed";
    }

}

header("Content-type: application/json");
echo(json_encode($response));

?>