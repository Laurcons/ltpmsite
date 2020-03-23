<?php 

function roman_from_number($num) {

	$roman_code = 8543;
	$roman_code = $roman_code + $num;
	if ($roman_code == 8543)
		$luna = "?";
	else $luna = "&#" . $roman_code . ";";

	return $luna;

}

function string_date_from_nota_with_html($nota_data) {

	$ziua = $luna = "";
	if ($nota_data["Ziua"] < 10)
		$ziua = $ziua . "0";
	$ziua = $ziua . $nota_data["Ziua"];

	$luna = roman_from_number($nota_data["Luna"]);

	return "" . $ziua . " " . $luna . "";

}

function string_date_from_nota($nota_data) {

	$ziua = $luna = "";
	if ($nota_data["Ziua"] < 10)
		$ziua = $ziua . "0";
	$ziua = $ziua . $nota_data["Ziua"];

	$luna = roman_from_number($nota_data["Luna"]);

	return "" . $ziua . " " . $luna . "";

}


function insert_nota($nota_data, $tooltip = true, $cursor = "default") {

	if ($tooltip)
		$data_string = string_date_from_nota_with_html($nota_data);
	// div nota
	echo '<div class="d-inline float-left border border-secondary bg-white rounded p-1 mr-1 mb-1" style="width: 2.5rem; cursor: '.$cursor.';" ';
	// tooltip
	if ($tooltip) 
		echo 'data-toggle="tooltip" data-placement="bottom" title="Acordata la ' . $data_string . '">';
	else echo '>';
	// h4
	echo '<h4 style="text-align: center;">';
	echo $nota_data["Nota"];
	echo '</h4></div>';

}

function insert_nota_with_date($nota_data, $tooltip = false) {

	if ($tooltip)
		$data_string = string_date_from_nota_with_html($nota_data);
	?>

		<div class="d-inline float-left border border-secondary bg-white rounded p-1 mr-1 mb-1" style="width: 4rem; cursor: default;"
			<?php if ($tooltip) : ?>
				data-toggle="tooltip" data-placement="bottom" title="Acordata la <?= $data_string ?>">
			<?php else : ?>
				>
			<?php endif; ?>

			<h4 style="text-align: center;">

				<?= $nota_data["Nota"] ?>

				<small><?= $data_string ?></small>

			</h4>

		</div>

	<?php

}

function insert_absenta($absenta_data) {

	$ziua = $absenta_data["Ziua"];
	$luna = roman_from_number($absenta_data["Luna"]);

	?>
	<div class="d-inline float-left border border-secondary bg-white rounded p-1 mr-1 mb-1" style="width: 4.5rem; cursor: default;">

		<h4 class="text-center"><?= $ziua ?> <small><?= $luna ?></small></h4>

	</div>
	<?php

}

 ?>