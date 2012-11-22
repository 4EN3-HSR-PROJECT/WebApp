function getDropdown(div,queryloc,param = "") {
	// Initialize page getters
	var sqlconnect;
	var dropdown;
	if (window.XMLHttpRequest) {
		sqlconnect = new XMLHttpRequest();
		dropdown = new XMLHttpRequest();
	} else {
		sqlconnect = new ActiveXObject("Microsoft.XMLHTTP");
		dropdown = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	// Function to be run upon sqlConenctor response
	var serialArray;
	sqlconnect.onreadystatechange = function() {
		if (sqlconnect.readyState == 4 && sqlconnect.status == 200) {
			// Send request for dropdown
			serialarray = sqlconnect.responseText;
			var address = "dropdown.php";
			var variables = "array=" + serialarray;
			if (param != "") {
				variables += "&" + param;
			}
			dropdown.open("POST",address,true);
			dropdown.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			dropdown.send(variables);
		}
	}
	
	// Function to be run upon dropdown response
	dropdown.onreadystatechange = function() {
		if (dropdown.readyState == 4 && dropdown.status == 200) {
			document.getElementById(div).innerHTML = dropdown.responseText;
			$.mobile.hidePageLoadingMsg();
		}
	}
	
	// Send request for sql array
	if (param == "") {
		sqlconnect.open("GET",queryloc,true);
	} else {
		sqlconnect.open("GET",queryloc + "?" + param,true);
	}
	$.mobile.showPageLoadingMsg();
	sqlconnect.send();
}