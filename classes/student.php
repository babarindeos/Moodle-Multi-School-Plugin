<?php

  class Student{

      private $studentId;
      private $schoolId;
      private $sqlQuery;
      private $role;


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

      public function getStudentsBySchool($DB, $schoolId){
          $this->schoolId = $schoolId;
          $this->role = "student";

          $this->sqlQuery = "Select id, mdl_userid, title, surname, firstname, middlename, gender, role, photo, status,
                             mdl_userid, bvn, uuid, schoolid, timecreated, timemodified from {newwaves_schools_users} where
                             schoolid={$this->schoolId} and role='{$this->role}' order by surname, firstname, middlename, uuid desc ";

          $studentData = $DB->get_records_sql($this->sqlQuery);
          return $studentData;
      }

      public function getStudentsProfileBySchoolId($DB, $schoolId){
          $this->role = "student";

          $this->sqlQuery = "Select u.id, u.mdl_userid, u.schoolid, u.uuid, u.surname, u.firstname, u.middlename, u.gender, u.email,
                             u.phone, s.name, c.class from {newwaves_schools_users} u left join {newwaves_schools} s on
                             u.schoolid=s.id left join {newwaves_schools_students} c on u.uuid=c.admission_no
                             where u.schoolid={$schoolId} and u.role='{$this->role}' order by u.surname, u.firstname, u.middlename";
          $studentData = $DB->get_records_sql($this->sqlQuery);
          return $studentData;
      }




  }


?>
