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
 * @package     edit_student
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */






 require_once(__DIR__.'/../../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/form/update_school_student.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/state.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');

 global $DB, $USER;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/school/edit_student.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Update Student Profile');
 $PAGE->set_heading("Update Student Profile");


 $mform = new updateSchoolStudent();





 if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/moe/school/manage_students.php?q='.mask($_SESSION['school_id']), 'No Update is performed. The operation is cancelled.');
 }else if($fromform = $mform->get_data()){

      $transaction = $DB->start_delegated_transaction();

      // update newwaves_schools_users
      $recordtoupdate = new stdClass();
      $recordtoupdate->id = $fromform->student_id;
      $recordtoupdate->surname = $fromform->surname;
      $recordtoupdate->firstname = $fromform->firstname;
      $recordtoupdate->middlename = $fromform->middlename;
      $recordtoupdate->gender = $fromform->gender;
      //$recordtoupdate->email = $fromform->email;
      $recordtoupdate->phone = $fromform->phone;
      $recordtoupdate->timemodified = time();

      $update_school_users = $DB->update_record('newwaves_schools_users', $recordtoupdate);



      // get id of user in moodle_user tbl
      $auth = new Auth();
      $moodleUserId = $auth->getMoodleUserId($DB, $fromform->email);


      // update moodle user
      $tbluserupdate = new stdClass();
      $tbluserupdate->firstname = $fromform->firstname;
      $tbluserupdate->lastname = $fromform->surname;
      $tbluserupdate->id = $moodleUserId;

      $update_user = $DB->update_record('user', $tbluserupdate);

      if ($update_school_users && $update_user){
          $DB->commit_delegated_transaction($transaction);
      }


      $student_href = "edit_student.php?q=".mask($_SESSION['school_id'])."&u=".mask($fromform->student_id);
      redirect($CFG->wwwroot."/local/newwaves/moe/school/{$student_href}", "A Student with the name <strong>{$fromform->surname} {$fromform->firstname}</strong> has been successfully updated.");

 }


 // get _GET variable
 // Get School Id
 if (!isset($_GET['q']) || $_GET['q']==''){
        redirect($CFG->wwwroot.'/local/newwaves/moe/school/manage_students.php?q='.$_GET_URL_school_id);
 }

 $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
 $_GET_URL_school_id = $_GET_URL_school_id[1];

 // save school_id in session for purpose of postback
 $_SESSION['school_id'] = $_GET_URL_school_id;

 // Get Student id
 if (!isset($_GET['u']) || $_GET['u']==''){
        redirect($CFG->wwwroot.'/local/newwaves/moe/school/manage_students.php?q='.$_GET_URL_school_id);
 }

 $_GET_URL_student_id = explode("-",htmlspecialchars(strip_tags($_GET['u'])));
 $_GET_URL_student_id = $_GET_URL_student_id[1];



 echo $OUTPUT->header();

 $sql = "SELECT id, uuid, surname, firstname, middlename, gender, email, phone FROM {newwaves_schools_users}
         where id={$_GET_URL_student_id}";

 $getStudent = $DB->get_records_sql($sql);

 foreach($getStudent as $row){
   $staff_no = $row->uuid;
   $surname = $row->surname;
   $firstname = $row->firstname;
   $middlename = $row->middlename;
   $gender = $row->gender;
   $email = $row->email;
   $phone = $row->phone;
 }


 $data_packet = array("student_id"=>$_GET_URL_student_id, "admission_no"=>$staff_no, "surname"=>$surname, "firstname"=>$firstname, "middlename"=>$middlename,
                     "gender"=>$gender, "email"=>$email, "phone"=>$phone);


 $mform->set_data($data_packet);


 // display page Header
 $pageHeader = pageHeader("Update Student Profile");
 //echo $pageHeader;

 // include nav bar
  include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');

  // retrieve school data
  $sql = "SELECT * from {newwaves_schools} where id={$_GET_URL_school_id}";
  $school =  $DB->get_records_sql($sql);

  foreach($school as $row){
     $school_name = $row->name;
     $school_type = $row->type;
     $state = state($row->state);
     $lga = $row->lga;
     $address = $row->address;

     echo "<h4>{$school_name}</h4>";
     echo "<div>{$state}, {$address}, {$lga}</div>";
  }

  echo "<hr/>";

  $mform->display();




  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
