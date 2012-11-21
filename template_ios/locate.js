function findGeo() {
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {enableHighAccuracy:true, timeout:60000});
	} else {
		alert("Geolocation API is not supported in your browser.");
	}
};

function successCallback(position){
	// set up the Geocoder object
	var geocoder = new google.maps.Geocoder();

	// turn coordinates into an object
	var yourLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

	// find out info about our location
	geocoder.geocode({ 'latLng': yourLocation }, function (results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				document.getElementById("location").value = results[0].formatted_address;
			} else {
				error('Google did not return any results.');
			}
		} else {
			error("Reverse Geocoding failed due to: " + status);
		}
	});
};

function errorCallback(error){
	var msg = "";
	switch(error.code) {
		case error.PERMISSION_DENIED:
			msg = "The website does not have permission to use geolocation";
			break;
		case error.POSITION_UNAVAILABLE:
			msg = "The current position could not be obtained";
			break;
		case error.PERMISSION_DENIED_TIMEOUT:
			msg = "The permission could not be retrieved within timeout";
			break;
		default:
			msg = "Error occured : " + error.code.toString();
		}
	document.getElementById("location").value = msg;
};