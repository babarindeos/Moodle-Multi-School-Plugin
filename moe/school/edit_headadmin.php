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
 * @package     edit_headadmin
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */






 require_once(__DIR__.'/../../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/form/update_headadmin.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/state.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');

 global $DB, $USER;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/school/edit_headadmin.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Update School Head Admin Information');
 $PAGE->set_heading("Update School Head Admin Information");


 $mform = new updateSchoolHeadAdmin();


 if ($mform->is_cancelled()){
    redirect($CFG->wwwroot.'/local/newwaves/moe/school/manage_headadmin.php?q='.mask($_SESSION['school_id']), 'No Update is performed. The operation is cancelled.');
 }else if($fromform = $mform->get_data()){

      $recordtoupdate = new stdClass();
      $recordtoupdate->id = $fromform->headadmin_id;
      $recordtoupdate->title = $fromform->title;
      $recordtoupdate->surname = $fromform->surname;
      $recordtoupdate->firstname = $fromform->firstname;
      $recordtoupdate->middlename = $fromform->middlename;
      $recordtoupdate->gender = $fromform->gender;
      $recordtoupdate->email = $fromform->email;
      $recordtoupdate->phone = $fromform->phone;
      $recordtoupdate->timemodified = time();

      $DB->update_record('newwaves_schools_users', $recordtoupdate);

      $headadmin_href = "edit_headadmin.php?q=".mask($_SESSION['school_id'])."&u=".mask($fromform->headadmin_id);
      redirect($CFG->wwwroot."/local/newwaves/moe/school/{$headadmin_href}", "A Head Admin with the name <strong>{$fromform->surname} {$fromform->firstname}</strong> has been successfully updated.");

 }


 // get _GET variable
 // Get School Id
 if (!isset($_GET['q']) || $_GET['q']==''){
        redirect($CFG->wwwroot.'/local/newwaves/moe/school/manage_headadmin.php?q='.$_GET_URL_school_id);
 }

 $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
 $_GET_URL_school_id = $_GET_URL_school_id[1];

 // save school_id in session for purpose of postback
 $_SESSION['school_id'] = $_GET_URL_school_id;

 // Get HeadAdmin id
 if (!isset($_GET['u']) || $_GET['u']==''){
        redirect($CFG->wwwroot.'/local/newwaves/moe/school/manage_headadmin.php?q='.$_GET_URL_school_id);
 }

 $_GET_URL_headadmin_id = explode("-",htmlspecialchars(strip_tags($_GET['u'])));
 $_GET_URL_headadmin_id = $_GET_URL_headadmin_id[1];


 echo $OUTPUT->header();

 $sql = "SELECT id, title, surname, firstname, middlename, gender, email, phone FROM {newwaves_schools_users}
         where id={$_GET_URL_headadmin_id }";

 $getHeadadmin = $DB->get_records_sql($sql);

 foreach($getHeadadmin as $row){
   $title = $row->title;
   $surname = $row->surname;
   $firstname = $row->firstname;
   $middlename = $row->middlename;
   $gender = $row->gender;
   $email = $row->email;
   $phone = $row->phone;
 }


 $data_packet = array("headadmin_id"=>$_GET_URL_headadmin_id, "title"=>$title, "surname"=>$surname, "firstname"=>$firstname, "middlename"=>$middlename,
                     "gender"=>$gender, "email"=>$email, "phone"=>$phone);


 $mform->set_data($data_packet);


 // display page Header
 $pageHeader = pageHeader("Update HeadAdmin Information");
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
