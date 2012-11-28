$(document).on("pageshow", "#statPage", function() {

	$("#form_bus").validate({
			submitHandler: function(form) {
			$.mobile.showPageLoadingMsg();
			$args = "stop="+$('#stop').val();
			jQuery.ajax({
	      		type: "POST",
				url: "submit_bus.php",
				data: $args,
				success: function(results) {
					submitState(true);
					$.mobile.hidePageLoadingMsg();
				},
				error: function(e){  
					$.mobile.hidePageLoadingMsg();
					alert('Error: ' + e);
				} 
			});	
		}
	});

});

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