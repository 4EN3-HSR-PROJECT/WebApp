<!--
	This file is only part of a full html page and is to be
	included in another page (via php include, etc.) in order
	to provide full functionality.
-->


<?php include 'bulletin/contents.php' ?>


<ul data-role="listview" data-inset="true" name="bulletin" id="bulletin" data-theme="c">
	<li data-role="list-divider">Announcements</li>
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