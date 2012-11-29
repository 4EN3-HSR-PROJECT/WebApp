<?php

// Get stop code entered by user
/*$stop = (isset($_POST['stop']))
?	$_POST['stop']
:	(isset($_GET['stop']))
	?	$_GET['stop']
	:	"";*/
$stop = (isset($_REQUEST['stop'])) ? $_REQUEST['stop'] : "";

// Ensure that stop code is of sufficient length
if (strlen($stop) != 4) {
	$results = (isset($results)) ? $results : "ERROR:Invalid stop code length! Please ensure the code is 4 numbers in length.";
	die();
}

// Check that stop code is an integer
if (!is_numeric($stop) || strpos($stop,"-") !== false || strpos($stop,"e") !== false || strpos($stop,"E") !== false || strpos($stop,".") !== false ) {
	$results = (isset($results)) ? $results : "ERROR:Invalid stop code format! Please ensure that the stop code contains only numbers.";
	die();
}

// Get bus service ID based on date
switch (intval(date('N'))) {
	case 6: // Saturday
		$sid = '2_merged_801261';
		break;
	case 7: // Sunday
		$sid = '3_merged_801260';
		break;
	default: // Weekday (Monday - Friday)
		$sid = '1_merged_801259';
		break;
}

// Formulate queries
$getdb = 'use hsr_data';
$query = "
	SELECT DISTINCT
		Route_Long_name,
		Route_Short_name,
		Trip_id,
		Stop_code,
		Arrival_time,
		Departure_time,
		Shape_id
	FROM
		Sched_Up2
	WHERE (
			Stop_code = $stop
		AND	CURTIME() < Arrival_time 
		AND	Arrival_time < ADDTIME('01:30:00', CURTIME())
		AND	service_id = '$sid'
		) 
	GROUP BY
		Route_Short_name,
		Arrival_time
	ORDER BY
		Arrival_time
";

// Connect to database
include '/var/www/db.php';
$connected = mysql_query($getdb);
if (!$connected) {
	$results = (isset($results)) ? $results : "ERROR:System is currently offline! Please try again later.";
	die('Could not connect to database: ' . mysql_error());
}

// Perform main query
$result = mysql_query($query);
if (!$result) {
	$results = (isset($results)) ? $results : "ERROR:An error has occurred! Please try again later.";
	die('Could not run query: ' . mysql_error());
}

// Get results
$max_count = 3;
while ($row = mysql_fetch_assoc($result)) {
	// Only add up to $max_count entires per route
	$count[$row['Route_short_name']] = (isset($count[$row['Route_short_name']])) ? $count[$row['Route_short_name']] + 1 : 1;
	if ($count <= $max_count) {
		$stops[] = $row;
	}
}

// Output final results
if (isset($stops)) {
	$results = json_encode($stops);
} else {
	$results = (isset($results)) ? $results : "ERROR:No buses found!";
}

?>