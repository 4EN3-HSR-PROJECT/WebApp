<?php

$offset = -9 * 60 * 60;
$schedule_overflow = 2.5 * 60 * 60; // How far past midnight the schedule goes before starting a new day

// Get submitted variables
$stop = (isset($_REQUEST['stop'])) ? $_REQUEST['stop'] : "";
$sort = (isset($_REQUEST['sort'])) ? $_REQUEST['sort'] : "route";

// Ensure that stop code is of sufficient length
if (strlen($stop) != 4) {
	$result = (isset($result)) ? $result : "ERROR:Invalid stop code length!<br>Please ensure the code is 4 numbers in length.";
	echo $result;
	die();
}

// Check that stop code is an integer
if (!is_numeric($stop) || strpos($stop,"-") !== false || strpos($stop,"e") !== false || strpos($stop,"E") !== false || strpos($stop,".") !== false ) {
	$result = (isset($result)) ? $result : "ERROR:Invalid stop code format!<br>Please ensure that the stop code contains only numbers.";
	echo $result;
	die();
}

if (strpos($stop,'0') === 0) {
	$result = (isset($result)) ? $result : "ERROR:Invalid stop code format!<br>A stop code cannot begin with the number '0'.";
	echo $result;
	die();
}

// Set query variables
switch (intval(date('N', time() - $offset - $schedule_overflow))) {
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
if ($sort == "time") {
	$group1 = "Arrival_time";
	$group2 = "Route_Short_name";
} else /*($sort == "route")*/ {
	$group1 = "Route_Short_name";
	$group2 = "Arrival_time";
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
		$group1,
		$group2
";

// Connect to database
include '/var/www/db.php';
$connected = mysql_query($getdb);
if (!$connected) {
	$result = (isset($result)) ? $result : "ERROR:System is currently offline!<br>Please try again later.";
	echo $result;
	die('Could not connect to database: ' . mysql_error());
}

// Perform main query
$sqlResult = mysql_query($query);
if (!$sqlResult) {
	$result = (isset($result)) ? $result : "ERROR:An error has occurred!<br>Please try again later.";
	echo $result;
	die('Could not run query: ' . mysql_error());
}

// Get results
$max_count = 3;
while ($row = mysql_fetch_assoc($sqlResult)) {
	// Only add up to $max_count entires per route
	$count[$row['Route_short_name']] = (isset($count[$row['Route_short_name']])) ? $count[$row['Route_short_name']] + 1 : 1;
	if ($count[$row['Route_short_name']] <= $max_count) {
		$data = $row;
		$currenttime = time() + $offset; // 9 hours offset
		$timestamp = strtotime($row['Arrival_time'], $currenttime);
		$data['Arrival_time'] = date ( 'g:i a', $timestamp);
		if ($timestamp - $currenttime < 900) {
			$data['Arrival_time'] .= '<font color="#aaaaaa"> (' . round(($timestamp - $currenttime)/60) . ' min)</font>';
		}
		$stops[] = $data;
	}
}

// Output final results
if (isset($stops)) {
	$result = json_encode($stops);
} else {
	$result = (isset($result)) ? $result : "ERROR:No buses found!";
}

if (isset($_GET['echo'])) {
	print_r($result);
} else {
	echo $result;
}

?>