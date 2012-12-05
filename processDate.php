<?php
date_default_timezone_set('America/Toronto');
$timeOfSubmission = date("g:i:s", $_REQUEST["timeOfSubmission"]);
$distance = date("g:i:s", strtotime("+".$_REQUEST["distance"], $_REQUEST["timeOfAcceptance"]));
echo json_encode(array('timeOfSubmission' => $timeOfSubmission, 'timeOfAcceptance' => $distance));
?>