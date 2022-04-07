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

require_login();
require_once($CFG->dirroot.'/local/newwaves/classes/form/create_school_student.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');


//------------------------------------------------------------------------------

 global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/moe/school/schoolinfo_student.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Create School Student');
//$PAGE->set_heading('Student');
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('moedashboard', 'local_newwaves'), new moodle_url('/local/newwaves/moe/moe_dashboard.php'));
$PAGE->navbar->add(get_string('moemanageschools', 'local_newwaves'), new moodle_url('/local/newwaves/manage_schools.php'));



$mform = new createSchoolStudent();


if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'No School Student is created. You cancelled the operation.');

}else if($fromform = $mform->get_data()){

    $auth = new Auth();
    $isEmailExist = $auth->isEmailExist($DB, $fromform->email);

    if ($isEmailExist>0){
            $create_school_student_href = "create_school_student.php?q=".mask($fromform->school_id);
            $email = $fromform->email;
            redirect($CFG->wwwroot."/local/newwaves/moe/school/{$create_school_student_href}", "<strong>[Duplicate Email Error]</strong> A user record with that email <strong>{$email}</strong> already exist.");

    }else{
//        $title = title($fromform->title);
//        $gender = gender($fromform->gender);



              if ($fromform->gender==0){
                  //\core\notification::add('Gender has not been selected. Please select a Gender option.', \core\output\notification::NOTIFY_ERROR);

                  $create_student_href = "create_school_student.php?q=".mask($fromform->school_id);
                  redirect($CFG->wwwroot."/local/newwaves/moe/school/{$create_student_href}", 'Gender has not been selected. Please select Gender option.', null, \core\output\notification::NOTIFY_ERROR );

              }

              if ($fromform->class==0){
                  //\core\notification::add('Title has not been selected. Please select Title option.', \core\output\notification::NOTIFY_ERROR);

                  $create_student_href = "create_school_student.php?q=".mask($fromform->school_id);
                  redirect($CFG->wwwroot."/local/newwaves/moe/school/{$create_student_href}", 'Class has not been selected. Please select Class option.', null, \core\output\notification::NOTIFY_ERROR );
              }

              if ($fromform->gender!=0 && $fromform->class!=0){

                                $recordtoinsert = new stdClass();
                                $recordtoinsert->schoolid = $fromform->school_id;
                                $recordtoinsert->uuid = $fromform->admission_no;
                                $recordtoinsert->surname = $fromform->surname;
                                $recordtoinsert->firstname = $fromform->firstname;
                                $recordtoinsert->middlename = $fromform->middlename;
                                $recordtoinsert->gender = $fromform->gender;
                                $recordtoinsert->email = $fromform->email;
                                $recordtoinsert->phone = $fromform->phone;
                                $recordtoinsert->role = "student";
                                $recordtoinsert->status = "active";
                                $recordtoinsert->creator = $USER->id;
                                $recordtoinsert->timecreated = time();
                                $recordtoinsert->timemodified = time();

                                $DB->insert_record('newwaves_schools_users', $recordtoinsert);

                                // write to moodle_users
                                $createlogin = new stdClass();
                                $createlogin->auth = 'manual';
                                $createlogin->confirmed = '1';
                                $createlogin->policyagreed = '0';
                                $createlogin->deleted = '0';
                                $createlogin->suspended = '0';
                                $createlogin->mnethostid = '1';
                                $createlogin->username = $fromform->email;
                                $createlogin->password = md5('12345678');
                                $createlogin->firstname = $fromform->firstname;
                                $createlogin->lastname = $fromform->surname;
                                $createlogin->email = $fromform->email;

                                $DB->insert_record("user", $createlogin);


                                // get userid of newly created student
                                $auth = new Auth();
                                $getNESUserId = $auth->getNESUserId($DB, $fromform->email);



                                // write to student table
                                $createstudent = new stdClass();
                                $createstudent->admission_no = $fromform->admission_no;
                                $createstudent->schoolid = $fromform->school_id;
                                $createstudent->userid = $getNESUserId;
                                $createstudent->class = $fromform->class;
                                $createstudent->timecreated = time();
                                $createstudent->timemodified = time();

                                $DB->insert_record("newwaves_schools_students", $createstudent);


                                //------------------------Get moodle user id -------------------------------------------------
                                $auth = new Auth();
                                $getMoodleUserId = $auth->getMoodleUserId($DB, $fromform->email);

                                //------------------------Get newwaves user id -------------------------------------------------
                                $auth = new Auth();
                                $getNESUserId = $auth->getNESUserId($DB, $fromform->email);

                                //----------------------- Update mdl_user_id on newwaves table -------------------------------
                                $update_newwaves_user = new stdClass();
                                $update_newwaves_user->id = $getNESUserId;
                                $update_newwaves_user->mdl_userid = $getMoodleUserId;

                                $DB->update_record('newwaves_schools_users', $update_newwaves_user);



                                $schoolinfo_href = "manage_students.php?q=".mask($fromform->school_id);
                                $newStudent = $fromform->surname.' '.$fromform->firstname;
                                redirect($CFG->wwwroot."/local/newwaves/moe/school/{$schoolinfo_href}", "A Student with the name <strong>{$newStudent}</strong> has been successfully created.");

                }  // end of if statement
    }





}else {
    // Get School Id if not redirect page
    if (!isset($_GET['q']) || $_GET['q'] == '') {
        redirect($CFG->wwwroot . '/local/newwaves/moe/manage_schools.php', 'Sorry, the page is not fully formed with the required information.');
    }
        $_GET_URL_school_id = explode("-", htmlspecialchars(strip_tags($_GET['q'])));
        $_GET_URL_school_id = $_GET_URL_school_id[1];

}

 echo $OUTPUT->header();
 echo "<h2><small>School Information [ Create Student ]</small></h2>";
 $active_menu_item = "students";


 // nav bar
 include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php'); //hello

// retrieve school information from DB
$sql = "SELECT * from {newwaves_schools} where id={$_GET_URL_school_id}";
$school =  $DB->get_records_sql($sql);

foreach($school as $row){
    $school_name = $row->name;
    $school_type = schoolTypes($row->type);
    $lga = $row->lga;
    $address = $row->address;
    echo "<h4>{$school_name}</h4>";
    echo "<div>{$address}, {$lga}</div>";
}

  ?>

  <hr/>
  <!-- Navigation //-->
  <?php
     include_once($CFG->dirroot.'/local/newwaves/nav/moe_school_nav.php');
  ?>
  <!-- end of navigation //-->

  <div class="row d-flex justify-content-right mt-4">
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
         <h4 class='font-weight-normal'>Create School Student</h4>
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
