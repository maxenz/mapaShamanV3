<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
<title>Google Maps</title>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=AIzaSyANedW4l-dPWULss7iSwFWQPwu_4kZxP40" type="text/javascript"></script>
<script type="text/javascript">
function obtP( name ){
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp ( regexS );
	var tmpURL = window.location.href;
	var results = regex.exec( tmpURL );
	if( results == null )
		return"";
	else
		return results[1];
}
</script>

</head>

<body>


<script type="text/javascript">

document.write('<div id="map" style="width:500px ; height:500px; margin-top:-15px; margin-left:-9px; overflow:hidden;">')

//<![CDATA[


if (GBrowserIsCompatible()) {

	var gmarkers = [];
	var i = 0;

	var map = new GMap2(document.getElementById("map"));
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	map.enableScrollWheelZoom();

	/// Centrado Inicial

	var lat = -34.603365;
	var lon = -58.379416;


	map.setCenter(new GLatLng( lat, lon), 11);

	var gmarkers = [];

	function createMarker(point,icono,leyenda) {

		var marker = new GMarker(point,icono);

		GEvent.addListener(marker, "click", function() {

		marker.openInfoWindowHtml("<div id='infoMapGral'>"+leyenda+"</div>");


		});

		gmarkers[i] = marker;

		i++;
		return marker;
	}
	}


else {

	alert("Google Maps API no es compatible con este navegador.");

}

//]]>

</script>

</body>

</html>