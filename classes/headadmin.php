<?php

  class HeadAdmin{

      private $headadminId;
      private $sqlQuery;


      public function __construct(){
          $this->sqlQuery = null;
      }

      public function getHeadAdminProfileById($DB, $headadminId){
          $this->headadminId = $headadminId;

          $this->sqlQuery = "Select u.id, u.schoolid, u.uuid, u.surname, u.firstname, u.middlename, u.gender, u.email,
                             u.phone, s.name from {newwaves_schools_users} u left join {newwaves_schools} s on
                             u.schoolid=s.id
                             where u.id={$this->headadminId}";
          $headadminData = $DB->get_records_sql($this->sqlQuery);
          return $headadminData;
      }



  }


?>
