<?php

function getAll () {

	// Formulate queries
	$getdb = 'use hsr_data';
	$query = '
		SELECT
			Stop_id,
			Stop_code,
			Stop_name
		FROM
			Stops
		ORDER BY
			Stop_code';
	
	// Connect to database
	include '/var/www/db.php';
	$connected = mysql_query($getdb);
	if (!$connected) {
		die('Could not connect to database: ' . mysql_error());
	}
	
	// Perform main query
	$result = mysql_query($query);
	if (!$result) {
		die('Could not run query: ' . mysql_error());
	}
	
	// Get results
	while ($row = mysql_fetch_assoc($result)) {
		$stops[] = array(
			'val'		=> 	$row['Stop_id'],
			'display'	=>	$row['Stop_code']
						.	' - '
						.	$row['Stop_name']
			);
	}
	
	// Return results
	return $stops;
}


function getByRoute ($route) {

	// Formulate queries
	$getdb = 'use hsr_data';
	$query = '
		SELECT DISTINCT
			Stops.Stop_id,
			Stop_code,
			Stop_name
		FROM
			Routes,
			Trips,
			Stop_Times,
			Stops
		WHERE
			Routes.Route_id = ' . $route . '
			AND
			Routes.Route_id = Trips.Route_id
			AND
			Trips.Trip_id = Stop_Times.Trip_id
			AND
			Stop_Times.Stop_id = Stops.Stop_id
			
		ORDER BY
			Stop_code';
	
	// Connect to database
	include '/var/www/db.php';
	$connected = mysql_query($getdb);
	if (!$connected) {
		die('Could not connect to database: ' . mysql_error());
	}
	
	// Perform main query
	$result = mysql_query($query);
	if (!$result) {
		die('Could not run query: ' . mysql_error());
	}
	
	// Get results
	while ($row = mysql_fetch_assoc($result)) {
		$stops[] = array(
			'val'		=> 	$row['Stop_id'],
			'display'	=>	$row['Stop_code']
						.	' - '
						.	$row['Stop_name']
			);
	}
	
	// Return results
	return $stops;
}



/******************
 * Handle Request *
 ******************/
 // Get stops on specific route
 if (isset($_REQUEST['route'])) {
	if (isset($_REQUEST['standalone'])) {
		print_r (getByRoute($_REQUEST['route']));
	} else {
		echo base64_encode(serialize(getByRoute($_REQUEST['route'])));
	}
// Get all stops
} else {
	if (isset($_REQUEST['standalone'])) {
		print_r (getAll());
	} else {
		echo base64_encode(serialize(getAll()));
	}
}

?>