<!--
	This file is only part of a full html page and is to be
	included in another page (via php include, etc.) in order
	to provide full functionality.
-->


<?php
	require_once('simplepie_1.3.1.php');
	$feed = new SimplePie();
	$feed->enable_order_by_date();
	$feed->set_feed_url('http://www.hecfi.ca/index.php?option=com_rd_rss&id=3');
	$feed->init();
	$feed->handle_content_type();
?>


<div style="background: url(bg.jpg) black no-repeat scroll center top;background-size: cover;" id="bulletin" data-url="bulletin" data-role="page" data-theme="a">
<div data-role="header" data-position="fixed" data-id="globalnav">
	<h1>Bulletin Board</h1>
	<div data-role="navbar" name="bulletin_nav" id="bulletin_nav">
		<ul>
		<li><a href="#bus" id="bulletin_nav_bus" onClick="setToolbars('bus');">Bus</a></li>
		<li><a href="#bulletin" id="bulletin_nav_bulletin" onClick="setToolbars('bulletin');" class="ui-btn-active">Bulletin</a></li>
		<li><a href="#taxi" id="bulletin_nav_taxi" onClick="setToolbars('taxi');">Taxi</a></li>
		</ul>
	</div>
</div>


<ul data-role="listview" data-inset="true" name="bulletin" id="bulletin" data-theme="c">
	<?php foreach (array_reverse($feed->get_items()) as $item) {
		$date = strtotime($item->get_date());
		if ($date > time() - (time() % 86400)) {
			echo "<li>";
			echo "<a href=\"{$item->get_link()}\" target=\"_blank\">";
			//echo "<img src=\"$image\" />";
			echo "<h3>{$item->get_title()}</h3>";
			echo "<p><b>{$item->get_date('L F j, Y')}</b></p>";
			echo "<p style=\"white-space: normal;\">{$item->get_description()}</p>";
			echo "</a>";
			echo "</li>";
		}
	}?>
</ul>

</div>