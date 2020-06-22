<?php

redirect_if_not_logged_in("/portal");

$db = new db_connection();
$resursa_nou = $db->retrieve_resursa_nou("Id", $_SESSION["logatid"], $_SESSION["logatca"]);

?>

<!DOCTYPE html>

<html>

<head>

	<title>Adaugă resursă - Portal LTPM</title>
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-include.php"); ?>
    <script src="https://cdn.tiny.cloud/1/dtz64zalt8bkviwq7mopvf8ru8t1579ai0eltzuw53v13hzd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body>

	<?php $header_cpage = "resurse"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/navbar.php"); ?>

	<div class="container">

        <h1>Adaugă resursă nouă</h1>

        <form id="resursa-form" method="POST" action="/portal/resurse/nou/post">
            <input type="hidden" name="form-id">
            <input type="hidden" name="resursa">

            <div class="row mb-1">
                <div class="col-md-2 pt-1 font-weight-bold">
                    Titlul:
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="titlu">
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-md-2 pt-1 font-weight-bold">
                    Clasa țintă a resursei:
                </div>
                <div class="col-md-10">
                    <select class="form-control" name="nivel">
                        <?php for ($i = 0; $i <= 12; $i++) : ?>
                            <?php if ($i == 0) : ?>
                                <option value="notset">Niciuna</option>
                            <?php else : ?>
                                <option value="<?= $i ?>">Clasa <?= $i ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            
            <div class="font-weight-bold mb-1">Conținutul text al resursei:</div>
            <textarea rows="4"></textarea>

            <div class="font-weight-bold mb-1 mt-1">Atașamente:</div>
            <div id="files-container" class="mb-1">
            </div>
            <button type="button" class="btn btn-default border-primary mb-2" id="add-file-button">Atașează fișier nou</button><br>

            <button type="submit" class="btn btn-primary mt-3" id="resursa-form-submit">
                Adaugă resursă
            </button>

            <div id="resurse-div">
            
            </div>

        </form>

	</div>

</body>

<script>
    var resursa_nou_id = <?= $resursa_nou["Id"] ?>;
</script>
<script src="/portal/resurse/nou/js"></script>
<?php include("nou.templ.php"); ?>

</html>