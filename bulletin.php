<!--
	This file is only part of a full html page and is to be
	included in another page (via php include, etc.) in order
	to provide full functionality.
-->


<?php

$bulletin = array
(
	array(
		'title'			=>	"Blah Blah and the Blahs",
		'link'			=>	"",
		'date'			=>	"December 5, 2012",
		'description'	=>	"This event will feature Blah Blah and the Blahs, who will be performing Blah! Does that sound fun or what?"
	),
	array(
		'title'			=>	"Tim Horton's",
		'link'			=>	"",
		'date'			=>	"December 9, 2012",
		'description'	=>	"Tim Horton's if offering half-price coffee for one day only!"
	),
	array(
		'title'			=>	"Generic Event",
		'link'			=>	"",
		'date'			=>	"December 10, 2012",
		'description'	=>	"This is a description on the event. This event will feature Blah Blah and the Blahs, who will be performing Blah! Does that sound fun or what?"
	),
	array(
		'title'			=>	"Muse Comes To Copp's",
		'link'			=>	"",
		'date'			=>	"December 12, 2012",
		'description'	=>	"Muse will be playing at Copp's Colluseum on December 12. Don't miss it!"
	),
	array(
		'title'			=>	"Christmas",
		'link'			=>	"",
		'date'			=>	"December 25, 2012",
		'description'	=>	"Merry Christmas everyone!"
	),
	array(
		'title'			=>	"Boxing Day Specials",
		'link'			=>	"",
		'date'			=>	"December 26, 2012",
		'description'	=>	"Save up to 80% at Blah Blah's Department Store! Sales are for one-day only and stock is limited, so arrive early."
	)
);

?>


<ul data-role="listview" data-inset="true" name="bulletin" id="bulletin" data-theme="c">
	<li data-role="list-divider">Announcements</li>
	<?php foreach ($bulletin as $entry) {
		$title			= (isset($entry['title']))			? $entry['title']		: '';
		$link			= (isset($entry['link']))			? $entry['link']		: '';
		$date			= (isset($entry['date']))			? $entry['date']		: '';
		$description	= (isset($entry['description']))	? $entry['description']	: '';
		if (strlen($title) >= 1) {
			echo "<li>";
			echo "<a href=\"$link\">";
			echo "<h3>$title</h3>";
			echo "<p><b>$date</b></p>";
			echo "<p style=\"white-space: normal;\">$description</p>";
			echo "</a>";
			echo "</li>";
		}
	}?>
</ul>