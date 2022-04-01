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
 * @package     edit_schoolinfo
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */






 require_once(__DIR__.'/../../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/form/update_school.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/state.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');

 global $DB, $USER;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/edit_schoolinfo.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Update School Information');
 $PAGE->set_heading("Update School Information");

 $mform = new updateSchool();

 //isPostBack
 if ($mform->is_cancelled()){
      redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'No School Update is performed. The operation is cancelled.');
 }else if($fromform = $mform->get_data()){

      $recordtoupdate = new stdClass();
      $recordtoupdate->id = $fromform->school_id;
      $recordtoupdate->name = $fromform->name;
      $recordtoupdate->type = $fromform->type;
      $recordtoupdate->state = $fromform->state;
      $recordtoupdate->lga = $fromform->lga;
      $recordtoupdate->address = $fromform->address;
      $recordtoupdate->timemodified = time();

      $DB->update_record('newwaves_schools', $recordtoupdate);

      $schoolinfo_href = "edit_schoolinfo.php?q=".mask($fromform->school_id);
      redirect($CFG->wwwroot."/local/newwaves/moe/school/{$schoolinfo_href}", "A School with the name <strong>{$fromform->name}</strong> has been successfully updated.");

 }


 // get _GET variable
 // Get School Id
 if (!isset($_GET['q']) || $_GET['q']==''){
        redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
 }

 $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
 $_GET_URL_school_id = $_GET_URL_school_id[1];




 // retrieve school data
 $sql = "SELECT * from {newwaves_schools} where id={$_GET_URL_school_id}";
 $school =  $DB->get_records_sql($sql);

 foreach($school as $row){
    $school_name = $row->name;
    $school_type = $row->type;
    $state = $row->state;
    $lga = $row->lga;
    $address = $row->address;
 }

 $data_packet = array("school_id"=>$_GET_URL_school_id, "name"=>$school_name, "type"=>$school_type, "state"=>$state,
                     "lga"=>$lga, "address"=>$address);


 $mform->set_data($data_packet);

 echo $OUTPUT->header();
 // display page Header
 $pageHeader = pageHeader("Update School Information");
 //echo $pageHeader;

 // include nav bar
  include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');



  $mform->display();




  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
