<?php
    class Transfer{

        private $sqlQuery;

        public function __construct(){
            $this->sqlQuery = null;
        }

        public function searchUser($DB, $email){
            $this->sqlQuery = "Select u.id, u.schoolid, u.uuid, u.surname, u.firstname, u.middlename, u.gender, u.email,
                               u.phone, u.role, s.name from {newwaves_schools_users} u left join {newwaves_schools} s on
                               u.schoolid=s.id where u.email='{$email}'";
            $getUser = $DB->get_records_sql($this->sqlQuery);
            return $getUser;
        }
    }
 ?>
