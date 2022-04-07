<?php

  class Student{

      private $studentId;
      private $sqlQuery;


      public function __construct(){
          $this->sqlQuery = null;
      }

      public function getStudentProfileById($DB, $studentId){
          $this->studentId = $studentId;

          $this->sqlQuery = "Select u.id, u.schoolid, u.uuid, u.surname, u.firstname, u.middlename, u.gender, u.email,
                             u.phone, s.name, c.class from {newwaves_schools_users} u left join {newwaves_schools} s on
                             u.schoolid=s.id left join {newwaves_schools_students} c on u.uuid=c.admission_no
                             where u.id={$this->studentId}";
          $studentData = $DB->get_records_sql($this->sqlQuery);
          return $studentData;
      }

      public function getStudentInfoBySchoolAndAdmissionNo($DB, $schoolId, $admission_no){
          
      }


  }


?>
