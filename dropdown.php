<?php

/*
 * Array should be split into the following format:
 *   ['val']		- the value of the entry when selected
 *   ['display']	- the info displayed in the dropdown
 * Array must be serialized and base64-encoded.
 */

function dropDown($array, $title = "") {
	$output = '';
	$output .= '<option value="" style="display:none;">';
	$output .= $title;
	$output .= '</option>';
	foreach ($array as $element) {
		$output .= '<option value="' . $element['val'] . '">';
		$output .= $element['display'];
		$output .= '</option>';
	}
	return $output;
}


if (!isset($_REQUEST['array'])) {
	die('Array not set');
}
$array = unserialize(base64_decode($_REQUEST['array']));
if (!isset($_REQUEST['title'])) {
	$title = "";
} else {
	$title = $_REQUEST['title'];
}

$result = dropDown($array,$title);
echo $result;

?>