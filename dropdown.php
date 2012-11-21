<?php

/*
 * Array should be split into the following format:
 *   ['val']		- the value of the entry when selected
 *   ['display']	- the info displayed in the dropdown
 */

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
		$output .= '<option value="' . $element['val'] . '">';
		$output .= $element['display'];
		$output .= '</option>';
	}
	$output .= '</select>';
	return $output;
}


if (!isset($_REQUEST['array'])) {
	die('Array not set');
}
$array = unserialize($_REQUEST['array']);
if (!isset($_REQUEST['alter'])) {
	$alter = "";
} else {
	$alter = $_REQUEST['alter'];
}

$result = dropDown($array,$alter);
echo $result;

?>