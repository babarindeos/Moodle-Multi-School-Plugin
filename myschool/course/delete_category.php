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

require_once($CFG->dirroot.'/local/newwaves/classes/form/update_course_category.php');
require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
require_once($CFG->dirroot.'/local/newwaves/classes/auth.php');


//------------------------------------------------------------------------------

global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/myschool/course/delete_category.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Update Course Category');
$PAGE->set_heading('Update Course Category');


// check for theCourseId
$theCourseId = '';
if (!isset($_GET['c']) || $_GET['c']==''){
    $theCourseId = $_SESSION['course_id'];
}else{
    $_GET_URL_course_id = explode("-",htmlspecialchars(strip_tags($_GET['c'])));
    $_GET_URL_course_id = $_GET_URL_course_id[1];

    $theCourseId = $_GET_URL_course_id;
}

// check for theMdlCourseId
$theMdlCourseId = '';
if (!isset($_GET['m']) || $_GET['m']==''){
    $theMdlCourseId = $_SESSION['mdl_course_id'];
}else{
    $_GET_URL_mdl_course_id = explode("-",htmlspecialchars(strip_tags($_GET['m'])));
    $_GET_URL_mdl_course_id = $_GET_URL_mdl_course_id[1];

    $theMdlCourseId = $_GET_URL_mdl_course_id;
}




    //************************* Check page accessibility *********************************************************
    // Check and Get School Id from URL if set

    if (!isset($_GET['q']) || $_GET['q']==''){
        redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Update page");
    }else{
        $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
        $_GET_URL_school_id = $_GET_URL_school_id[1];
        $_SESSION['school_id'] = $_GET_URL_school_id;
    }


    if (!isset($_GET['c']) || $_GET['c']==''){
        redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Update page");
    }else{

        $_GET_URL_course_id = explode("-",htmlspecialchars(strip_tags($_GET['c'])));
        $_GET_URL_course_id = $_GET_URL_course_id[1];

        // put this course into session  for postback purpose
        $_SESSION['course_id'] = $_GET_URL_course_id;
    }



    if (!isset($_GET['m']) || $_GET['m']==''){
        redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unathorised to access the Course Update page");
    }else{

        $_GET_URL_mdl_course_id = explode("-",htmlspecialchars(strip_tags($_GET['m'])));
        $_GET_URL_mdl_course_id = $_GET_URL_mdl_course_id[1];

        // put this course into session for postback purpose
        $_SESSION['mdl_course_id'] = $_GET_URL_mdl_course_id;
    }


    // Check user accessibility status using role
    if (!isset($_SESSION['schoolid']) || $_SESSION['schoolid']==''){
        // if Session Variable Schoolid is not set, redirect from page
        redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Course Update page");
    }


    // check if the page URL and the session variable are not the same
    if($_SESSION['schoolid']!=$_GET_URL_school_id){
        redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unathorised to access the Course Update page");
    }

    //************************ End of Check page accessibility *****************************************************

    // retrieve school information from DB
    $school =  $DB->delete_records("newwaves_course_categories",['id' => $_SESSION['course_id']]);

// retrieve school information from DB
    $school1 =  $DB->delete_records("course_categories",['id' => $_SESSION['mdl_course_id']]);


    redirect($CFG->wwwroot."/local/newwaves/myschool/course/create_category.php?q=".mask($_GET_URL_school_id), "Course Category deleted");




echo $OUTPUT->header();



?>







<?php
require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
echo $OUTPUT->footer();
?>
