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
 * @package     enrol_students
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



require_once(__DIR__.'/../../../../config.php');
require_login();


// Get School Id
if (!isset($_GET['q']) || $_GET['q']==''){
    redirect($CFG->wwwroot.'/local/newwaves/myschool/course/enrol_students.php');
}


$_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
$_GET_URL_school_id = $_GET_URL_school_id[1];



// Get Course Id
if (!isset($_GET['c']) || $_GET['c']==''){
    redirect($CFG->wwwroot.'/local/newwaves/myschool/course/enrol_students.php');
}


$_GET_URL_course_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
$_GET_URL_course_id = $_GET_URL_course_id[1];


global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/myschool/course/enrol_students.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Course Information');
//$PAGE->set_heading('Course Information');

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('myschoolcourseenrolstudents','local_newwaves'), new moodle_url('/local/newwaves/myschool/course/enrol_students.php'));



echo $OUTPUT->header();
echo "<h2>Enrol Students</h2>";

?>







<?php

  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  echo $OUTPUT->footer();
?>
