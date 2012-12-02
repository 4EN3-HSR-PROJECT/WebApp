<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">																			<!-- Character set -->
	<meta name="viewport" content="width=device-width, initial-scale=1">							<!-- Mobile setup -->
	<script src="http://code.jquery.com/jquery-1.8.3.js"></script>									<!-- jQuery -->
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.js"></script>				<!-- jQuery Mobile -->
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css">	<!-- jQuery Mobile stylesheet -->
	<script src="js/jquery.validate.js"></script>													<!-- jQuery validation plugin -->
	<script src="js/toolbar.js"></script>															<!-- Toolbar fix -->
</head>


<body>

<?php include 'splash.php' ?>

<div style="background: url(bg.jpg) black no-repeat scroll center top;background-size: cover;" id="main" data-url="main" data-role="page" data-theme="a">
<div data-role="header" data-position="fixed" data-id="globalnav">
<h1>HSR Tracker</h1>
<div data-role="navbar" name="main_nav" id="main_nav">
<ul>
<li><a href="#bus" id="main_nav_bus" onClick="setToolbars('bus');">Bus</a></li>
<li><a href="#main" id="main_nav_main" onClick="setToolbars('main');" class="ui-btn-active">Information</a></li>
<li><a href="#taxi" id="main_nav_taxi" onClick="setToolbars('taxi');">Taxi</a></li>
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