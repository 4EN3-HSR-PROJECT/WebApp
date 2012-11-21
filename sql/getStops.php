<?php

function getAll () {

	// Formulate queries
	$getdb = 'use hsr_data';
	$query = 'SELECT number FROM bus_stops ORDER BY number';
	
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
		$stops[] = $row['number'];
	}
	
	// Return results
	return $stops;
}


function getByRoute ($route) {

	// Formulate queries
	$getdb = 'use hsr_data';
	$query = 'SELECT number FROM bus_stops,bus_route_stops WHERE number=stop_no AND route_no="' . $route . '" ORDER BY number';
	
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
		$stops[] = $row['number'];
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
		echo serialize(getByRoute($_REQUEST['route']));
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