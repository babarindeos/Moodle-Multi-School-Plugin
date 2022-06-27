<?php

  class CourseAssignment{

    public static function isCourseAssignedToTeacher($DB, $mdl_userid, $enrolmentId){

        $sqlQuery = "Select count(id) as icount from {user_enrolments} where enrolid={$enrolmentId} and userid={$mdl_userid}";

        $enrolmentData = $DB->get_records_sql($sqlQuery);
        $isEnrolled = '';
        foreach($enrolmentData as $row){
            $isEnrolled = $row->icount;
        }
        return $isEnrolled;
    }

    public function getTeachersAssignedBySchoolAndCourse($DB, $schoolid, $courseEnrolmentId){
        $sqlQuery = "Select nw.id, nw.mdl_userid, nw.uuid, nw.surname, nw.firstname, nw.middlename from {newwaves_schools_users} nw inner
                     join {user_enrolments} en on nw.mdl_userid=en.userid where nw.schoolid={$schoolid} and en.enrolid={$courseEnrolmentId}
                     and nw.role='teacher'";

        $studentsEnrolled = $DB->get_records_sql($sqlQuery);
        return $studentsEnrolled;
    }
  }



?>
