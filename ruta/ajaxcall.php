<?php
$movil=$_GET["mov"];

$conn=odbc_connect('phpODBC','_SYSTEM','sys');

   if (!$conn)
  {
    exit("Connection Failed: " . $conn);
    }

$query = "select TOP 20 MovilId, Latitude, Longitude from CompuMap.GpsHistorico where MovilId=".$movil;

$result = odbc_exec($conn,$query);



 while (odbc_fetch_row($result)){
        
  $lat = odbc_result($result,'Latitude');
  $lng = odbc_result($result,'Longitude');
  $mov = odbc_result($result,'MovilId');
  
  
  echo "<tr>";
  echo "<td>".$lat."</td>";
  echo "<td>".$lng."</td>";
  echo "<td>".$mov."</td>";
  echo "</tr>";
  }



?>