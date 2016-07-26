<?php

    include('procesoMovilZonas.php');

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
    <title>Grupo Paramedic</title>
</head>
<body>
    <script>
        var w = '<?php echo $width; ?>';
        var h = '<?php echo $height; ?>';
        document.write('<div id="map" style="width:'+w+'px ; height:'+h+'px; margin-top:-15px; margin-left:-9px; overflow:hidden;">');
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
    <script>
		var latlng = new google.maps.LatLng(-34.607497,-58.381742);
        var polyPoints2 = [];
        var arrPol = new Array();
		var myOptions = {
			zoom: 11,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		var map = new google.maps.Map(document.getElementById("map"),myOptions);

        var resultadoParseo = '<?php echo $strPol  ?>';

        var vecPoligonosZonas = resultadoParseo.split("#");

        for (var i = 0; i < vecPoligonosZonas.length; i++) {

            var vecRegPol = [];
            var colorFill = "";

            var vecFirst = vecPoligonosZonas[i].split("/");
            if (vecFirst != "" ) {

                var tipCob = parseInt(vecFirst[0]);
                vecRegPol = vecFirst[1].split("|");

                if (tipCob == 0) {
                    colorFill = "#FF0000";
                } else {
                    colorFill = "#2ecc71";
                }

                drawPolygons(vecRegPol,colorFill,colorFill);
            }                
        }


        function drawPolygons(vecRegPol,color1,color2) {

            arrPol = [];

            for (var k = 0; k<vecRegPol.length; k++) {
                   
                var vecCmpPol = vecRegPol[k].split("$");
                var lat = (vecCmpPol[0]);
                lat = lat.replace(",",".");
                lat = parseFloat(lat);
                var lng = (vecCmpPol[1]);
                lng = lng.replace(",",".");
                lng = parseFloat(lng);
                var point = new google.maps.LatLng(lat,lng);
                arrPol.push(point);

            }


            polyPoints2.push(new google.maps.Polygon({
                paths: arrPol,
                strokeColor: color1,
                strokeOpacity: 0.8,
                strokeWeight: 1,
                fillColor: color2,
                fillOpacity: 0.35
            }));

            polyPoints2[polyPoints2.length-1].setMap(map);
        
        } 

    </script>
</body>

</html>