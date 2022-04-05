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

require_once(__DIR__.'/../../../config.php');

require_once($CFG->dirroot.'/local/newwaves/classes/form/create_school_student.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');


//------------------------------------------------------------------------------

global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/student_selfregistration/pre_registration2.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Student Registration');
$PAGE->set_heading('Student Registration');


$mform = new createSchoolStudent();


if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/student_selfregistration/pre_registration1.php', 'Registration has been cancelled.');

}else if($fromform = $mform->get_data()){

          $admission_no = $fromform->admission_no;
          $surname = $fromform->surname;
          $firstname = $fromform->firstname;
          $middlename = $fromform->middlename;
          $gender = $fromform->gender;
          $email = $fromform->email;
          $phone = $fromform->phone;
          $class = $fromform->class;



          $_SESSION['admission_no'] = $admission_no;
          $_SESSION['surname'] = $surname;
          $_SESSION['firstname'] = $firstname;
          $_SESSION['middlename'] = $middlename;
          $_SESSION['gender'] = $gender;
          $_SESSION['email'] = $email;
          $_SESSION['phone'] = $phone;
          $_SESSION['class'] = $class;
          $_SESSION['schoolId'] = $_SESSION['school_id'];


          $registration_href = "pre_registration3.php?q=".mask(1);
          $newStudent = $fromform->surname.' '.$fromform->firstname;
          redirect($CFG->wwwroot."/local/newwaves/student_selfregistration/{$registration_href}", " Proceed to Step 3 of 3 to Complete Registration.");


}else {
    // Get School Id if not redirect page
    if (!isset($_GET['q']) || $_GET['q'] == '') {
        redirect($CFG->wwwroot . '/local/newwaves/student_selfregistration/pre_registration1.php', 'Sorry, the page is not fully formed with the required information.');
    }

}


$_GET_URL_school_id = explode("-", htmlspecialchars(strip_tags($_GET['q'])));
$_GET_URL_school_id = $_GET_URL_school_id[1];
$_SESSION['school_id'] = $_GET_URL_school_id;




echo $OUTPUT->header();
//echo "<h2><small>[ School Information ]</small></h2>";
$active_menu_item = "students";

// retrieve school information from DB
$sql = "SELECT * from {newwaves_schools} where id={$_GET_URL_school_id}";
$school =  $DB->get_records_sql($sql);

foreach($school as $row){
    $school_name = $row->name;
    $school_type = schoolTypes($row->type);
    $lga = $row->lga;
    $address = $row->address;
    echo "<h4><strong>{$school_name}</strong></h4>";
    echo "<div>{$address}, {$lga}</div>";
}

?>

<hr/>

<!-- end of navigation //-->

<div class="row d-flex justify-content-right mt-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h4 class='font-weight-normal'>Step 2 of 3 - Registration Form</h4>
    </div>
</div>


<div class="row border rounded py-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php



        // Get School Id if not redirect page
        if (!isset($_GET['q']) || $_GET['q']==''){
            redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'Sorry, the page is not fully formed with the required information.');
        }else{
            $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
            $_GET_URL_school_id = $_GET_URL_school_id[1];
        }

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
