<?php

//require_once(__DIR__.'..\config.php');
require_once("../classes/photo.php");

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
{
    $photo = new Photo();
    $result = $photo->uploadPicture();

    //echo $result['status'];
        if ($result['status']==1)
        {   session_start();
            //@unset($_SESSION['mpicture_uploaded']);
            //@unset($_SESSION['mpicture_uploaded_name']);
            $_SESSION['mpicture_uploaded'] = $result['location'];
            $_SESSION['mpicture_uploaded_name'] = $result['name'];
        }else{

        }

        $response = json_encode($result);
        echo $response;

}

?>
