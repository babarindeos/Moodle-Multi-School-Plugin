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
 * @package     transfer user
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



 require_once(__DIR__.'/../../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/form/search_transfer_user.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/transfer.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/form/transfer_user.php');



  global $DB, $USER;

  $PAGE->set_url(new moodle_url('/local/newwaves/moe/transfer/initiate_transfer.php'));
  $PAGE->set_context(\context_system::instance());
  $PAGE->set_title('Transfer request');
  $PAGE->set_heading('Transfer');


  $active_menu_item = "";


  $mform = new TransferUser();
  if ($mform->is_cancelled()){
      redirect($CFG->wwwroot.'/local/newwaves/moe/transfer/initiate_transfer.php', 'You cancelled the transfer process.');
  }else if($fromform = $mform->get_data()){

      echo $_SESSION['email'];

      $auth = new Auth();
      $getMoodleUserId = $auth->getMoodleUserId($DB, $_SESSION['email']);

      $getNESUserId = $_SESSION['user_id'];

      $recordtoinsert = new stdClass();
      $recordtoinsert->mdl_userid = $getMoodleUserId;
      $recordtoinsert->nes_userid = $getNESUserId;
      $recordtoinsert->school_from = $_SESSION['schoolid'];
      $recordtoinsert->school_to =  $fromform->school_name;
      $recordtoinsert->purpose = $fromform->purpose;
      $recordtoinsert->creator = $USER->id;
      $recordtoinsert->timecreated = time();
      $recordtoinsert->timemodified = time();

      $DB->insert_record("newwaves_transfers", $recordtoinsert);

      redirect($CFG->wwwroot.'/local/newwaves/moe/transfer/initiate_transfer.php', 'The Candidate has been successfully transfered.');
  }




  // Get Transfer type
  if (!isset($_GET['type']) || $_GET['type']==''){
      redirect($CFG->wwwroot.'/local/newwaves/moe/transfer/transfer_user.php');
  }else{
      $_GET_URL_transfer_type = explode("-",htmlspecialchars(strip_tags($_GET['type'])));
      $_GET_URL_transfer_type = $_GET_URL_transfer_type[1];
      $_SESSION['transfer_type'] = $_GET_URL_transfer_type;
  }


  // Get User ID
  if (!isset($_GET['ui']) || $_GET['ui']==''){
      redirect($CFG->wwwroot.'/local/newwaves/moe/transfer/transfer_user.php');
  }else{
      $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['ui'])));
      $_GET_URL_user_id = $_GET_URL_user_id[1];
      $_SESSION['user_id'] = $_GET_URL_user_id;
  }


  // Get User ID
  if (!isset($_GET['umail']) || $_GET['umail']==''){
      redirect($CFG->wwwroot.'/local/newwaves/moe/transfer/transfer_user.php');
  }else{
      $_GET_URL_user_email = explode("-",htmlspecialchars(strip_tags($_GET['umail'])));
      $_GET_URL_user_email = $_GET_URL_user_email[1];
      $_SESSION['email'] = $_GET_URL_user_email;
  }

  echo $OUTPUT->header();
  echo "<h2><small>[ Transfer User ]</small></h2>";
  // navigation  bar


  include_once($CFG->dirroot.'/local/newwaves/nav/moe_transfer_nav.php');

  $user_avatar_small = $CFG->wwwroot.'/local/newwaves/assets/images/user_avatar_small.png';


  $transfer = new Transfer();
  $getUserData = $transfer->searchUser($DB, $_GET_URL_user_email);

  foreach($getUserData as $row){
      $surname = $row->surname;
      $firstname = $row->firstname;
      $middlename = $row->middlename;
      $uuid = $row->uuid;
      $schoolname = $row->name;
      $_SESSION['schoolid'] = $row->schoolid;
  }




  echo "<div class='container-fluid'>";
      echo "<div class='row'>";
              echo "<div class='col-xs-12 col-sm-12 col-md-8 col-lg-8'>";
                echo "<div><strong>School Transfering from</strong></div>";
                echo "<div class='py-2 px-2 mt-2 px-1 border rounded' style='background-color:#f1f1f1;'>{$schoolname}</div>";




                echo "<div class='mt-4'>";
                      echo "<strong>Select the School Candidate is transfering to</strong>";
                echo "</div>";
                echo "<div class='mt-2'>";
                  $mform->display();
                echo "</div>";


              echo "</div>";
              echo "<div class='col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center'>";
                        echo "<img src='{$user_avatar_small}' width='60%' />";
                        echo "<div class='mt-2 font-weight-weight'><strong>{$surname} {$firstname} {$middlename}</strong></div>";
                        echo "<div>{$uuid}</div>";
              echo "</div>";
      echo "</div>";
  echo "</div>";


  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
