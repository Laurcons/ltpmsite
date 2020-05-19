<?php

function truncMedie($num) {

	return ((int)($num * 100)) / 100;

}

// nota data should contain
//  "Nota" => ...
function averageNote($nota_data_array) {

	$sum = $count = 0;
	foreach ($nota_data_array as $nota) {
		if ($nota["Tip"] == "teza")
			continue;
		$sum += $nota["Nota"];
		$count++;
	}

	$avg = $sum / (($count != 0) ? $count : 1); // prevent division by zero
	$avg = truncMedie($avg);

	return $avg;

}

// nota data should contain
//  "Nota" => ...
//  "Tip" => ...
function averageNoteWithTeza($nota_data_array) {

	$avg_oral = averageNote($nota_data_array);

	if ($avg_oral == 0)
		return 0;

	// vezi daca sunt note la teza prin sir
	$nota_teza = // these are applied from bottom to top, btw
		array_values(
			array_map(function($nota_data) {
				return $nota_data["Nota"];
			}, 
			array_filter($nota_data_array, function($nota_data) {
				return $nota_data["Tip"] == "teza";
			})
		)
	);

	// daca nu sunt, returneaza
	if (count($nota_teza) == 0)
		return $avg_oral;

	$nota_teza = $nota_teza[0];

	// fa media
	$avg = (($avg_oral * 3) + $nota_teza) / 4;
	$avg = truncMedie($avg);

	return $avg;

}

function roundMedie($medie) {
	$decimal = $medie - (int)$medie;
	if ($decimal < 0.5)
		return (int)$medie;
	else return (int)$medie + 1;
}

// array must contain "Ziua" and "Data" fields
function sortBySchoolDate(&$objects) {

	// split between pre-aug and post-aug
	$preAug = array();
	$postAug = array();
	foreach ($objects as $object) {
		if ($object["Luna"] < 8)
			$preAug[] = $object;
		else $postAug[] = $object;
	}

	// sort
	$sortFunc = function($first, $second) {
		if ($first["Luna"] == $second["Luna"]) {
			return $first["Ziua"] - $second["Ziua"];
		} else return $first["Luna"] - $second["Luna"];
	};
	usort($preAug, $sortFunc);
	usort($postAug, $sortFunc);

	// join them, in reverse
	$objects = array_merge($postAug, $preAug);

}

function getCurrentSemestru() {

	return (date("n") < 8 ? "2" : "1");

}

?>