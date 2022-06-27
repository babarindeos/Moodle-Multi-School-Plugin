<?php
class Teacher{

    private $teacherId;
    private $sqlQuery;

    public function __construct(){
        $this->sqlQuery = null;
    }

    public function getTeacherProfileById($DB, $teacherId){
        $this->teacherId = $teacherId;

        $this->sqlQuery = "Select u.id, u.schoolid, u.uuid, u.surname, u.firstname, u.middlename, u.gender, u.email,
                           u.phone, s.name from {newwaves_schools_users} u left join {newwaves_schools} s on
                           u.schoolid=s.id where u.id={$this->teacherId}";
        $teacherData = $DB->get_records_sql($this->sqlQuery);
        return $teacherData;
    }


    public function getTeachersBySchool($DB, $schoolId){
        $this->schoolId = $schoolId;
        $this->role = "teacher";

        $this->sqlQuery = "Select id, mdl_userid, title, surname, firstname, middlename, gender, role, photo, status,
                           mdl_userid, bvn, uuid, schoolid, timecreated, timemodified from {newwaves_schools_users} where
                           schoolid={$this->schoolId} and role='{$this->role}' order by surname, firstname, middlename, uuid desc ";

        $studentData = $DB->get_records_sql($this->sqlQuery);
        return $studentData;
    }



}


?>
