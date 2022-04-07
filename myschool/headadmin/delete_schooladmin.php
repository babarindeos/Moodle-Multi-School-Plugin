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
 * @package     delete_headadmin
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/classes/headadmin.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/acadclass.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');


 if (!isset($_SERVER['HTTP_REFERER'])){
      redirect($CFG->wwwroot.'/local/newwaves/myschool/headadmin/manage_schooladmin.php', 'Unauthorised access.');
 }


 $PAGE->set_url(new moodle_url('/local/newwaves/myschool/headadmin/delete_schooladmin.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('School Admin Profile');
 $PAGE->set_heading('School Admin');

 global $DB, $USER;




 $_GET_URL_school_id = htmlspecialchars(strip_tags($_GET['sid']));
 $_GET_URL_user_id = htmlspecialchars(strip_tags($_GET['uid']));
 $_GET_URL_page = htmlspecialchars(strip_tags($_GET['pg']));


 $sql = "Select id, email from {newwaves_schools_users} where id={$_GET_URL_user_id}";
 $studentData = $DB->get_records_sql($sql);

 foreach($studentData as $row){
    $newwavesUserId = $row->id;
    $newwavesEmail = $row->email;
 }

 //get moodle user id
 $auth = new Auth();
 $getUserMoodleId = $auth->getMoodleUserId($DB, $newwavesEmail);



 // Perform delete
 // transaction instantiation
 $transaction = $DB->start_delegated_transaction();

 // initiate newwaves user delete
 $recordtodelete = new stdClass();
 $recordtodelete->id = $newwavesUserId;
 $delete_newwaves_user = $DB->delete_records('newwaves_schools_users', ['id'=>$newwavesUserId]);


 // initiate moodle user delete
 $deletemoodleuser = new stdClass();
 $deletemoodleuser->id =$getUserMoodleId;
 $delete_moodle_user = $DB->delete_records('user', ['id'=>$getUserMoodleId]);

 // validate delete and commit transaction
 if ($delete_newwaves_user && $delete_moodle_user){
     $DB->commit_delegated_transaction($transaction);
 }


  // redirect
  if ($_GET_URL_page=='manage_schooladmin.php'){
     $redirect_url = $CFG->wwwroot."/local/newwaves/myschool/headadmin/{$_GET_URL_page}?q=".mask($_GET_URL_school_id);
     redirect($redirect_url, "The selected record has been successfully deleted.");
  }





  echo $OUTPUT->header();
  echo "<div class='mb-5'><h2><small> [Head Admin Profile ]</small></h2></div>";




  echo $OUTPUT->footer();
