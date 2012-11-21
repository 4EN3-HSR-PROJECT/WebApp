<?php

function getAll () {
	
	// Formulate queries
	$getdb = 'use hsr_data';
	$query = 'SELECT Route_id, Route_short_name, Route_long_name FROM Routes ORDER BY Route_short_name';
	
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
			'id'     => $row['Route_id'],
			'number' => $row['Route_short_name'],
			'name'   => $row['Route_long_name'] );
	}
	
	// Return results
	return $routes;
}


function getByStop ($stop) {
	
	// Formulate queries
	$getdb = 'use hsr_data';
	$query = 'SELECT number FROM bus_routes,bus_route_stops WHERE number=route_no AND stop_no=' . $stop . ' ORDER BY number';
	
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
		$routes[] = $row['number'];
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