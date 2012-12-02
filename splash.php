<script>
	function endSplash() {
		$.mobile.changePage ("#main", {transition: "fade"} );
	}
	setTimeout ('endSplash()', 5000);
</script>

<div style="background: url(bulletin/default.png) black no-repeat scroll center top;background-size: cover;" id="splash" data-url="splash" data-role="page" data-theme="a">
</div>