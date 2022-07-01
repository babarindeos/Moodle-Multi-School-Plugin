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
 * @package     create_school_student
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */


require_once(__DIR__.'/../../../../config.php');

require_once($CFG->dirroot.'/local/newwaves/classes/form/update_course_category.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');


//------------------------------------------------------------------------------

global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/myschool/course/edit_category.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Update Course Category');
$PAGE->set_heading('Update Course Category');


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



$mform = new updateCourseCategory();

if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/myschool/course/manage_course.php?q='.mask($_SESSION['school_id']), 'No Update is performed. The operation is cancelled.');

}else if($fromform = $mform->get_data()){

            $transaction = $DB->start_delegated_transaction();

    $mdlcoursecat = new stdClass();
    $mdlcoursecat->id = $_SESSION['mdl_course_id'];
    $mdlcoursecat->name = $fromform->name;
    $mdlcoursecat->idnumber = $fromform->code;
    $mdlcoursecat->description = $fromform->summary;
    $mdlcoursecat->descriptionformat = 1;
    $mdlcoursecat->parent = 0;
    $mdlcoursecat->visible = 1;
    $mdlcoursecat->visibleold = 1;
    $mdlcoursecat->timemodified = time();
    $mdlcoursecat->depth = 1;

    $update_school_users = $DB->update_record("course_categories", $mdlcoursecat);


        // get id of user in moodle_user tbl
        $auth = new Auth();
        $moodleUserId = $auth->getMoodleUserId($DB, $fromform->name);


        $recordtoinsert = new stdClass();
        $recordtoinsert->id= $_SESSION['course_id'];
        $recordtoinsert->name = $fromform->name;
        $recordtoinsert->code = $fromform->code;
        $recordtoinsert->summary = $fromform->summary;
        $recordtoinsert->creator_id = $fromform->creator_id;
        $recordtoinsert->school_id = $fromform->school_id;
        $recordtoinsert->timecreated = time();
        $recordtoinsert->timemodified = time();

          $update_user = $DB->update_record("newwaves_course_categories", $recordtoinsert);

    if ($update_school_users && $update_user){
        $DB->commit_delegated_transaction($transaction);
    }

    $schoolinfo_href = "edit_category.php?q=".mask($_SESSION['school_id'])."&u=".mask($fromform->teacher_id);
    $newStudent = $fromform->name;
    redirect($CFG->wwwroot."/local/newwaves/myschool/course/{$schoolinfo_href}", "A Course with the name <strong>{$newStudent}</strong> has been successfully updated.");
//    }


}else{

    //************************* Check page accessibility *********************************************************
    // Check and Get School Id from URL if set

    if (!isset($_GET['q']) || $_GET['q']==''){
        redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Update page");
    }else{
        $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
        $_GET_URL_school_id = $_GET_URL_school_id[1];
        $_SESSION['school_id'] = $_GET_URL_school_id;
    }


    if (!isset($_GET['c']) || $_GET['c']==''){
        redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Update page");
    }else{

        $_GET_URL_course_id = explode("-",htmlspecialchars(strip_tags($_GET['c'])));
        $_GET_URL_course_id = $_GET_URL_course_id[1];

        // put this course into session  for postback purpose
        $_SESSION['course_id'] = $_GET_URL_course_id;
    }



    if (!isset($_GET['m']) || $_GET['m']==''){
        redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Update page");
    }else{

        $_GET_URL_mdl_course_id = explode("-",htmlspecialchars(strip_tags($_GET['m'])));
        $_GET_URL_mdl_course_id = $_GET_URL_mdl_course_id[1];

        // put this course into session for postback purpose
        $_SESSION['mdl_course_id'] = $_GET_URL_mdl_course_id;
    }


    // Check user accessibility status using role
    if (!isset($_SESSION['schoolid']) || $_SESSION['schoolid']==''){
        // if Session Variable Schoolid is not set, redirect from page
        redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Course Update page");
    }


    // check if the page URL and the session variable are not the same
    if($_SESSION['schoolid']!=$_GET_URL_school_id){
        redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Course Update page");
    }

    //************************ End of Check page accessibility *****************************************************

}


echo $OUTPUT->header();


// retrieve school information from DB
$sql = "SELECT * from {newwaves_course_categories} where id={$_SESSION['course_id']}";
$school =  $DB->get_records_sql($sql);

foreach($school as $row){
    $course_name = $row->name;
    $course_code = $row->code;
    $course_description = $row->summary;
}

?>

<hr/>

<div class="row d-flex justify-content-right mt-4 mb-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h4 class='font-weight-normal'>Update Course Category</h4>
    </div>
</div>


<div class="row border rounded py-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php

        $data_packet = array('name'=>$course_name,'code'=>$course_code, 'summary'=>$course_description,"school_id"=>$_GET_URL_school_id, "creator_id"=>$USER->id, "course_category_id"=>$USER->id);

        $mform->set_data($data_packet);
        $mform->display();

        ?>
    </div><!-- end of column //-->
</div><!-- end of row //-->






<?php
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>
