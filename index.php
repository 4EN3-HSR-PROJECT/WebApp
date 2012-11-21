<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css">
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
<link rel="stylesheet" href="jquery.mobile-1.1.0.custom.css?" />
</head>
<body>

<div id="main" data-url="main" data-role="page" data-theme="b">
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
<a href="#bus" data-role="button">Find a Bus</a>
Is your bus running late? Request a taxi to pick you up without making a single phone call!
<a href="#taxi" data-role="button">Request a Taxi</a>
<?php include 'bulletin.php' ?>

</div></div>

<?php include 'page_bus.php' ?>
<?php include 'page_taxi.php' ?>

</body>
</html>