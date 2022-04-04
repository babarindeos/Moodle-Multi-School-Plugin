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
 * @package     create_school_head
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../../config.php');

 require_login();
 require_once($CFG->dirroot.'/local/newwaves/classes/form/create_school_head.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');

 global $DB, $USER;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/school/create_school_head.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Create School Head Admin');


 // ------------------     Form ------------------------------------------------


   $mform = new createSchoolHead();


   if ($mform->is_cancelled()){
      redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'No School Head Admin is created. You cancelled the operation.');

   }else if($fromform = $mform->get_data()){

      $auth = new Auth();
      $isEmailExist = $auth->isEmailExist($DB, $fromform->email);


      // Check if email already exist
      if ($isEmailExist>0){
                $create_school_head_href = "create_school_head.php?q=".mask($fromform->school_id);
                $email = $fromform->email;
                redirect($CFG->wwwroot."/local/newwaves/moe/school/{$create_school_head_href}", "<strong>[Duplicate Email Error]</strong> A user record with that email <strong>{$email}</strong> already exist.");

      }else{

                $transaction = $DB->start_delegated_transaction();

                //write to newwaves_schools_heads
                $recordtoinsert = new stdClass();
                $recordtoinsert->schoolid = $fromform->school_id;
                $recordtoinsert->title = $fromform->title;
                $recordtoinsert->surname = $fromform->surname;
                $recordtoinsert->firstname = $fromform->firstname;
                $recordtoinsert->middlename = $fromform->middlename;
                $recordtoinsert->gender = $fromform->gender;
                $recordtoinsert->email = $fromform->email;
                $recordtoinsert->phone = $fromform->phone;
                $recordtoinsert->role = "headadmin";
                $recordtoinsert->status = "active";                
                $recordtoinsert->creator = $USER->id;
                $recordtoinsert->timecreated = time();
                $recordtoinsert->timemodified = time();

                $create_newwaves_user = $DB->insert_record('newwaves_schools_users', $recordtoinsert);


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

                $create_moodle_user = $DB->insert_record("user", $createlogin);


                if ($create_newwaves_user && $create_moodle_user){
                    $DB->commit_delegated_transaction($transaction);
                }

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



                $schoolinfo_href = "manage_headadmin.php?q=".mask($fromform->school_id);
                $newHeadAdmin = $fromform->surname.' '.$fromform->firstname;
                redirect($CFG->wwwroot."/local/newwaves/moe/school/{$schoolinfo_href}", "A School Head Admin with the name <strong>{$newHeadAdmin}</strong>. has been successfully created");

      }
      // end of email verification if email already exist



   }else{
     // Get School Id
     if (!isset($_GET['q']) || $_GET['q']==''){
            redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
     }

     $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
     $_GET_URL_school_id = $_GET_URL_school_id[1];

   }


//------------------------------------------------------------------------------



 echo $OUTPUT->header();
 echo "<h2>School Information <small>[ Head Admin]</small></h2>";
 $active_menu_item = "headadmin";


 // nav bar
 include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');






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

  <!-- end of navigation //-->

  <div class="row d-flex justify-content-right mt-4">
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
         <h4 class='font-weight-normal'>Create School Head Admin</h4>
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
