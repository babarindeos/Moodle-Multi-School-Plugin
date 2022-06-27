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
 * @package     create_course
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */


require_once(__DIR__.'/../../../../config.php');

// require_login for authentication pages
require_login();

require($CFG->dirroot.'/local/newwaves/classes/form/create_course.php');
require($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require($CFG->dirroot.'/local/newwaves/functions/gender.php');
require($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require($CFG->dirroot.'/local/newwaves/classes/auth.php');
require_once($CFG->dirroot.'/local/newwaves/classes/school.php');
require_once($CFG->dirroot.'/local/newwaves/classes/course.php');



global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/myschool/course/create_course.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Create Course');
//$PAGE->set_heading('Create Course');


// create page navigation at breadcrumb

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('myschoolcoursecreatecourse', 'local_newwaves'), new moodle_url('/local/newwaves/myschool/course/create_course.php'));

$to_form = array('my_array'=>array("school_id"=>$_SESSION['schoolid']));

//var_dump($to_form);

$mform = new createCourse(null, $to_form);

if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', 'No Course is created. You cancelled the operation.');

}else if($fromform = $mform->get_data()){

          //$transaction = $DB->start_delegated_transaction();

          // mdl course table
          $mdlcoursetoinsert = new stdClass();
          $mdlcoursetoinsert->category = $fromform->course_category;
          $mdlcoursetoinsert->fullname = $fromform->name;
          $mdlcoursetoinsert->shortname = $fromform->code;
          $mdlcoursetoinsert->summary = $fromform->description;
          $mdlcoursetoinsert->format = 'topics';
          $mdlcoursetoinsert->summaryformat = 1;
          $mdlcoursetoinsert->startdate = strtotime(date('d-m-y'));
          $mdlcoursetoinsert->showactivitydates = 1;
          $mdlcoursetoinsert->showcompletionconditions = 1;
          $mdlcoursetoinsert->timecreated = time();
          $mdlcoursetoinsert->timemodified = time();

          $mdl_course = $DB->insert_record('course', $mdlcoursetoinsert);

          // get the id of the mdl_course
          $getMoodleCourseId = Course::getMoodleCourseId($DB, $fromform->course_category, $fromform->name, $fromform->code, $fromform->description);


          // newwaves course table
          $recordtoinsert = new stdClass();
          $recordtoinsert->full_name = $fromform->name;
          $recordtoinsert->short_code = $fromform->code;
          $recordtoinsert->description = $fromform->description;
          $recordtoinsert->category_id = $fromform->course_category;
          $recordtoinsert->creator_id = $fromform->creator_id;
          $recordtoinsert->school_id = $fromform->school_id;
          $recordtoinsert->mdl_course_id = $getMoodleCourseId;

          $recordtoinsert->timecreated = time();
          $recordtoinsert->timemodified = time();

          $newwaves_course = $DB->insert_record('newwaves_course', $recordtoinsert);


          // check if this course has been created into the mdl_enrol
          // if course has not been created here....create it using the manual
          // check if the course has been created in the mdl_enrol
          //$courseEnrolmentId = Enrolment::getEnrolmentByCourse($DB, $fromform->mdl_course_id);

          //if($courseEnrolmentId==0 || $courseEnrolmentId==''){}

          $enroltoinsert = new stdClass();
          $enroltoinsert->enrol = 'manual';
          $enroltoinsert->status = 0;
          $enroltoinsert->courseid = $getMoodleCourseId;
          $enroltoinsert->sortorder = 0;
          $enroltoinsert->roleid = 5;
          $enroltoinsert->timecreated = time();
          $enroltoinsert->timemodified = time();

          $mdl_enrol = $DB->insert_record('enrol', $enroltoinsert);



          if ($newwaves_course && $mdl_course && $mdl_enrol){
              //$DB->commit_delegated_transaction($transaction);
              $manage_course_href = "manage_course.php?q=".mask($fromform->school_id);
              $new_course = $fromform->name;
              redirect($CFG->wwwroot."/local/newwaves/myschool/course/{$manage_course_href}", "A Course with the name <strong>{$new_course}</strong> has been successfully created.");
          }else{
              //$transaction->rollback();
              $manage_course_href = "manage_course.php?q=".mask($fromform->school_id);
              $new_course = $fromform->name;
              redirect($CFG->wwwroot."/local/newwaves/myschool/course/{$manage_course_href}", "The course creation of <strong>{$new_course}</strong> failed.");
          }






}else {
    // Get School Id if not redirect page


    //************************* Check page accessibility *********************************************************
    // Check and Get School Id from URL if set
    if (!isset($_GET['q']) || $_GET['q']==''){
        // URL ID not set redirect from page
        redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Create Course page");
    }else{
        // URL ID set collect ID into page variable and continue
        $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
        $_GET_URL_school_id = $_GET_URL_school_id[1];
    }

    // Check user accessibility status using role
    if (!isset($_SESSION['schoolid']) || $_SESSION['schoolid']==''){
        // if Session Variable Schoolid is not set, redirect from page
        redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Create Course page");
    }


    // check if the page URL and the session variable are not the same
    if($_SESSION['schoolid']!=$_GET_URL_school_id){
        redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Create Course page");
    }

    //************************ End of Check page accessibility *****************************************************


}


//get MySchool Name
$getMySchoolName = School::getName($DB, $_SESSION['schoolid']);


echo $OUTPUT->header();
echo "<h2>{$getMySchoolName}<div class='mt-1'><small>Create Course</small></div></h2>";


?>

<hr/>




<div class="row border rounded py-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php

        $data_packet = array("school_id"=>$_GET_URL_school_id, "creator_id"=>$USER->id);


        $mform->set_data($data_packet);
        $mform->display();

        ?>
    </div><!-- end of column //-->
</div><!-- end of row //-->






<?php

echo $OUTPUT->footer();
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
?>
