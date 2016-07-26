<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAPDUET0Qt7p2VcSk6JNU1sBSM5jMcmVqUpI7aqV44cW1cEECiThQYkcZUPRJn9vy_TWxWvuLoOfSFBw" type="text/javascript"></script>

    <script type="text/javascript">
    //<![CDATA[
    
    if (GBrowserIsCompatible()) { 

    var map;
    var geo;
    var reasons=[];



    function load() {
      map = new GMap(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(20,0),2);
      
      // ====== Create a Client Geocoder ======
      geo = new GClientGeocoder(); 

      // ====== Array for decoding the failure codes ======
      reasons[G_GEO_SUCCESS]            = "Success";
      reasons[G_GEO_MISSING_ADDRESS]    = "Missing Address: The address was either missing or had no value.";
      reasons[G_GEO_UNKNOWN_ADDRESS]    = "Unknown Address:  No corresponding geographic location could be found for the specified address.";
      reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
      reasons[G_GEO_BAD_KEY]            = "Bad Key: The API key is either invalid or does not match the domain for which it was given";
      reasons[G_GEO_TOO_MANY_QUERIES]   = "Too Many Queries: The daily geocoding quota for this site has been exceeded.";
      reasons[G_GEO_SERVER_ERROR]       = "Server error: The geocoding request could not be successfully processed.";
    }


    // ===== list of words to be standardized =====
    var standards = [   ["road","rd"],   
                        ["street","st"], 
                        ["avenue","ave"], 
                        ["av","ave"], 
                        ["drive","dr"],
                        ["saint","st"], 
                        ["north","n"],   
                        ["south","s"],    
                        ["east","e"], 
                        ["west","w"],
                        ["expressway","expy"],
                        ["parkway","pkwy"],
                        ["terrace","ter"],
                        ["turnpike","tpke"],
                        ["highway","hwy"],
                        ["lane","ln"]
                     ];

    // ===== convert words to standard versions =====
    function standardize(a) {
      for (var i=0; i<standards.length; i++) {
        if (a == standards[i][0])  {a = standards[i][1];}
      }
      return a;
    }

    // ===== check if two addresses are sufficiently different =====
    function different(a,b) {
      // only interested in the bit before the first comma in the reply
      var c = b.split(",");
      b = c[0];
      // convert to lower case
      a = a.toLowerCase();
      b = b.toLowerCase();
      // remove apostrophies
      a = a.replace(/'/g ,"");
      b = b.replace(/'/g ,"");
      // replace all other punctuation with spaces
      a = a.replace(/\W/g," ");
      b = b.replace(/\W/g," ");
      // replace all multiple spaces with a single space
      a = a.replace(/\s+/g," ");
      b = b.replace(/\s+/g," ");
      // split into words
      awords = a.split(" ");
      bwords = b.split(" ");
      // perform the comparison
      var reply = false;
      for (var i=0; i<bwords.length; i++) {
        //GLog.write (standardize(awords[i])+"  "+standardize(bwords[i]))
        if (standardize(awords[i]) != standardize(bwords[i])) {reply = true}
      }
      //GLog.write(reply);
      return (reply);
    }


      // ====== Plot a marker after positive reponse to "did you mean" ======
      function place(lat,lng) {
        var point = new GLatLng(lat,lng);
        map.setCenter(point,14); 
        map.addOverlay(new GMarker(point));
        document.getElementById("message").innerHTML = "";
      }

      // ====== Geocoding ======
      function showAddress() {
        var search = document.getElementById("search").value;
        // ====== Perform the Geocoding ======        
        geo.getLocations(search, function (result)
          {
            map.clearOverlays(); 
            if (result.Status.code == G_GEO_SUCCESS) {
              // ===== If there was more than one result, "ask did you mean" on them all =====
              if (result.Placemark.length > 1) { 
                document.getElementById("message").innerHTML = "Did you mean:";
                // Loop through the results
                for (var i=0; i<result.Placemark.length; i++) {
                  var p = result.Placemark[i].Point.coordinates;
                  document.getElementById("message").innerHTML += "<br>"+(i+1)+": <a href='javascript:place(" +p[1]+","+p[0]+")'>"+ result.Placemark[i].address+"<\/a>";
                }
              }
              // ===== If there was a single marker, is the returned address significantly different =====
              else {
                document.getElementById("message").innerHTML = "";
                if (different(search, result.Placemark[0].address)) {
                  document.getElementById("message").innerHTML = "Did you mean: ";
                  var p = result.Placemark[0].Point.coordinates;
                  document.getElementById("message").innerHTML += "<a href='javascript:place(" +p[1]+","+p[0]+")'>"+ result.Placemark[0].address+"<\/a>";
                } else {
                  var p = result.Placemark[0].Point.coordinates;
                  place(p[1],p[0]);
                  document.getElementById("message").innerHTML = "Located: "+result.Placemark[0].address;
                }
              }
            }
            // ====== Decode the error status ======
            else {
              var reason="Code "+result.Status.code;
              if (reasons[result.Status.code]) {
                reason = reasons[result.Status.code]
              } 
              alert('Could not find "'+search+ '" ' + reason);
            }
          }
        );
      }
    }
    
    // display a warning if the browser was not compatible
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

    // This Javascript is based on code provided by the
    // Community Church Javascript Team
    // http://www.bisphamchurch.org.uk/   
    // http://econym.org.uk/gmap/

    //]]>
    </script>

  </head>
  <body onload="load()" onunload="GUnload()">

  
    <form onsubmit="showAddress(); return false" action="#">
      <input id="search" size="60" type="text" value="Bespham Road, Cleveleys, FY2" />
      <input type="submit" value="Go!" />
    </form>
    
    <div id="message"></div>

    <div id="map" style="width: 600px; height: 400px"></div><p>

    <a href="didyoumean.htm">Back to the tutorial page</a>

    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>

  </body>

</html>
