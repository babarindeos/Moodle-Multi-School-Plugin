<?php

  function acadclass($option){

    $acadclass = '';

    switch($option){
        case 1:
            $acadclass = "Basic 3";
            break;
        case 2:
            $acadclass = "Basic 4";
            break;
        case 3:
            $acadclass = "Basic 5";
            break;
        case 4:
            $acadclass = "Basic 6";
            break;
        case 5:
            $acadclass = "JSS 1";
            break;
        case 6:
            $acadclass = "JSS 2";
            break;
        case 7:
            $acadclass = "JSS 3";
            break;
        case 8:
            $acadclass = "SSS 1";
            break;
        case 9:
            $acadclass = "SSS 2";
            break;
        case 10:
            $acadclass = "SSS 3";
            break;
        case 11:
            $acadclass = "Not Applicable";
            break;
    }

      return $acadclass;
  }


?>
