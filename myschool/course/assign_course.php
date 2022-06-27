<?php
// This file is part of Newwaves Integrator Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     assign_course
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



require_once(__DIR__.'/../../../../config.php');
require_login();

require_once($CFG->dirroot.'/local/newwaves/classes/teacher.php');
require_once($CFG->dirroot.'/local/newwaves/classes/course.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/classes/form/assign_course.php');
require_once($CFG->dirroot.'/local/newwaves/classes/enrolment.php');
require_once($CFG->dirroot.'/local/newwaves/classes/school.php');
require_once($CFG->dirroot.'/local/newwaves/classes/assigncourse.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');



global $DB, $USER;

$PAGE->set_url(new moodle_url('/local/newwaves/myschool/course/assign_course.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Assign Course');
//$PAGE->set_heading('Course Information');

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('myschoolcourseassigncourse','local_newwaves'), new moodle_url('/local/newwaves/myschool/course/assign_course.php'));



// get records of teachers in the current school
$teacherObj = new Teacher();
$getSchoolTeachers = $teacherObj->getTeachersBySchool($DB, $_SESSION['schoolid']);



// check for theCourseId
$theCourseId = '';
if (!isset($_GET['c']) || $_GET['c']==''){
    $theCourseId = $_SESSION['course_id'];
}else{
    $_GET_URL_course_id = explode("-",htmlspecialchars(strip_tags($_GET['c'])));
    $_GET_URL_course_id = $_GET_URL_course_id[1];

    $theCourseId = $_GET_URL_course_id;
}


// check for theMdlCourseId
$theMdlCourseId = '';
if (!isset($_GET['m']) || $_GET['m']==''){
    $theMdlCourseId = $_SESSION['mdl_course_id'];
}else{
    $_GET_URL_mdl_course_id = explode("-",htmlspecialchars(strip_tags($_GET['m'])));
    $_GET_URL_mdl_course_id = $_GET_URL_mdl_course_id[1];

    $theMdlCourseId = $_GET_URL_mdl_course_id;
}


// get courseEnrolmentId
$courseEnrolmentId = Enrolment::getEnrolmentByCourse($DB, $theMdlCourseId);



$teachersData = array();
$teachersData[0] = '-- Select Teacher ---';
foreach($getSchoolTeachers as $row){
  $staffId = '';
  if ($row->uuid !=''){
      $staffId = " ({$row->uuid}) ";
  }

  // check if user is already registered in for this course
  $isAssigned = CourseAssignment::isCourseAssignedToTeacher($DB, $row->mdl_userid, $courseEnrolmentId);


  if (!$isAssigned){
    $index = $row->mdl_userid;
    $teachersData[$index] = $row->surname.' '.$row->firstname.$staffId;
  }

}

$to_form = array('my_array'=>$teachersData);
$mform = new assignCourse(null, $to_form);
if($mform->is_cancelled()){

}else if($fromform = $mform->get_data()){


            if ($fromform->teacher_id !=0){

                       $courseEnrolmentId = Enrolment::getEnrolmentByCourse($DB, $fromform->mdl_course_id);

                       $enrolment = new stdClass();
                       $enrolment->status = 0;
                       $enrolment->enrolid = $courseEnrolmentId;
                       $enrolment->userid = $fromform->teacher_id;
                       $enrolment->timestart = time();
                       $enrolment->timeend = 0;
                       $enrolment->modifierid = 2;
                       $enrolment->timecreated = time();
                       $enrolment->timemodified = time();


                       $DB->insert_record('user_enrolments', $enrolment);



                      $assign_course_href = "assign_course.php?q=".mask($fromform->school_id)."&c=".mask($fromform->course_id)."&m=".mask($fromform->mdl_course_id);
                      redirect($CFG->wwwroot."/local/newwaves/myschool/course/{$assign_course_href}", 'The selected Teacher has been assigned to this course.', null, \core\output\notification::NOTIFY_SUCCESS);



            }else{
                      $assign_course_href = "assign_course.php?q=".mask($fromform->school_id)."&c=".mask($fromform->course_id)."&m=".mask($fromform->mdl_course_id);
                      redirect($CFG->wwwroot."/local/newwaves/myschool/course/{$assign_course_href}", 'No Teacher has been selected. Please select a Teacher.', null, \core\output\notification::NOTIFY_ERROR);
            }



}else{

            //************************* Check page accessibility *********************************************************
            // Check and Get School Id from URL if set

            if (!isset($_GET['q']) || $_GET['q']==''){
                redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Enrolment page");
            }else{
                $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
                $_GET_URL_school_id = $_GET_URL_school_id[1];
            }


            if (!isset($_GET['c']) || $_GET['c']==''){
                redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Enrolment page");
            }else{

                $_GET_URL_course_id = explode("-",htmlspecialchars(strip_tags($_GET['c'])));
                $_GET_URL_course_id = $_GET_URL_course_id[1];

                // put this course into session  for postback purpose
                $_SESSION['course_id'] = $_GET_URL_course_id;
            }



            if (!isset($_GET['m']) || $_GET['m']==''){
                redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Enrolment page");
            }else{

                $_GET_URL_mdl_course_id = explode("-",htmlspecialchars(strip_tags($_GET['m'])));
                $_GET_URL_mdl_course_id = $_GET_URL_mdl_course_id[1];

                // put this course into session for postback purpose
                $_SESSION['mdl_course_id'] = $_GET_URL_mdl_course_id;
            }


            // Check user accessibility status using role
            if (!isset($_SESSION['schoolid']) || $_SESSION['schoolid']==''){
                // if Session Variable Schoolid is not set, redirect from page
                redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Course Enrolment page");
            }


            // check if the page URL and the session variable are not the same
            if($_SESSION['schoolid']!=$_GET_URL_school_id){
                redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Course Enrolment page");
            }

            //************************ End of Check page accessibility *****************************************************







}



// get course name
$clCourse = new Course();
$getCourse = $clCourse->getNESCourseBySchoolAndCourse($DB, $_GET_URL_school_id, $_GET_URL_course_id);
//$getCourse = $clCourse->getMdlCourseBySchoolAndCourse($DB, $_GET_URL_school_id, $_GET_URL_course_id);

$courseName = '';
foreach($getCourse as $row){
     $courseName = $row->full_name;
}





//get MySchool Name
$getMySchoolName = School::getName($DB, $_SESSION['schoolid']);



echo $OUTPUT->header();
echo "<h2>{$getMySchoolName}<br/><small>{$courseName}</small></h2>";
echo "<hr/>";




echo "<h4 class='mt-5 mb-3'>Assign Teacher to Course</h4>";
//form
echo "<div class='border rounded' style='padding-top:20px;'>";


$mform->set_data(["school_id"=>$_GET_URL_school_id,"course_id"=>$_GET_URL_course_id, "mdl_course_id"=>$_GET_URL_mdl_course_id]);
$mform->display();

//$formLink = "enrol_students.php?q=".mask($_GET_URL_school_id)."&c=".mask($_GET_URL_course_id);



echo "</div>"

?>







<?php
// display table
// uuid, surname, firstname, middlename,


echo "<div class='mb-5' style='margin-top:50px;'><h4>Teachers Assigned to Course</h4></div>";
echo "<table class='table table-stripped border' id='tblData'>";
echo "<thead>";
echo "<tr class='font-weight-bold' >";
     echo "<th class='py-3'>SN</th><th>Staff ID</th><th>Surname</th><th>Firstname</th><th>Middlename</th><th class='text-center'>Action</th></tr>";
echo "</thead>";
echo "<tbody>";

     $courseAssigned = new CourseAssignment();
     $getTeachersAssigned = $courseAssigned->getTeachersAssignedBySchoolAndCourse($DB, $_GET_URL_school_id,$courseEnrolmentId);

     $sn = 1;
     foreach($getTeachersAssigned as $row){
          $btnAssigned =  "<button class='btn-primary btn-sm rounded'>Unassigned</button>";
          echo "<tr>";
              echo "<td>{$sn}.</td>";
              echo "<td>{$row->uuid}</td>";
              echo "<td>{$row->surname}</td>";
              echo "<td>{$row->firstname}</td>";
              echo "<td>{$row->middlename}</td>";
              echo "<td class='text-center'>{$btnAssigned}</td>";
              $sn++;
          echo "</tr>";
     }

echo "</tbody>";
echo "</table>";





  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
?>
<script>
    $(document).ready(function(){

    });
</script>
