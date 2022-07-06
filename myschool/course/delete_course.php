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
 * @package     create_school_student
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */


require_once(__DIR__.'/../../../../config.php');

require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');
require_once($CFG->dirroot.'/local/newwaves/classes/course.php');


//------------------------------------------------------------------------------

global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/myschool/course/delete_course.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Delete Course');
$PAGE->set_heading('Delete Course');





    //************************* Check page accessibility *********************************************************
    // Check and Get School Id from URL if set

    if (!isset($_GET['sid']) || $_GET['sid']==''){
        redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Update page");
    }else{
        $_GET_URL_school_id = htmlspecialchars(strip_tags($_GET['sid']));

    }


    if (!isset($_GET['cid']) || $_GET['cid']==''){
        redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Update page");
    }else{

        $_GET_URL_course_id = htmlspecialchars(strip_tags($_GET['cid']));

    }

    //************************ End of Check page accessibility *****************************************************


    // delete course from mdl_course_
    $del_mdl_course =  $DB->delete_records("course",['id' => $_GET_URL_course_id]);

    // delete course from newwaves_course
    $newwaves_course = new Course();
    $get_nes_course_id = $newwaves_course->getNESCourseIdByMdlCourseId($DB, $_GET_URL_course_id);

    $del_nes_course = $DB->delete_records("newwaves_course",['id'=> $get_nes_course_id]);


    redirect($CFG->wwwroot."/local/newwaves/myschool/course/manage_course.php?q=".mask($_GET_URL_school_id), "The selected course has been deleted");



echo $OUTPUT->header();



?>







<?php
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>
