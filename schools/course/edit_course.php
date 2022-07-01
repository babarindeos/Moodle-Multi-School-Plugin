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

require_once($CFG->dirroot.'/local/newwaves/classes/form/create_course.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');


//------------------------------------------------------------------------------

global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/schools.create.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Create Course');
$PAGE->set_heading('Create Course');


$mform = new updateCourse();


if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/schools/manage_course.php', 'No School Student is created. You cancelled the operation.');

}else if($fromform = $mform->get_data()){

            $transaction = $DB->start_delegated_transaction();


          $recordtoinsert = new stdClass();
          $recordtoinsert->full_name = $fromform->name;
          $recordtoinsert->short_code = $fromform->code;
          $recordtoinsert->description = $fromform->description;
          $recordtoinsert->creator_id = 1;
          $recordtoinsert->category_id = $fromform->course_category;
          $recordtoinsert->timecreated = time();
          $recordtoinsert->timemodified = time();

          $update_school_users = $DB->update_record('newwaves_course', $recordtoinsert);

        // get id of user in moodle_user tbl
        $auth = new Auth();
        $moodleUserId = $auth->getMoodleUserId($DB, $fromform->name);

          // write to moodle_users
          $createlogin = new stdClass();
          $createlogin->category = $fromform->course_category;
          $createlogin->fullname = $fromform->name;
          $createlogin->summary = $fromform->description;
          $createlogin->id = $moodleUserId;

          $update_user = $DB->update_record("course", $createlogin);
//
//
//          //
//          // write to teacher
//          $createteacher = new stdClass();
//          $createteacher->staff_no = $fromform->staff_no;
//          $createteacher->schoolid = $fromform->school_id;
//          $createteacher->timecreated = time();
//          $createteacher->timemodified = time();
//
//          $DB->insert_record("newwaves_schools_teachers", $createteacher);


    $schoolinfo_href = "edit_course.php?q=".mask(1);
    $newStudent = $fromform->name;
    redirect($CFG->wwwroot."/local/newwaves/schools/{$schoolinfo_href}", "A Course with the name <strong>{$newStudent}</strong> has been successfully updated.");
//    }





}


// get _GET variable
// Get School Id
if (!isset($_GET['q']) || $_GET['q']==''){
    redirect($CFG->wwwroot.'/local/newwaves/schools/course/manage_course.php?q='.$_GET_URL_school_id);
}

$_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
$_GET_URL_school_id = $_GET_URL_school_id[1];

// save school_id in session for purpose of postback
$_SESSION['school_id'] = $_GET_URL_school_id;

// Get HeadAdmin id
if (!isset($_GET['u']) || $_GET['u']==''){
    redirect($CFG->wwwroot.'/local/newwaves/schools/course/manage_course.php?q='.$_GET_URL_school_id);
}

$_GET_URL_teacher_id = explode("-",htmlspecialchars(strip_tags($_GET['u'])));
$_GET_URL_teacher_id = $_GET_URL_teacher_id[1];


echo $OUTPUT->header();


// retrieve school information from DB
$sql = "SELECT * from {newwaves_schools_course} where id={$_GET_URL_school_id}";
$school =  $DB->get_records_sql($sql);

foreach($school as $row){
    $course_name = $row->full_name;
    $course_code = $row->short_code;
    $course_description = $row->description;
}

?>

<hr/>

<div class="row d-flex justify-content-right mt-4 mb-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h4 class='font-weight-normal'>Update Course</h4>
    </div>
</div>


<div class="row border rounded py-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php





        $data_packet = array('name'=>$course_name,'code'=>$course_code, 'description'=>$course_description,"school_id"=>$_GET_URL_school_id);

        $mform->set_data($data_packet);
        $mform->display();

        ?>
    </div><!-- end of column //-->
</div><!-- end of row //-->






<?php
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>
