$(document).on("pageshow", "#bus", function() {
	$("#bus_form").validate({
		submitHandler: function(form) {
			//$('#bus_popup').popup();
			$.mobile.showPageLoadingMsg();
			$args  =  "stop="+$('#stop').val();
			$args += "&bytime="+$('input[name=bus_sort]:checked', '#form_bus').val();
			jQuery.ajax({
	      		type: "POST",
				url: "submit_bus.php",
				data: $args,
				dataType: "html",
				success: function(result) {
					//submitState(true);
					$.mobile.hidePageLoadingMsg();
					if (result.substr(0,6) == "ERROR:") {
						// Error in results
						listError('#bus_list', result.substr(6));
					} else {
						// Good results - create and show list
						if ($('input[name=bus_sort]:checked', '#bus_form').val() == 1) {
							listBusResults_Time("#bus_list",result);
						} else {
							listBusResults_Route("#bus_list",result);
						}
					}
				},
				error: function(e){
					$.mobile.hidePageLoadingMsg();
					alert('Error: ' + e);
				} 
			});	
		}
	});

});

function listBusResults_Route (div, json) {
	var results = jQuery.parseJSON(json);
	var str = "";
	var lastRoute = "";
	$(div).html("");
	for (entry in results) {
		if (results[entry]['Route_short_name'] != lastRoute) {
			str += '<li data-role="list-divider">' + results[entry]['Route_short_name'] + ' - ' + results[entry]['Route_long_name'] + '</li>';
			lastRoute = results[entry]['Route_short_name'];
		}
		str += '<li>' + results[entry]['Arrival_time'] + '</li>';
	}
	$(div).html(str);
	$(div).listview('refresh');
}

function listBusResults_Time (div, json) {
	var results = jQuery.parseJSON(json);
	$(div).html("");
	var str = '<li data-role="divider">Results</li>';
	for (entry in results) {
		str += '<li>';
		str += '<h3>' + entry['Arrival_time'] + '</h3>';
		str += '<p>Arrival at: ' + entry['Route_short_name'] + ' - ' + entry['Route_long_name'] + '</p>';
		str += '</li>';
	}
	$(div).html(str);
	$(div).listview('refresh');
	alert(str);
}

function listError (div, reason) {
	var str = '<li data-role="divider">Error</li>';
	str += '<li>' + reason + '</li>';
	$(div).html(str);
	$(div).listview('refresh');
}

function submitState (submitted) {
	var removeClasses = 'ui-bar-a ui-bar-b ui-bar-c ui-bar-d ui-bar-e ui-btn-up-a ui-btn-up-b ui-btn-up-c ui-btn-up-d ui-btn-up-e';
	$theme = submitted ? 'e' : 'a';
	$text = submitted ? 'Submitted' : 'HSR Stats';
	$.mobile.activePage.children('.ui-header').attr('data-theme', $theme).removeClass(removeClasses).addClass('ui-bar-' + $theme).children('h1').text($text);
	$.mobile.activePage.children('.ui-header').children(submitted ? 'a' : 'e').removeClass(removeClasses).addClass('ui-btn-up-' + $theme);
	$('#stop').textinput(submitted ? 'disable' : 'enable');
   	submitted ? $('#bus_submit').attr('disabled', 'disabled') : $('#submit').removeAttr('disabled');
	$('#bus_submit').button('refresh');
};