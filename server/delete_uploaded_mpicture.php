<?php
    session_start();
    require_once("../classes/photo.php");
    header('Content-Type: text/html');

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
    {



        if ($_SESSION['mpicture_uploaded_name'])        {

            $location = $_SESSION['mpicture_uploaded'];
            $name = $_SESSION['mpicture_uploaded_name'];
            unlink('../assets/photos/'.$name);
            unset($_SESSION['mpicture_uploaded']);
            unset($_SESSION['mpicture_uploaded_name']);
        }

        $result = array("name"=>"tester");
        $response = json_encode($result);
        echo $response;
    }

?>
