<!DOCTYPE html>
<html>
<head>

  <meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  <style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
  </style>
  <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
  <script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/infobox/src/infobox.js"></script>

  <script type="text/javascript">
  function obtP( name ){
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp ( regexS );
    var tmpURL = window.location.href;
    var results = regex.exec( tmpURL );
    if( results == null ) {
      return "";
    }
    else {
      return results[1];
    }
  }
  </script>


</head>
<body onUnload="Save()">
  <script type="text/javascript">
  var ib;

  var paramH = obtP( 'H' );
  var paramW = obtP( 'W' );
  document.write('<div id="map" style="width:'+paramW+'px ; height:'+paramH+'px; margin-top:-15px; margin-left:-9px; overflow:hidden;"></div>');

  var gmarkers = [];
  var i = 0;
  var latlng = new google.maps.LatLng(-34.603365,-58.379416);

  var myOptions = {
    zoom: 11,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById("map"),myOptions);
  var gmarkers = [];


  function setMarkers(imagen,shadow,iconSizeW,iconSizeH,shadowSizeW,shadowSizeH,iconAnchorX,iconAnchorY,infoWindowAnchorX,infoWindowAnchorY,leyenda,point) {

    var image = new google.maps.MarkerImage(imagen,

      new google.maps.Size(20, 32),

      new google.maps.Point(0,0),

      new google.maps.Point(0, 32));

      var shadow = new google.maps.MarkerImage(shadow,
        new google.maps.Size(37, 32),
        new google.maps.Point(0,0),
        new google.maps.Point(0, 32));

        var shape = {
          coord: [1, 1, 1, 20, 18, 20, 18 , 1],
          type: 'poly'
        };


        var myLatLng = point;
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          shadow: shadow,
          icon: image,
          shape: shape,
          title: leyenda,
          zIndex: 1
        });



        var boxText = document.createElement("div");
        boxText.style.cssText = "border: 2px solid black; margin-top: 8px; background: white; text-align:center ;font-weight:bold; height:50px; padding: 5px;";
        boxText.innerHTML = leyenda;

        var myOptions = {
          content: boxText
          ,disableAutoPan: false
          ,maxWidth: 0
          ,pixelOffset: new google.maps.Size(-140, 0)
          ,zIndex: null
          ,boxStyle: {
            opacity: 0.75
            ,width: "280px"
          }
          ,closeBoxMargin: "10px 2px 2px 2px"
          ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
          ,infoBoxClearance: new google.maps.Size(1, 1)
          ,isHidden: false
          ,pane: "floatPane"
          ,enableEventPropagation: false
        };

        google.maps.event.addListener(marker, "click", function(event) {

          if (ib == undefined) {

            ib = new InfoBox(myOptions);
            ib.open(map,this);

          } else {

            ib.close();
            ib = new InfoBox(myOptions);
            ib.open(map,this);

          }

        });
      }

      function Save() {
        var mapzoom=map.getZoom();
        var mapcenter=map.getCenter();
        var maplat=mapcenter.lat();
        var maplng=mapcenter.lng();
        var cookiestring=maplat+"_"+maplng+"_"+mapzoom;
        var exp = new Date();
        exp.setTime(exp.getTime() + (1000 * 60 * 60 * 24 * 30));
        setCookie("mapShaman",cookiestring, exp);
      }

      function setCookie(name, value, expires)
      {
        document.cookie = name + "=" + escape(value) + "; path=/" + ((expires == null) ? "" : "; expires=" + expires.toGMTString());
      }

      function getCookie(c_name) {
        if (document.cookie.length>0) {
          c_start=document.cookie.indexOf(c_name + "=");
          if (c_start!=-1) {
            c_start=c_start + c_name.length + 1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) {
              c_end=document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start,c_end));
          }
        }
        return "";
      }

      function readMap() {

        var loadedstring=getCookie("mapShaman");
        var zoom = 11;

        if (loadedstring != null)
        {
          var splitstr = loadedstring.split("_");
          if (parseFloat(splitstr[2]) != NaN)
          {
            zoom  = parseFloat(splitstr[2]);
          }
        }

        <?php

        $conn=odbc_connect('phpODBC','_SYSTEM','sys');

        if (!$conn)
        {
          exit("Connection Failed: " . $conn);
        }
        $pId = $_GET["PID"];
        $query = "SELECT Latitud,Longitud,Leyenda,imagen, shadow, iconSizeW, iconSizeH,
        shadowSizeW, shadowSizeH, iconAnchorX, iconAnchorY, infoWindowAnchorX, infoWindowAnchorY, flgCenter
        from Temp.TmpGpShaman as tmp
        INNER JOIN CompuMap.GoogleIconos as icon on (tmp.GoogleIconoId = icon.ID) WHERE PID=".$pId;

        $result = odbc_exec($conn,$query);
        if (!$result) {
          exit("Error in SQL");
        }

        while (odbc_fetch_row($result)){
          $lat =	odbc_result($result,'Latitud');
          $lng =  odbc_result($result,'Longitud');
          $leyenda =  odbc_result($result,'Leyenda');
          $imagen =  odbc_result($result,'imagen');
          $shadow =  odbc_result($result,'shadow');
          $iconSizeW =  odbc_result($result,'iconSizeW');
          $iconSizeH =  odbc_result($result,'iconSizeH');
          $shadowSizeW =  odbc_result($result,'shadowSizeW');
          $shadowSizeH =  odbc_result($result,'shadowSizeH');
          $iconAnchorX =  odbc_result($result,'iconAnchorX');
          $iconAnchorY =  odbc_result($result,'iconAnchorY');
          $infoWindowAnchorX =  odbc_result($result,'infoWindowAnchorX');
          $infoWindowAnchorY =  odbc_result($result,'infoWindowAnchorY');
          $flgCenter = odbc_result($result,'flgCenter');

          ?>

          var lat = <?php echo $lat;?>;
          var lng = <?php echo $lng;?>;
          var leyenda = '<?php echo $leyenda;?>';
          var imagen = '<?php echo $imagen;?>';
          var shadow = '<?php echo $shadow;?>';
          var iconSizeW = <?php echo $iconSizeW;?>;
          var iconSizeH = <?php echo $iconSizeH;?>;
          var shadowSizeW = <?php echo $shadowSizeW;?>;
          var shadowSizeH = <?php echo $shadowSizeH;?>;
          var iconAnchorX = <?php echo $iconAnchorX;?>;
          var iconAnchorY = <?php echo $iconAnchorY;?>;
          var infoWindowAnchorX = <?php echo $infoWindowAnchorX;?>;
          var infoWindowAnchorY = <?php echo $infoWindowAnchorY;?>;
          var flgCenter = <?php echo $flgCenter;?>;
          if (flgCenter === 1) {

            if (splitstr[2] === NaN) {

              splitstr[2] = 11;
            }

            map.setCenter(new google.maps.LatLng(lat,lng));
            map.setZoom(zoom);

          }


          var point = new google.maps.LatLng(lat,lng);

          setMarkers(imagen,shadow,iconSizeW,iconSizeH,shadowSizeW,shadowSizeH,iconAnchorX,
            iconAnchorY,infoWindowAnchorX,infoWindowAnchorY,leyenda,point);


            <?php
          }


          ?>


        }

        </script>
        <script type="text/javascript">

        readMap();
        </script>

      </body>
      </html>
