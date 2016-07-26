<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            buscoLatLong();
        });
				
        function buscoLatLong() {
            var calle = GetURLParameter('calle');
            var altura = GetURLParameter('altura');
            var loc = GetURLParameter('loc');
            var part = GetURLParameter('part');
            var prov = GetURLParameter('prov');
            var pais = GetURLParameter('pais');
         
            var address = calle + ' ' + altura + ' ,' + loc + ' ,' + part + ' ,' + prov + ', ' + pais ;
      
            var geocoder = new google.maps.Geocoder();
  			
            geocoder.geocode({ 'address': address }, geocodeResult);
        }

        function geocodeResult(results, status) {
           
            if (status == 'OK') {             

                var latitud = results[0].geometry.location.lat();
                var longitud = results[0].geometry.location.lng();
				$('#latitud').text(latitud);
				$('#longitud').text(longitud);
			
                
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

<div id="latitud"></div>
<div id="longitud"></div>

</body>
</html>