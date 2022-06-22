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
 * @package     enrol_students
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



require_once(__DIR__.'/../../../../config.php');
require_login();

require_once($CFG->dirroot.'/local/newwaves/classes/student.php');
require_once($CFG->dirroot.'/local/newwaves/classes/course.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/classes/form/course_enrolment.php');
require_once($CFG->dirroot.'/local/newwaves/classes/school.php');


// Get School Id
if (!isset($_GET['q']) || $_GET['q']==''){
    redirect($CFG->wwwroot.'/local/newwaves/myschool/course/enrol_students.php');
}


$_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
$_GET_URL_school_id = $_GET_URL_school_id[1];



//************************* Check page accessibility *********************************************************
// Check and Get School Id from URL if set
if (!isset($_GET['c']) || $_GET['c']==''){
    redirect($CFG->wwwroot.'/local/newwaves/myschool/course/enrol_students.php', "Unathorised to access the Course Enrolment page");
}else{

    $_GET_URL_course_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_course_id = $_GET_URL_course_id[1];
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



global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/myschool/course/enrol_students.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Course Enrolment');
//$PAGE->set_heading('Course Information');

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('myschoolcourseenrolstudents','local_newwaves'), new moodle_url('/local/newwaves/myschool/course/enrol_students.php'));




// get course name
$clCourse = new Course();
$getCourse = $clCourse->getNESCourseBySchoolAndCourse($DB, $_GET_URL_school_id, $_GET_URL_course_id);

$courseName = '';
foreach($getCourse as $row){
     $courseName = $row->full_name;
}


// get records of students in the current school
$studentObj = new Student();
$getSchoolStudents = $studentObj->getStudentsBySchool($DB, $_GET_URL_school_id);

//var_dump($getSchoolStudents);

$studentsData = array();
$studentsData[0] = '-- Select Student ---';
foreach($getSchoolStudents as $row){
  $index = $row->id;
  $studentsData[$index] = $row->surname.' '.$row->firstname;
}



//get MySchool Name
$getMySchoolName = School::getName($DB, $_SESSION['schoolid']);



echo $OUTPUT->header();
echo "<h2>{$getMySchoolName}<br/><small>{$courseName}</small></h2>";
echo "<hr/>";


$to_form = array('my_array'=>$studentsData);

echo "<h5 class='mt-5 font-weight-normal'>Students Enrolment into Course</h5>";
//form


$mform = new courseEnrolment(null, $to_form);
$mform->set_data(["school_id"=>$_GET_URL_school_id,"course_id"=>$_GET_URL_course_id]);
$mform->display();


?>







<?php
// display table






  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
?>
