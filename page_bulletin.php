<!--
	This file is only part of a full html page and is to be
	included in another page (via php include, etc.) in order
	to provide full functionality.
-->


<?php include 'bulletin/contents.php' ?>


<div style="background: url(bg.jpg) black no-repeat scroll center top;background-size: cover;" id="bulletin" data-url="bulletin" data-role="page" data-theme="a">
<div data-role="header" data-position="fixed" data-id="globalnav">
	<h1>Announcements</h1>
	<div data-role="navbar" name="bulletin_nav" id="bulletin_nav">
		<ul>
		<li><a href="#bus" id="bulletin_nav_bus" onClick="setToolbars('bus');">Bus</a></li>
		<li><a href="#main" id="bulletin_nav_bulletin" onClick="setToolbars('bulletin');" class="ui-btn-active">Bulletin</a></li>
		<li><a href="#taxi" id="bulletin_nav_taxi" onClick="setToolbars('taxi');">Taxi</a></li>
		</ul>
	</div>
</div>


<ul data-role="listview" data-inset="true" name="bulletin" id="bulletin" data-theme="c">
	<?php foreach ($bulletin as $entry) {
		$title			= (isset($entry['title']))			? $entry['title']		: '';
		$link			= (isset($entry['link']))			? $entry['link']		: '';
		$image			= (isset($entry['image']))			? $entry['image']		: 'bulletin/default.png';
		$date			= (isset($entry['date']))			? $entry['date']		: '';
		$description	= (isset($entry['description']))	? $entry['description']	: '';
		if (strlen($title) >= 1) {
			echo "<li>";
			echo "<a href=\"$link\">";
			echo "<img src=\"$image\" />";
			echo "<h3>$title</h3>";
			echo "<p><b>$date</b></p>";
			echo "<p style=\"white-space: normal;\">$description</p>";
			echo "</a>";
			echo "</li>";
		}
	}?>
</ul>

</div>