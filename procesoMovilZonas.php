<?php 

    $idMov = $_GET["Mov"];
    $height = $_GET["H"];
    $width = $_GET["W"];

    $conn=odbc_connect('phpODBC','_SYSTEM','sys');

    if (!$conn)
    {
      exit("Connection Failed: " . $conn);
    }

      $query = "SELECT ZonificacionId,TipoCobertura FROM Emergency.MovilesZonificaciones WHERE MovilId = '" . $idMov . "'";

      $result = odbc_exec($conn,$query);
      while (odbc_fetch_row($result)) {

        $zonificaciones[] = array(
          'ZonificacionId' => odbc_result($result,"ZonificacionId"),
          'TipoCobertura' => odbc_result($result,'TipoCobertura')
        );
      }

      $strPol = "";


      for ($i = 0; $i < sizeOf($zonificaciones); $i++) {

        $strItemPol = "";

        $zonId = $zonificaciones[$i]["ZonificacionId"];
        $tipCob = $zonificaciones[$i]["TipoCobertura"];

        $query = "SELECT REPLACE(ISNULL(Latitud,0), '.', ',') AS latitud,
        REPLACE(ISNULL(Longitud,0), '.', ',') AS longitud from CompuMap.ZonificacionesCoordenadas  where ZonificacionId=".$zonId." order by childsub";

       $result = odbc_exec($conn,$query);
      
       while (odbc_fetch_row($result))
       
       {    
            $lat =  odbc_result($result,'latitud');
            $lng =  odbc_result($result,'longitud');

      if ($strItemPol == "") 
            {
                
               $strItemPol = $tipCob."/".$lat."$".$lng;
           }
            else {
                
               $strItemPol = $strItemPol."|".$lat."$".$lng;
           }
        }

        $strPol = $strPol . $strItemPol . "#";

      }

?>