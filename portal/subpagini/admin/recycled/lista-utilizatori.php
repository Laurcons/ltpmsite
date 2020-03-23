<?php

redirect_if_not_autoritate("admin", "/panel");

$db = new db_connection();

$page = 0;
$entries_per_page = 3;
if (isset($_GET["pag"])) {
	$page = $_GET["pag"];
}

$utilizatori = $db->retrieve_paged_utilizatori('*', $entries_per_page, $page);

// determina cate pagini sunt
$page_count = intval($db->retrieve_count_utilizatori() / $entries_per_page) + 1;

?>

<?php function insert_pagination($page, $page_count) { ?>

	<ul class="pagination">

		<?php if ($page == 0) : ?>

			<li class="page-item disabled"><a class="page-link">
				Inapoi
			</a></li>

		<?php else : ?>

			<li class="page-item"><a href="/portal/?p=admin&sp=utiliz&pag=<?= $page - 1 ?>" class="page-link">
				Inapoi
			</a></li>

		<?php endif; ?>

		<?php for ($i = 1; $i <= $page_count; $i++) : ?>

			<li class="page-item <?= ($page+1 == $i) ? 'active' : '' ?>"><a href="/portal/?p=admin&sp=utiliz&pag=<?= $i - 1 ?>" class="page-link">
				<?= $i ?>
			</a></li>

		<?php endfor; ?>

		<?php if ($page == $page_count - 1) : ?>

			<li class="page-item disabled"><a class="page-link">
				Inainte
			</a></li>

		<?php else : ?>

			<li class="page-item"><a href="/portal/?p=admin&sp=utiliz&pag=<?= $page + 1 ?>" class="page-link">
				Inainte
			</a></li>

		<?php endif; ?>

	</ul>

<?php } // insert_pagination() ?>

<!DOCTYPE html>

<html>

<head>

	<title>Utilizatori - Administrare - Portal LTPM</title>
 	<?php include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/html-head.php"); ?>

</head>

<body style="background-color: #f5f5f5">

	<?php $header_cpage = "admin"; include($_SERVER["DOCUMENT_ROOT"] . "/portal/include/header.php"); ?>

	<div class="container">

		<h2 class="mb-4">Administrare platforma</h2>

		<nav class="nav nav-pills nav-fill m-2">

			<a class="nav-item nav-link active" href="">Utilizatori</a>
			<a class="nav-item nav-link" href="/portal/?p=admin&sp=materii">Materii</a>

		</nav>

		<hr />

		<?php insert_pagination($page, $page_count); ?>

		<table class="table table-bordered table-hover">
			<!-- PAY EXTREME CARE WHEN WORKING ON THIS -bub-->

			<thead>

				<th>Id</th>
				<th>Username</th>
				<th>Email</th>
				<th>Autoritate</th>
				<th>Functie</th>
				<th>Nume si prenume</th>
				<th>Suplimentar</th>

			</thead>
			<!-- PAY EXTREME CARE WHEN WORKING ON THIS -bub-->

			<?php while ($row = $utilizatori->fetch_assoc()) {

				echo "<tr>";
				echo "<td>" . $row["Id"] . "</td>";
				echo "<td>" . $row["Username"] . "</td>";
				echo "<td>" . $row["Email"] . "</td>";
				echo "<td>" . $row["Autoritate"] . "</td>";
				echo "<td>" . $row["Functie"] . "</td>";
				echo "<td>" . $row["Nume"] . " " . $row["Prenume"] . "</td>";

				$modal_edit_id = "edit-" . $row["Id"];
				$modal_info_id = "info-" . $row["Id"];

			?>

				<td>

					<button class="btn btn-info" data-toggle="modal" data-target="#<?php echo $modal_info_id; ?>">Info</button>

					<button class="btn btn-danger" data-toggle="modal" data-target="#<?php echo $modal_edit_id; ?>">Editeaza</button>

				</td>

				<!-- Edit modal -->
				<div class="modal fade" id="<?php echo $modal_edit_id; ?>" role="dialog">
					<div class="modal-dialog">

						<div class="modal-content">

							<div class="modal-header">

								<h4 class="modal-title">Editeaza datele utilizatorului</h4>

							</div>

							<div class="modal-body">

								<form action="#" method="POST">

									<input type="hidden" id="userid" value="<?php echo $row["Id"]; ?>" />

									<div class="form-group">

										<label class="control-label" for="username">Numele de utilizator: (Username)</label>

										<input type="text" class="form-control" id="username" value="<?php echo $row["Username"]; ?>">

									</div>

								</form>

							</div>

							<div class="modal-footer">

								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

							</div>

						</div>

					</div>
				</div>
				<!-- Info modal -->
				<div class="modal fade" id="<?php echo $modal_info_id; ?>" role="dialog">
					<div class="modal-dialog">

						<div class="modal-content">

							<div class="modal-header">

								<h4 class="modal-title">Informatii detaliate despre utilizator</h4>

							</div>

							<div class="modal-body">

								<p>

									<b>Id: </b>
									<?php echo $row["Id"]; ?>

								</p>
								<p>

									<b>Nume de utilizator: </b>
									<?php echo $row["Username"]; ?>

								</p>
								<p>

									<b>Email: </b>
									<?php echo $row["Email"]; ?>

								</p>
								<p>
									<b>Autoritate: </b>
									<?php echo $row["Autoritate"]; ?>
								</p>

							</div>

							<div class="modal-footer">

								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

							</div>

						</div>

					</div>
				</div>
			<!-- PAY EXTREME CARE WHEN WORKING ON THIS -bub-->
			<?php echo "</tr>"; } ?>

		</table>

		<?php insert_pagination($page, $page_count); ?>

	</div>

</body>

</html>