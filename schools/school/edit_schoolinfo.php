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


  // get _GET variable
  // Get School Id
  if (!isset($_GET['q']) || $_GET['q']==''){
         redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php');
  }

  $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
  $_GET_URL_school_id = $_GET_URL_school_id[1];



 require_once(__DIR__.'/../../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/classes/form/update_school.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');

 global $DB, $USER;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/edit_schoolinfo.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Update School Information');



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

 $mform = new updateSchool(null, $data_packet);
 $mform->set_data($data_packet);

 echo $OUTPUT->header();
 // display page Header
 $pageHeader = pageHeader("Update School Information");
 echo $pageHeader;



  $mform->display();




  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
