<?php

class Photo{


  public function uploadPicture()
  {
          if ($_FILES['file']['name']!='')
          {
              $fileName = $_FILES['file']['name'];
              $split_name = explode('.',$fileName);
              //echo $fileName;
              $extension = end($split_name);
              $today = date('Ymd_H_i_s');
              $name = $today.rand(100,999).'.'.$extension;
              $location = '../assets/photos/'.$name;
              $result = move_uploaded_file($_FILES['file']['tmp_name'], $location);

              $response = array('status'=>$result,'name'=>$name,'location'=>$location);

              return $response;
          }
    }

    public function removeDBAvatar($mid)
    {
        $sqlQuery = "Update members set picture='' where id=".$mid;
        $QueryExecutor = new ExecuteQuery();
        $result = $QueryExecutor::customQuery($sqlQuery);

    }



}


?>
