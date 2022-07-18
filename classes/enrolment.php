<?php

  class Enrolment{

      private $sqlQuery;

      public static function getEnrolmentByCourse($DB, $courseId){

          $sqlQuery = "Select * from {enrol} where courseid={$courseId}";
          $studentData = $DB->get_records_sql($sqlQuery);

          $enrolmentId = '';

          foreach($studentData as $row){
              $enrolmentId = $row->id;
          }
          return $enrolmentId;
      }

      public static function isStudentEnrolledIntoCourse($DB, $mdl_userid, $enrolmentId){

          $sqlQuery = "Select count(id) as icount from {user_enrolments} where enrolid={$enrolmentId} and userid={$mdl_userid}";

          $enrolmentData = $DB->get_records_sql($sqlQuery);
          $isEnrolled = '';
          foreach($enrolmentData as $row){
              $isEnrolled = $row->icount;
          }
          return $isEnrolled;
      }


      public function getEnrolledStudentsBySchoolAndCourse($DB, $schoolid, $courseEnrolmentId){
          $sqlQuery = "Select nw.id, nw.mdl_userid, nw.uuid, nw.surname, nw.firstname, nw.middlename from {newwaves_schools_users} nw inner
                       join {user_enrolments} en on nw.mdl_userid=en.userid where nw.schoolid={$schoolid} and en.enrolid={$courseEnrolmentId}
                       and nw.role='student'";

          $studentsEnrolled = $DB->get_records_sql($sqlQuery);
          return $studentsEnrolled;
      }

      public function getCoursesEnrolledforStudent($DB, $studentId){
            $sqlQuery = "select ue.id, ue.enrolid, ue.userid, ue.timestart, ue.timeend, ue.modifierid, ue.timecreated,
                         ue.timemodified, e.courseid, c.fullname, c.shortname, c.summary from {user_enrolments} ue inner
                         join {enrol} e on ue.enrolid=e.id inner join {course} c on e.courseid=c.id where ue.userid={$studentId}";
            $courses = $DB->get_records_sql($sqlQuery);
            return $courses;
      }

  }




?>
