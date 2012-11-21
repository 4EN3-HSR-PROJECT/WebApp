<?php

function getBusStops() {

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

function getBusRoutes($stop) {

	// Check for empty stop parameter
	if ($stop == "") {
		return array();
	}
	
	// Formulate queries
	$getdb = 'use hsr_data';
	$query = 'SELECT bus_routes.number AS bus_number FROM bus_routes,bus_route_stops,bus_stops WHERE bus_routes.number = route_no AND stop_no = bus_stops.number AND stop_no = ' . $stop . ' ORDER BY route_no';
	
	//Connect to database
	include '/var/www/db.php';
	$connected = mysql_query($getdb);
	if (!$connected) {
		die('Could not connect to database: ' . mysql_error());
	}
	
	// Perform query
	$result = mysql_query($query);
	if (!$result) {
		die('Could not run query: ' . mysql_error());
	}
	
	// Get results
	while ($row = mysql_fetch_assoc($result)) {
		$routes[] = $row['bus_number'];
	}
	
	// Return results
	return $routes;
}


/******************
 * Handle Request *
 ******************/
 if (isset($_GET['request'])) {
	switch ($_GET['request']) {
		case 'stops':
			echo serialize(getBusStops());
			break;
		case 'routes':
			if (isset($_GET['arg'])) {
				echo serialize(getBusRoutes($_GET['arg']));
			}
			break;
	}
 }

?>