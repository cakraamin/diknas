function setSiteURL() { 

	var server = window.location.host;

	window.site = "http://"+server+"/diknas/"; 

} 



$(document).ready( function() {

	setSiteURL();

});