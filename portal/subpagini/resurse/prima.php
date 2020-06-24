<?php

redirect_if_not_logged_in("/portal");

$db = new db_connection();

$id = $_GET["id"] ?? -1;

?>

<!DOCTYPE html>

<html>

<head>

	<title>Resurse - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-include.php"); ?>

</head>

<body>

	<?php $header_cpage = "resurse"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/navbar.php"); ?>

	<div class="container">

        <?php if ($id == -1) : ?>

            <div class="jumbotron">

                <h1>Resursele elevilor</h1>

                <p>Locul centralizat unde profesorii își pot încărca resursele educaționale, pentru
                a putea fi folosite în mod nelimitat de către elevi</p>

            </div>

            <a class="float-right btn btn-default border-primary ml-3" href="/portal/resurse/nou">Adaugă resursă</a>

            <h2>Profesori cu resurse</h2>

            <?php $profesori = $db->retrieve_profesori_with_resurse_pdo("Id,Nume,Prenume"); ?>
            <ul>
            <?php foreach ($profesori as $prof) : ?>

                <li><a href="/portal/resurse/profesori/<?= $prof["Id"] ?>">prof. <?= $prof["Nume"] . " " . $prof["Prenume"] ?></a> (<?= $prof["NumResurse"] ?> resurse)</li>

            <?php endforeach; ?>
            </ul>

            <h2>Clase cu resurse</h2>

            <?php $clase = $db->retrieve_clase_with_resurse_pdo(); ?>
            <ul>
            <?php foreach ($clase as $clasa) : ?>

                <?php if ($clasa["Nivel"] == "notset") : ?>
                    <li><a href="/portal/resurse/clase/0">Fără clasă</a> (<?= $clasa["NumResurse"] ?> resurse)</li>
                <?php else : ?>
                    <li><a href="/portal/resurse/clase/<?= $clasa["Nivel"] ?>">Clasa a <?= $clasa["Nivel"] ?>-a</a> (<?= $clasa["NumResurse"] ?> resurse)</li>
                <?php endif; ?>

            <?php endforeach; ?>
            </ul>

            <h2>Ultimele 5 resurse</h2>

            <div id="latest-resurse-div"></div>

        <?php else : ?>

            <?php 
                // obtine resursa
                $resursa = $db->retrieve_resursa_where_id("*", $id);
                $prof = $db->retrieve_utilizator_where_id("Id,Nume,Prenume", $resursa["IdProfesor"]);
            ?>

            <ol class="breadcrumb"> 
                <li class="breadcrumb-item"><a href="/portal/resurse">Resurse</a>
                <?php if ($resursa["Nivel"] != "notset" && $_GET["from"] == "clasa") : ?>
                    <li class="breadcrumb-item"><a href="/portal/resurse/clase/<?= $resursa['Nivel'] ?>">Clasa a <?= $resursa["Nivel"] ?>-a</a></li>
                <?php endif; ?>
                <?php if ($_GET["from"] == "prof") : ?>
                    <li class="breadcrumb-item"><a href="/portal/resurse/profesor/<?= $prof['Id'] ?>">prof. <?= $prof["Nume"] . " " . $prof["Prenume"] ?></a></li>
                <?php endif; ?>
                <li class="breadcrumb-item active"><?= substr($resursa["Titlu"], 0, 50); ?>
            </ol>

            <h1><?= $resursa["Titlu"] ?></h1>

            <div class="border rounded bg-white p-2">
                <?= security\xss_clean($resursa["ContinutHtml"]) ?>
            </div>

            <strong>Fișiere atașate:</strong>

            <ul>
                <?php
                    $atasamente = $db->retrieve_resursa_files_where_resursa_id("Filepath", $resursa["Id"]);

                    foreach ($atasamente as $atasament) : ?>

                    <li><a href="<?= $atasament['Filepath'] ?>" target="_blank"><?= basename($atasament["Filepath"]) ?></a></li>

                <?php endforeach; ?>
            </ul>

        <?php endif; ?>

	</div>

    <script src="/portal/resurse/js"></script>

</body>

<?php
    if ($id == -1)
        require("prima.list.templ.php");
    else require("prima.one.templ.php");
?>

</html>