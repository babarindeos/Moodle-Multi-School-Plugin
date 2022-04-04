<?php

function convertType($type){
    switch ($type){
        case "0":
            return "Primary School";
        case "1":
            return "Secondary School";
        case "2":
            return "College of Education";
        case "3":
            return "Polytechnic";
        case "4":
            return "University";
        default:
            return "unknown";
    }
}


?>
