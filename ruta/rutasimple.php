<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="soporte" />

	<title>Untitled 4</title>
<script src="//maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxSsTL4WIgxhMZ0ZK_kHjwHeQuOD4xTleBgIVef5LoERpQKGHQ2tZsmlwQ"
type="text/javascript"></script>
<script type="text/javascript">    
function initialize() {

if (GBrowserIsCompatible()) {

	var dirMap = new GMap2(document.getElementById("map"));
	var wp = new Array(4);
	wp[0] = new GLatLng(-34.626799,-58.523355);
	wp[1] = new GLatLng(-34.62408,-58.518441);
    wp[2] = new GLatLng(-34.621537,-58.521767);
    wp[3] = new GLatLng(-34.61601,-58.519878);
    
	var marker = new GMarker(wp[3]);
	dirMap.addOverlay(marker);
	dirMap.setCenter(wp[0], 12);
	dirMap.setUIToDefault();

	// load directions
	directions = new GDirections(dirMap);
	directions.loadFromWaypoints(wp);  

}
else {
  alert("Sorry, the Google Maps API is not compatible with this browser");
}

}
</script>    
</head>

<body onload="initialize()">
<div id="map" style="width: 750px; height: 400px"></div>


</body>
</html>