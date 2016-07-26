<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="soporte" />

	<title>Untitled 1</title>
    <style type="text/css">
<!--
@import url("style.css");
-->
</style>

    <script src="//maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAjU0EJWnWPMv7oQ-jjS7dYxSsTL4WIgxhMZ0ZK_kHjwHeQuOD4xTleBgIVef5LoERpQKGHQ2tZsmlwQ"
      type="text/javascript"></script>
      
      <script type="text/javascript">
     
 var dirMap;    
function initialize() {

if (GBrowserIsCompatible()) {

 
	 dirMap = new GMap2(document.getElementById("map"));
        dirMap.setCenter(new GLatLng( -34.603365,-58.379416), 13);
        dirMap.addControl(new GLargeMapControl());
        dirMap.addControl(new GMapTypeControl());
        dirMap.enableScrollWheelZoom();
   // ajaxFunction('procesoRuta.php?pFun=1');
	

}
else {
  alert("Sorry, the Google Maps API is not compatible with this browser");
}

}


function cargoVariablesFiltro() 


{
    
    var vMovil = document.getElementById("ftrMov").value;
    var vFecha = document.getElementById("ftrFec").value;
    var vHoraDesde = document.getElementById("ftrHoraD").value;
    var vHoraHasta = document.getElementById("ftrHoraH").value;
    
    if (vFecha == '') 
    {
        alert('Debe ingresar la fecha del recorrido que quiere buscar.')
        
    }
    
    ajaxFunction2('ajaxcall.php?mov='+vMovil+'&fecha='+vFecha+'&horaD='+vHoraDesde+'&horaH='+vHoraHasta);
    
    
}


function ajaxFunction2(url){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
    
    
    
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
	   
	    
		if(ajaxRequest.readyState == 4){
		  
         
          
         document.getElementById("regs").innerHTML=ajaxRequest.responseText;
          
          
        }     
    }                             

    ajaxRequest.open("GET", url, true);
    ajaxRequest.send(null);
}











function ajaxFunction(url){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
    
    
    
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
	   
	    var dirMap = new GMap2(document.getElementById("map"));
		if(ajaxRequest.readyState == 4){
		  
           var rta = ajaxRequest.responseText.split("^");
          
          if (rta[0] == 1) {
          
		   var cnt = 0;
           var cen = 0;
           var arrayWP = new Array();
           
           for (var i = 0; i<(rta.length) -1; i++)
           
           {
            
            var reg = rta[i].split("$");
            var lat = reg[0];
            var lng = reg[1];

            if (cnt == 24) {
                
                var marker = new GMarker(arrayWP[1]);
            	dirMap.addOverlay(marker);
                if (cen == 0) {
            	   dirMap.setCenter(arrayWP[0], 12);
                   cen = 1;
                }
                
            	dirMap.setUIToDefault();
            	directions = new GDirections(dirMap);
            	directions.loadFromWaypoints(arrayWP);
                
                arrayWP = new Array();  
                arrayWP[0] = new GLatLng(lat,lng);
                cnt = 1;
                
            }
            else
            {
                arrayWP[cnt] = new GLatLng(lat,lng);
                cnt++;
            }
            
           }
          
           if (arrayWP.length > 0) {
               // alert(arrayWP.length);
                var marker = new GMarker(arrayWP[1]);
            	dirMap.addOverlay(marker);
                if (cen == 0) {
            	   dirMap.setCenter(arrayWP[0], 12);
                   cen = 1;
                }
            	dirMap.setUIToDefault();

            	directions = new GDirections(dirMap);
            	directions.loadFromWaypoints(arrayWP);
           }
          }
          
          if (rta[0] == 2)
          {
            divResultado.innerHTML = ajax.responseText;
            //document.getElementById("filaMov").innerHTML=rta[1];
          }
          
          
        }     
    }                             

    ajaxRequest.open("GET", url, true);
    ajaxRequest.send(null);
}


</script>

</head>

<body onload="initialize()">
<div id="map" style="width: 750px; height: 400px; position: absolute; top: 50px; left:50px;"></div>

<table  id="gradient-style" summary="Meeting Results">

<thead>
    	<tr>
     
        	<th scope="col"><input type="text" id="ftrMov" name="ftrMov" size="5px"></input></th>
            <th scope="col"><input type="text" id="ftrFec" name="ftrFecha" size="5px"></input></th>
            <th scope="col"><input type="text" id="ftrHoraD" name="ftrHoraD" size="5px"></input></th>
            <th scope="col"><input type="text" id="ftrHoraH" name="ftrHoraH" size="5px"></input></th>
            <th scope="col"></th>
            <th scope="col"><input id="botonFiltro" type="button"  onclick="cargoVariablesFiltro()"  value="FILTRAR" /></th>
            
        </tr>
    </thead>


    <thead>
    	<tr>
     
        	<th scope="col">Movil</th>
            <th scope="col">Latitud</th>
            <th scope="col">Longitud</th>
            <th scope="col">Hora Hasta</th>
            <th scope="col">ID</th>
            <th scope="col"></th>
            
            
        </tr>
    </thead>
    <tfoot>
    	<tr>
        	<td colspan="6">Haga click en un pol&iacute;gono para visualizarlo en el mapa.</td>
        </tr>
    </tfoot>
    <tbody id="regs">
  
       
    </tbody>
    
</table>




</body>
</html>