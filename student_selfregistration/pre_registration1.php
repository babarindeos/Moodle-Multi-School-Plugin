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
 * @package     Student Registration
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

require_once(__DIR__.'/../../../config.php');
require_once($CFG->dirroot.'/local/newwaves/classes/form/verify_school.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');


//------------------------------------------------------------------------------

global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/student_selfregistration/pre_registration.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Student Registration');
$PAGE->set_heading('Student Registration');


$mform = new VerifySchool();
if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/student_selfregistration/pre_registration1.php', 'Verification of school is cancelled.');

}else if($fromform = $mform->get_data()){

//    $auth = new Auth();
//    $isEmailExist = $auth->isEmailExist($DB, $fromform->email);
//
//    if ($isEmailExist>0){
//        $create_school_student_href = "preregistration1.php?q=".mask(1);
//        redirect($CFG->wwwroot."/local/newwaves/moe/{$create_school_student_href}", "<strong>[Duplicate Email Error]</strong> A user record with that email <strong>{$email}</strong> already exist.");
//
//    }else{


//        $recordtoinsert = new stdClass();
//        $recordtoinsert->schoolid = $fromform->school_id;
//        $recordtoinsert->uuid = $fromform->admission_no;
//        $recordtoinsert->surname = $fromform->surname;
//        $recordtoinsert->firstname = $fromform->firstname;
//        $recordtoinsert->middlename = $fromform->middlename;
//        $recordtoinsert->gender = $fromform->gender;
//        $recordtoinsert->email = $fromform->email;
//        $recordtoinsert->phone = $fromform->phone;
//        $recordtoinsert->role = "student";
//        $recordtoinsert->creator = $USER->id;
//        $recordtoinsert->timecreated = time();
//        $recordtoinsert->timemodified = time();
//
//        $DB->insert_record('newwaves_schools_users', $recordtoinsert);
//
//        // write to moodle_users
//        $createlogin = new stdClass();
//        $createlogin->auth = 'manual';
//        $createlogin->confirmed = '1';
//        $createlogin->policyagreed = '0';
//        $createlogin->deleted = '0';
//        $createlogin->suspended = '0';
//        $createlogin->mnethostid = '1';
//        $createlogin->username = $fromform->email;
//        $createlogin->password = md5('12345678');
//        $createlogin->firstname = $fromform->firstname;
//        $createlogin->lastname = $fromform->surname;
//        $createlogin->email = $fromform->email;
//
//        $DB->insert_record("user", $createlogin);
//
//
//        // write to student table
//        $createstudent = new stdClass();
//        $createstudent->admission_no = $fromform->admission_no;
//        $createstudent->schoolid = $fromform->school_id;
//        $createstudent->class = $fromform->class;
//        $createstudent->timestamp = time();
//
//        $DB->insert_record("newwaves_schools_students", $createstudent);
//


        $registration_href = "pre_registration2.php?q=".mask(1);
        redirect($CFG->wwwroot."/local/newwaves/student_selfregistration/{$registration_href}");
//    }





}
echo $OUTPUT->header();
$active_menu_item = "students";


?>

<!-- end of navigation //-->

<div class="row d-flex justify-content-right mt-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h4 class='font-weight-normal'>Step 1 of 3 - Verify Your School</h4>
    </div>
</div>


<div class="row border rounded py-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php

        $mform->display();

        ?>
    </div><!-- end of column //-->
</div><!-- end of row //-->






<?php
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>
