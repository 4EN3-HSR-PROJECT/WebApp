<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css">
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
<script src="dropdown.js"></script>
<link rel="stylesheet" href="jquery.mobile-1.1.0.custom.css?" />


    <script>

        var iosocket = io.connect();

        function buildPostString(msg) {
          var url = 'http://danesh.it.cx/mondegd/passengerSummary.php';
          var beginning = '<form action="' + url + '" method="post">';
          var stringBuilder = beginning;
          for(var h in msg) {
            stringBuilder += '<input type="text" name="' + h + '" value="' + msg[h] + '" />';
          }
          return stringBuilder + '</form>';
        };

        iosocket.on('connect', function() {
          iosocket.emit("joinroom", "passengers");
          iosocket.on('disconnect', function() {
            // Todo : put something here
          });
          iosocket.on('requestaccepted', function(message) {
            $('#block-ui').hide();
            var url = 'http://danesh.it.cx/mondegd/passengerSummary.php';
            var form = $(buildPostString(message));
            $('body').append(form);
            $(form).submit();
          });
          iosocket.on('pendingRequest', function(message) {
            if(message != null && message.driver != undefined) {
              var form = $(buildPostString(message));
              $('body').append(form);
              $(form).submit();
            } else if (message != null) {
              $('#name').val(message.name);
              $('#phonenumber').val(message.number);
              $('#pickuplocation').val(message.formatted_address);
              $('#block-ui').show();
              $.mobile.loading( 'show', {
                text: 'Searching for available drivers in the area',
                textVisible: true,
                theme: 'a',
                html: ""
              });
            }
          });
        });

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
          $.mobile.loading( 'show', {
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
                "formatted_address" : $('#pickuplocation').val()
              };
              iosocket.emit("requesttaxi", msg);
              $.mobile.loading( 'show', {
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

    </script>

</head>


<body onload="getDropdown('bus_stop','sql/getStops.php','title=Stop+Number'); getDropdown('bus_route','sql/getRoutes.php','title=Route+Number');">

<div style="background: url(WebAppBg.jpg) black no-repeat scroll center top;background-size: cover;" id="main" data-url="main" data-role="page" data-theme="a">
<div data-role="header">
<h1>HSR Tracker</h1>
<div data-role="navbar">
<ul>
<li><a href="#bus">Bus</a></li>
<li><a href="#main" class="ui-btn-active">Information</a></li>
<li><a href="#taxi">Taxi</a></li>
</ul>
</div>

</div>

<div data-role="content">
The HSR Bus Tracker app uses realtime GPS information to compile an accurate bus schedule based on actual bus positions.
<a href="#bus" data-role="button" data-theme="b">Find a Bus</a>
Is your bus running late? Request a taxi to pick you up without making a single phone call!
<a href="#taxi" data-role="button" data-theme="b">Request a Taxi</a>
<?php include 'bulletin.php' ?>

</div></div>

<?php include 'page_bus.html' ?>
<?php include 'page_taxi.html' ?>

</body>
</html>