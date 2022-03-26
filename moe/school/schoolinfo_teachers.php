<?php
// This file is part of Moodle Course Rollover Plugin
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
 * @package     local_message
 * @author      Kristian
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../../config.php');


 require_once($CFG->dirroot.'/local/newwaves/classes/form/create_school_teacher.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');


 // ------------------     Form ------------------------------------------------

   // // Get School Id
   // if (!isset($_GET['q']) || $_GET['q']==''){
   //        redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
   // }
   //
   // $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
   // $_GET_URL_school_id = $_GET_URL_school_id[1];


//------------------------------------------------------------------------------

 global $DB;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/school/schoolinfo_teachers.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Create School Teacher');

 echo $OUTPUT->header();
 echo "<h2>School Information</h2>";


 // nav bar
 include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');





  ?>

  <hr/>
  <!-- Navigation //-->
  <?php
     include_once($CFG->dirroot.'/local/newwaves/nav/moe_school_nav.php');
  ?>
  <!-- end of navigation //-->

  <div class="row d-flex justify-content-right mt-4">
     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
         <h4 class='font-weight-normal'>Create School Teacher</h4>
     </div>
  </div>


  <div class="row border rounded py-4">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <?php


                  $mform = new createSchoolTeacher();


                  if ($mform->is_cancelled()){
                     redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'No School Head Admin is created. You cancelled the operation.');

                  }else if($fromform = $mform->get_data()){
                     echo 'Get Data ';
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

                     $DB->insert_record('newwaves_schools_heads', $recordtoinsert);




                  }else{
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
                  }


          ?>
    </div><!-- end of column //-->
</div><!-- end of row //-->






  <?php
   require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
   echo $OUTPUT->footer();
 ?>
