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
 * @package     initiate transfer
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



  global $DB;

  $PAGE->set_url(new moodle_url('/local/newwaves/moe/transfer/initiate_transfer.php'));
  $PAGE->set_context(\context_system::instance());
  $PAGE->set_title('Initiate transfer');
  $PAGE->set_heading('Transfer');

  echo $OUTPUT->header();
  echo "<h2><small>[ Transfer Teachers and Students ]</small></h2>";
  $active_menu_item = "";


  // navigation  bar
  include_once($CFG->dirroot.'/local/newwaves/nav/moe_transfer_nav.php');

  echo "<div class='container-fluid'>";
      echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";



          $mform = new SearchUserTransfer();
          $mform->display();


          if ($mform->is_cancelled()){

                echo "<div class='alert alert-warning'>The search operation has been cancelled.</div>";

          }else if($fromform = $mform->get_data()){

                $email = $fromform->search_user;

                $transfer = new Transfer();
                $getUserData = $transfer->searchUser($DB, $email);

                if (count($getUserData)){
                      foreach($getUserData as $row){
                            $userId = $row->id;
                            $role = $row->role;
                            $uuid = $row->uuid;
                            $surname = $row->surname;
                            $firstname = $row->firstname;
                            $middlename = $row->middlename;
                            $gender = $row->gender;
                            $school = $row->name;
                      }

                       $user_avatar_small = $CFG->wwwroot.'/local/newwaves/assets/images/user_avatar_small.png';

                       $roleLabel = '';
                      ?>
                            <div class="row mt-5">
                                   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <?php
                                              if ($role=='teacher'){
                                                  echo "<h3>Teacher Information</h3>";
                                                  $roleLabel = 'Teacher';

                                              }else{
                                                  echo "<h3>Student Information</h3>";
                                                  $roleLabel = 'Student';
                                              }
                                        ?>
                                   </div>
                                   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                   </div>

                                  <!-- //-->
                                  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                                            <table class="table table-stripped table-hover">
                                                <tr style='background-color:#f1f1f1;'><td class="font-weight-bold"><big>School</big></td><td class="font-weight-bold"><big><?php echo $school; ?></big></td></tr>
                                                <?php if ($role=='teacher') { ?>
                                                      <tr><td class='font-weight-bold' style='width:20%;' >Staff No.</td><td><?php echo $uuid; ?></td></tr>
                                                <?php }else{ ?>
                                                      <tr><td class='font-weight-bold' style='width:20%;' >Admission No.</td><td><?php echo $uuid; ?></td></tr>
                                                <?php } ?>
                                                <tr><td class="font-weight-bold">Surname</td><td><?php echo $surname; ?></td></tr>
                                                <tr><td class="font-weight-bold">Firstname</td><td><?php echo $firstname; ?></td></tr>
                                                <tr><td class="font-weight-bold">Middlename</td><td><?php echo $middlename; ?></td></tr>
                                                <tr><td class="font-weight-bold">Gender</td><td><?php echo gender($gender); ?></td></tr>

                                            </table>
                                  </div>
                                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                            <img src="<?php echo $user_avatar_small ?>"  />
                                  </div>
                                  <!-- //-->
                            </div>
                      <?php

                            $transfer_user_href = "window.location='transfer_user.php?type=".mask('ini')."&ui=".mask($userId)."&umail=".mask($email)."&usertype=".mask($roleLabel)."'";
                            //echo $transfer_user_href;


                            echo "<center>";
                                  echo "<button onclick={$transfer_user_href} class='btn btn-primary'>Initiate {$roleLabel} transfer</button>";
                            echo "</center>";
                }else{
                      echo "<div class='alert alert-warning'>There is no user with that email.</div>";
                }
          }

      echo "</div>";
  echo "</div>";

  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
