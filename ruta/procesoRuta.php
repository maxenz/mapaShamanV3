<?php


if (isset($_GET["pFun"]))  $pFun = $_GET["pFun"];
if (isset($_GET["mov"]))   $movil = $_GET["mov"];
if (isset($_GET["fecha"])) $fecha = $_GET["fecha"];
if (isset($_GET["horaD"])) $horaD = $_GET["horaD"];
if (isset($_GET["horaH"])) $horaH = $_GET["horaH"];

if ($pFun == 1) {

 $conn=odbc_connect('phpODBC','_SYSTEM','sys');

   if (!$conn)
  {
    exit("Connection Failed: " . $conn);
    }
    
    $strDir = "";
    $query = "select TOP 200 Latitude, Longitude from CompuMap.GpsHistorico where MovilId=14";
    
    $result = odbc_exec($conn,$query);
     while (odbc_fetch_row($result)){
        
        $lat = odbc_result($result,'Latitude');
        $lng =	odbc_result($result,'Longitude');
        
        if ($strDir == "")
        
        {
            
            $strDir = $lat."$".$lng;
            
        }
        else {
            
            $strDir = $strDir."^".$lat."$".$lng;  
            
        }
        
        
        }

 echo $pFun."^".$strDir;

}


if ($pFun == 2)

{
    
    $conn=odbc_connect('phpODBC','_SYSTEM','sys');

   if (!$conn)
  {
    exit("Connection Failed: " . $conn);
    }
    
  
    $strQuery = "";
    $query = "select MovilId,FecHorRecepcion,Latitude,Longitude from CompuMap.GpsHistorico where MovilId=".$movil;
    $result = odbc_exec($conn,$query);
    
    while (odbc_fetch_row($result)) {
        
        $mov = odbc_result($result,'MovilId');
        $fecHora = odbc_result($result,'FecHorRecepcion');
        $latitud = odbc_result($result,'Latitude');
        $longitud = odbc_result($result,'Longitude');
        
        
     echo "<tr>";
        	
      echo "<td>".$mov."</td>";
      echo "<td>".$fecHora."</td>";
      echo "<td>".$latitud."</td>";
      echo "<td>".$longitud."</td>";
            
     
            
    echo "</tr>";
        
        
        
        
       /* if ($strQuery == "") {
            
            $strQuery = $pFun."^".$mov."$".$fecHora."$".$latitud."$".$longitud;
            
        }
        
        else
        
        {
            $strQuery = $strQuery."$".$mov."$".$fecHora."$".$latitud."$".$longitud;
            
        }*/
        
    }
    
    
    
    /*if(isset($_GET["fecha"]))
    {
     var $fecha = $_GET["fecha"]; 
     $query += "  "  
    }*/
    
    
    
}


?>