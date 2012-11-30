function setToolbars (tab) {
	deselectToolbars();
	$('#bus_nav_' + tab).addClass('ui-btn-active');
	$('#main_nav_' + tab).addClass('ui-btn-active');
	$('#taxi_nav_' + tab).addClass('ui-btn-active');
}

function deselectToolbars () {
	var options = ["bus","main","taxi"];
	for (page in options) {
		for (tab in options) {
			$('#'+options[page]+'_nav_'+options[tab]).removeClass('ui-btn-active');
		}
	}
}