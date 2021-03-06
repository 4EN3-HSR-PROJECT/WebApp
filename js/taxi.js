var iosocket = io.connect('http://danesh.it.cx:8080');

iosocket.on('connect', function() {
	iosocket.emit("joinroom", "passengers");
	iosocket.on('disconnect', function() {
		// Todo : put something here
	});
	iosocket.on('requestaccepted', function(message) {
		$('#block-ui').hide();
		showSummaryInfo(message);
	});
	iosocket.on('pendingRequest', function(message) {
		if(message != null && message.driver != undefined) {
			$('#block-ui').hide();
			showSummaryInfo(message);
		} else if(message != null) {
			$('#name').val(message.name);
			$('#phonenumber').val(message.number);
			$('#pickuplocation').val(message.formatted_address);
			$('#block-ui').show();
			$.mobile.loading('show', {
				text: 'Searching for available drivers in the area',
				textVisible: true,
				theme: 'a',
				html: ""
			});
		}
	});
});

function showSummaryInfo(message) {
        $.mobile.loading('hide');
        $("#statPage").hide();
        $("#summary").show();
        $("#summary").html('');
        $('#summary').append("<br /><br /><b>  Name : " + message.name + "</b><br /><br />");
        $args = "timeOfAcceptance="+message.timeOfAcceptance + "&distance=" + message.distance + "&timeOfSubmission=" + message.timeOfSubmission;
        jQuery.ajax({
                type: "POST",
                url: "processDate.php",
                data: $args,
                dataType: 'json',
                type : 'POST',
                success: function(result) {
                    $('#summary').append("<b>Time of submission : " + result.timeOfSubmission + "</b><br /><br />");
                    $('#summary').append("<b>Estimated Time Of Arrival : " + result.timeOfAcceptance + "</b><br /><br />");
                },
                error: function(e) {
                    alert('Error: ' + e);
                }
        });
}

function submitRequest() {
	var name = $('#name').val();
	var number = $('#phonenumber').val();
	var address = $('#pickuplocation').val();
	var geocoder = new google.maps.Geocoder();
	if(name === '' || number === '' || address === '') {
		alert("Please fill in all fields");
		return;
	}
	$('#block-ui').show();
	$.mobile.loading('show', {
		text: 'Sending request',
		textVisible: true,
		theme: 'a',
		html: ""
	});
	geocoder.geocode({
		'address': address
	}, function(results, status) {
		if(status == google.maps.GeocoderStatus.OK) {
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
			address = latitude + "|" + longitude;
			var msg = {
				"name": name,
				"number": number,
				"address": address,
				"formatted_address": $('#pickuplocation').val()
			};
			iosocket.emit("requesttaxi", msg);
			$.mobile.loading('show', {
				text: 'Searching for available drivers in the area',
				textVisible: true,
				theme: 'a',
				html: ""
			});
		} else {
			alert("Unable to determine location, please retry");
		}
	});
};

function findGeo() {
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
			enableHighAccuracy: true,
			timeout: 60000
		});
	} else {
		alert("Geolocation API is not supported in your browser.");
	}
};

function successCallback(position) {
	// set up the Geocoder object
	var geocoder = new google.maps.Geocoder();

	// turn coordinates into an object
	var yourLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

	// find out info about our location
	geocoder.geocode({
		'latLng': yourLocation
	}, function(results, status) {
		if(status == google.maps.GeocoderStatus.OK) {
			if(results[0]) {
				$('#pickuplocation').val(results[0].formatted_address);
			} else {
				error('Google did not return any results.');
			}
		} else {
			error("Reverse Geocoding failed due to: " + status);
		}
	});
};

function errorCallback(error) {
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
	alert(msg);
};

function resetForm() {
	$('#name').val("");
	$('#phonenumber').val("");
	$('#pickuplocation').val("");
}