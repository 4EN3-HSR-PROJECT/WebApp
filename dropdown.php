<?php

function dropDown($array, $alter = "") {
	$id = mt_rand();
	$output = '<select name=' . $id . ' id=' . $id . ' data-theme="c"';
	if ($alter != '') {
		$output .= ' onchange="getDropdown(\'' . $alter . '\',\'request=' . $alter . '&arg=\' + $(\'#' . $id . '\').val())"';
	}
	if (empty($array)) {
		$output .= ' disabled';
	}
	$output .= '>';
	$output .= '<option value="" style="display:none;"></option>';
	foreach ($array as $element) {
		$output .= '<option value="' . $element . '">';
		$output .= $element;
		$output .= '</option>';
	}
	$output .= '</select>';
	return $output;
}


if (!isset($_GET['array'])) {
	die('Array not set');
}
$array = unserialize($_GET['array']);
if (!isset($_GET['alter'])) {
	$alter = "";
} else {
	$alter = $_GET['alter'];
}

$result = dropDown($array,$alter);
echo $result;

?>