
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
 * @package     assign_course
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



 require_once(__DIR__.'/../../../../config.php');
 require_login();

 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/form/create_assign_course.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/schooladmin.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/Coursecategory.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');

 // Get School Id
if (!isset($_GET['q']) || $_GET['q']==''){
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php');
}else{
    $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_school_id = $_GET_URL_school_id[1];
}

// course id
if (!isset($_GET['c']) || $_GET['c']==''){
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php');
}else{
    $_GET_URL_course_id = explode("-",htmlspecialchars(strip_tags($_GET['c'])));
    $_GET_URL_course_id = $_GET_URL_course_id[1];
}


global $DB;

$PAGE->set_url(new moodle_url('/local/newwaves/schools/manage_course.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Course Information');
$PAGE->set_heading('Course Information');

echo $OUTPUT->header();
$mform = new createassignCourse();

$sql = "SELECT * FROM {newwaves_course} where id = $_GET_URL_course_id";

  $student = $DB->get_records_sql($sql);
 // read studentData object
 foreach($student as $row){
     $Creator_id = $row->creator_id;
     $schoolAdmin = new SchoolAdmin();
     $getSchoolAdmin = $schoolAdmin->getSchooladminProfileById($DB, $row->creator_id);

     // read teacherData object
     foreach($getSchoolAdmin as $schooladminrow){
         $surname = $schooladminrow->surname;
         $firstname = $schooladminrow->firstname;
         $middlename = $schooladminrow->middlename;
         $gender = $schooladminrow->gender;
         $email = $schooladminrow->email;
         $phone = $schooladminrow->phone;
         $school = $schooladminrow->name;
     }
     $fullname = $row->full_name;
     $shortcode = $row->short_code;
     $description = $row->description;
     $categoryid = $row->category_id;
     $course = new Coursecategory();
     $getCourse = $course->getcoursecategoryById($DB, $row->category_id);
     foreach($getCourse as $courserow){
         $course_category_name = $courserow->name;
     }
 }

?>




<div class="container">

        <div >
        <div >

            <table class="table table-stripped table-hover">
                <tr><td class='font-weight-bold' style='width:20%;' >Creator Name</td><td><?php echo $firstname. ' '. $surname; ?></td></tr>
                <tr><td class="font-weight-bold">Course Name</td><td><?php echo $fullname; ?></td></tr>
                <tr><td class="font-weight-bold">Course code</td><td><?php echo $shortcode; ?></td></tr>
                <tr><td class="font-weight-bold">Course Description</td><td><?php echo $description; ?></td></tr>
                <tr><td class="font-weight-bold">Course Category</td><td><?php echo $course_category_name; ?></td></tr>
                <tr><td class="font-weight-bold">Creator School</td><td><?php echo $school; ?></td></tr>

            </table>
        </div>
            <?php




            $mform->set_data(["schoolid"=>$_GET_URL_school_id]);
            $mform->display();
            ?>
        </div>



</div>




<?php
  $page = "manage_students.php";

//  echo "<input id='select_delete_record' type='hidden' value='' />";
//  echo "<input id='school_id' type='hidden' value='{$_GET_URL_school_id}' />";
//  echo "<input id='page' type='hidden' value='{$page}' />";
//  require_once($CFG->dirroot.'/local/newwaves/includes/modal_delete.inc.php');
//  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
//  //require_once($CFG->dirroot.'/local/newwaves/lib/mask.js');
  echo $OUTPUT->footer();

?>
