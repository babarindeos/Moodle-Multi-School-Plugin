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


require_once(__DIR__ . '/../../../config.php');

require_once($CFG->dirroot.'/local/newwaves/classes/form/create_course_categories.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');


//------------------------------------------------------------------------------

global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/schools.create_category.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Create Course Cartegories');
$PAGE->set_heading('Course Cartegories');


$mform = new createCourseCategories();


if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/schools/create_category.php', 'No School Student is created. You cancelled the operation.');

}else if($fromform = $mform->get_data()){

    $auth = new Auth();
//    $isEmailExist = $auth->isEmailExist($DB, $fromform->email);
//
//    if ($isEmailExist>0){
//        $create_school_teacher_href = "preregistration2.php?q=".mask($fromform->school_id);
//        $email = $fromform->email;
//        redirect($CFG->wwwroot."/local/newwaves/teacherselfregistration/{$create_school_teacher_href}", "<strong>[Duplicate Email Error]</strong> A user record with that email <strong>{$email}</strong> already exist.");
//
//    }else{

          $recordtoinsert = new stdClass();
          $recordtoinsert->name = $fromform->name;
          $recordtoinsert->code = $fromform->code;
          $recordtoinsert->surmmary = $fromform->summary;
          $recordtoinsert->creator_id = 1;
          $recordtoinsert->timecreated = time();
          $recordtoinsert->timemodified = time();

          $DB->insert_record('newwaves_course_categories', $recordtoinsert);

          // write to moodle_course_categories
          $createlogin = new stdClass();
          $createlogin->name = $fromform->name;
          $createlogin->description = $fromform->summary;

          $DB->insert_record("course_categories", $createlogin);

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


    $schoolinfo_href = "create_category.php?q=".mask(1);
    $newStudent = $fromform->name;
    redirect($CFG->wwwroot."/local/newwaves/schools/{$schoolinfo_href}", "A Course with the name <strong>{$newStudent}</strong> has been successfully created.");
//    }





}else {
    // Get School Id if not redirect page
    if (!isset($_GET['q']) || $_GET['q'] == '') {
        redirect($CFG->wwwroot . '/local/newwaves/moe/school_dashboard.php', 'Sorry, the page is not fully formed with the required information.');
    }
    $_GET_URL_school_id = explode("-", htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_school_id = $_GET_URL_school_id[1];

}


echo $OUTPUT->header();


// retrieve school information from DB
//$sql = "SELECT * from {newwaves_schools} where id={$_GET_URL_school_id}";
//$school =  $DB->get_records_sql($sql);
//
//foreach($school as $row){
//    $school_name = $row->name;
//    $school_type = schoolTypes($row->type);
//    $lga = $row->lga;
//    $address = $row->address;
//    echo "<h4>{$school_name}</h4>";
//    echo "<div>{$address}, {$lga}</div>";
//}

?>

<hr/>

<div class="row d-flex justify-content-right mt-4 mb-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h4 class='font-weight-normal'>Create Course Cartegories</h4>
    </div>
</div>


<div class="row border rounded py-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php




//        // Get School Id if not redirect page
//        if (!isset($_GET['q']) || $_GET['q']==''){
//            redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'Sorry, the page is not fully formed with the required information.');
//        }else{
//            $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
//            $_GET_URL_school_id = $_GET_URL_school_id[1];
//        }

        $data_packet = array("school_id"=>$_GET_URL_school_id);

        $mform->set_data($data_packet);
        $mform->display();

        ?>
    </div><!-- end of column //-->
</div><!-- end of row //-->






<?php
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>
