<?php

function getAll () {
	
	// Formulate queries
	$getdb = 'use hsr_data';
	$query = '
		SELECT
			Route_id,
			Route_short_name,
			Route_long_name
		FROM
			Routes
		ORDER BY
			Route_short_name';
	
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
		$routes[] = array(
			'val'		=> 	$row['Route_id'],
			'display'	=>	$row['Route_short_name']
						.	' - '
						.	$row['Route_long_name']
			);
	}
	
	// Return results
	return $routes;
}


function getByStop ($stop) {
	
	// Formulate queries
	$getdb = 'use hsr_data';
	$query = '
		SELECT DISTINCT
			Routes.Route_id,
			Route_short_name,
			Route_long_name
		FROM
			Routes,
			Trips,
			Stop_Times,
			Stops
		WHERE
			Stops.Stop_id = ' . $stop . '
			AND
			Stops.Stop_id = Stop_Times.Stop_id
			AND
			Stop_Times.Trip_id = Trips.Trip_id
			AND
			Trips.Route_id = Routes.Route_id
		ORDER BY
			Routes.Route_short_name';
	
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
		$routes[] = array(
			'val'		=> 	$row['Route_id'],
			'display'	=>	$row['Route_short_name']
						.	' - '
						.	$row['Route_long_name']
			);
	}
	
	// Return results
	return $routes;
}



/******************
 * Handle Request *
 ******************/
 // Get stops on specific route
 if (isset($_REQUEST['stop'])) {
	if (isset($_REQUEST['standalone'])) {
		print_r (getByStop($_REQUEST['stop']));
	} else {
		echo serialize(getByStop($_REQUEST['stop']));
	}
// Get all stops
} else {
	if (isset($_REQUEST['standalone'])) {
		print_r (getAll());
	} else {
		echo serialize(getAll());
	}
}

?>