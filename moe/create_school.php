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
 * @package     create_school
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */

 require_once(__DIR__.'/../../../config.php');
 require_login();
 require_once($CFG->dirroot.'/local/newwaves/classes/form/create_school.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');

 global $DB, $USER;

 $PAGE->set_url(new moodle_url('/local/newwaves/moe/manage_schools.php'));
 $PAGE->set_context(\context_system::instance());
 $PAGE->set_title('Create School');

 $mform = new createSchool();

 if ($mform->is_cancelled()){
     redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'No school is created. You cancelled the creation of a school.');
 }else if ($fromform = $mform->get_data()){
     $recordtoinsert = new stdClass();
     $recordtoinsert->name = $fromform->name;
     $recordtoinsert->type = $fromform->type;
     $recordtoinsert->state = $fromform->state;
     $recordtoinsert->lga = $fromform->lga;
     $recordtoinsert->address = $fromform->address;
     $recordtoinsert->creator = $USER->id;
     $recordtoinsert->timecreated =  time();
     $recordtoinsert->timemodified = time();


     $DB->insert_record('newwaves_schools', $recordtoinsert);

     redirect($CFG->wwwroot.'/local/newwaves/moe/manage_schools.php', 'A school <strong>'.$fromform->name.'</strong> has been successfully created.');
 }

 echo $OUTPUT->header();

 // display page Header
 $pageHeader = pageHeader("Create School");
 echo $pageHeader;

 // include nav bar
  include_once($CFG->dirroot.'/local/newwaves/nav/moe_main_nav.php');


 // display form
 $mform->display();



 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
 echo $OUTPUT->footer();
