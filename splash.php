<script>
	function endSplash() {
		$.mobile.changePage ("#main", {transition: "fade"} );
	}
	setTimeout ('endSplash()', 3000);
</script>

<div style="background: url(splash.png) black no-repeat scroll center center; background-size: contain;" id="splash" data-url="splash" data-role="page" data-theme="a">
</div>