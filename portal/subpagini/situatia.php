<?php

redirect_if_not_logged_in("/portal");

$db = new db_connection();

$sem = getCurrentSemestru();
if (isset($_GET["sem"])) {
	$sem = $_GET["sem"];
	if ($sem != "1" && $sem != "2")
		header("Location: /portal/situatia/?sem=" . getCurrentSemestru());
}

$elev = $db->retrieve_utilizator_where_username("Id,IdClasa", $_SESSION["logatca"]);
$clasa = $db->retrieve_clasa_where_id("*", $elev["IdClasa"]);

?>

<!DOCTYPE html>

<html>

	<head>

		<title>Situația elevului - Portal LTPM</title>
 		<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-include.php"); ?>

	</head>

<body>
<?php $header_cpage = "situatia"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/navbar.php"); ?>

	<div class="container">
	
		<div class="text-center h1">
			CLASA <?= $clasa["Nivel"] ?>-<?= $clasa["Sufix"] ?>
		</div>
		<div class="text-center h2 mb-3">
			<?php if ($sem == "2") : ?>
				<a href="?sem=1">&lt;</a>
			<?php endif; ?>
			SEMESTRUL <?= $sem ?>
			<?php if ($sem == "1") : ?>
				<a href="?sem=2">&gt;</a>
			<?php endif; ?>
		</div>

		<ul class="nav nav-tabs" id="materii-filter-tabs">
			<li class="nav-item">
				<a class="nav-link active" href data-filter="all">Toate</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href data-filter="note">Note</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href data-filter="absente">Absențe</a>
			</li>
		</ul>

		<div id="materii-table"></div>
		
	</div>

</body>

<?php include("situatia.templ.php"); ?>
<script>
	var _elevId = <?= $elev["Id"] ?>;
	var _sem = "<?= $sem ?>";
</script>
<script src="/portal/js"></script>
<script src="/portal/situatia/js"></script>

</html>