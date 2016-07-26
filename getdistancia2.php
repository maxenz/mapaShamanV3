<html>
<head>
<title></title>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">

  $(document).ready(function() {
            buscoDire();
        });

var start,end;

function calculateRoute() {
         		 
    var directionsService = new google.maps.DirectionsService();
            
    var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };

    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            var distance = response.routes[0].legs[0].distance.value / 1000;
            
			var time = response.routes[0].legs[0].duration.text;
			
			
			document.cookie ='varDistancia='+distance+'; expires=Thu, 2 Aug 2021 20:47:11 UTC; path=/';
            document.cookie ='varTiempo='+time+'; expires=Thu, 2 Aug 2021 20:47:11 UTC; path=/';
			
			
			
        }
		
    });
}                   

 function buscoDire() {
         
     		var latMovil = GetURLParameter('latMov');
			var longMovil = GetURLParameter('longMov');
			var latDst = GetURLParameter('latDst');
			var longDst = GetURLParameter('longDst');
            var latlongMovil = latMovil + ',' + longMovil;
			var latlongDst = latDst + ',' + longDst;		  
            
            var geocoder = new google.maps.Geocoder();
           
            geocoder.geocode({ 'address': latlongMovil}, geocodeResultStart);
			
			
        }

        function geocodeResultStart(results, status) {
            
            if (status == 'OK') {
				var latDst = GetURLParameter('latDst');
				var longDst = GetURLParameter('longDst');
				var latlongDst = latDst + ',' + longDst;	
                var geocoder = new google.maps.Geocoder();
                start = results[0].formatted_address;	
                geocoder.geocode({ 'address': latlongDst } , geocodeResultEnd);         
            }
        }
		
		function geocodeResultEnd(results, status) {
            
            if (status == 'OK') {
                
                end = results[0].formatted_address;
				calculateRoute();
                          
            } 
        }				

  function GetURLParameter(sParam) {
            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam) {
                    return sParameterName[1];
                }
            }

        }    

</script>
</head>
<body>
<?php
$distancia = $_COOKIE["varDistancia"];
$tiempo = $_COOKIE["varTiempo"];
echo $distancia.'/'.$tiempo;
?>
</body>
</html>

