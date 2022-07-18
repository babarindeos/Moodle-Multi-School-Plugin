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
 * @package     reportsheets_ reportsheet
 * @author      Seyibabs
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @var stdClass $plugin
 */



 require_once(__DIR__.'/../../../../config.php');
 require_login();

 require_once($CFG->dirroot.'/local/newwaves/functions/schooltypes.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/encrypt.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/acadclass.php');
 require_once($CFG->dirroot.'/local/newwaves/lib/mdb.css.php');
 require_once($CFG->dirroot.'/local/newwaves/includes/page_header.inc.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/title.php');
 require_once($CFG->dirroot.'/local/newwaves/functions/gender.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/school.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/Coursecategory.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/gradebook.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/student.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/report.php');
 require_once($CFG->dirroot.'/local/newwaves/classes/enrolment.php');




//************************* Check page accessibility *********************************************************
// Check and Get newwaves student id from URL if set
if (!isset($_GET['sid']) || $_GET['sid']==''){
    // URL ID not set redirect from page
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unauthorised to access the ReportSheet");
}else{
    // URL ID set collect ID into page variable and continue
    $_GET_URL_Nw_Student_id = explode("-",htmlspecialchars(strip_tags($_GET['sid'])));
    $_GET_URL_Nw_Student_id = $_GET_URL_Nw_Student_id[1];
}

// Check and Get Moodle student id from URL if set
if (!isset($_GET['mdl']) || $_GET['mdl']==''){
    // URL ID not set redirect from page
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unauthorised to access the ReportSheet");
}else{
    // URL ID set collect ID into page variable and continue
    $_GET_URL_Mdl_Student_id = explode("-",htmlspecialchars(strip_tags($_GET['mdl'])));
    $_GET_URL_Mdl_Student_id = $_GET_URL_Mdl_Student_id[1];
}


// Check and Get School id from URL if set
if (!isset($_GET['schoolid']) || $_GET['schoolid']==''){
    // URL ID not set redirect from page
    redirect($CFG->wwwroot.'/local/newwaves/newwaves_dashboard.php', "Unauthorised to access the ReportSheet");
}else{
    // URL ID set collect ID into page variable and continue
    $_GET_URL_school_id = explode("-",htmlspecialchars(strip_tags($_GET['schoolid'])));
    $_GET_URL_school_id = $_GET_URL_school_id[1];
}


// Check user accessibility status using role
if (!isset($_SESSION['schoolid']) || $_SESSION['schoolid']==''){
    // if Session Variable Schoolid is not set, redirect from page
    redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unauthorised to access the ReportSheet");
}


// check if the page URL and the session variable are not the same
if($_SESSION['schoolid']!=$_GET_URL_school_id){
    redirect($CFG->wwwroot."/local/newwaves/newwaves_dashboard.php", "Unauthorised to access the ReportSheet");
}

//************************ End of Check page accessibility *****************************************************


// global database handler
global $DB;


// set page
$PAGE->set_url(new moodle_url('/local/newwaves/myschool/gradebook/books.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title("Student's Report Sheet");
//$PAGE->set_heading('Course Information');

$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string('myschoolreportsheetstudentslist','local_newwaves'), new moodle_url('/local/newwaves/myschool/reportsheets/studentslist.php'));
$PAGE->navbar->add(get_string('myschoolreportsheetsreport','local_newwaves'), new moodle_url('/local/newwaves/myschool/reportsheets/reportsheet.php?sid='.mask($_GET_URL_Nw_Student_id).'&mdl='.mask($_GET_URL_Mdl_Student_id).'&schoolid='.mask($_GET_URL_school_id)));


//get MySchool Name
$getMySchoolName = School::getName($DB, $_SESSION['schoolid']);


//get records of student in $_SESSION['schoolid'] or $_GET_URL_school_id
$student = new Student();
$getStudentsList = $student->getStudentsProfileBySchoolId($DB, $_SESSION['schoolid']);


echo $OUTPUT->header();
echo "<h2>{$getMySchoolName}<br/><small>Student's Report Sheet</small></h2>";



//get student profile information
$student = new Student();
$getStudentProfile = $student->getStudentProfileById($DB, $_GET_URL_Nw_Student_id);

foreach($getStudentProfile as $row){
  $surname = $row->surname;
  $firstname = $row->firstname;
  $middlename = $row->middlename;
  $admission_no = $row->uuid;
  $class = acadclass($row->class);
}



 ?>

 <hr/>
 <div class="container-fluid">
   <!-- student information //-->
   <div class="row border rounded">
        <div class="col-xs-12 col-sm-4 col-md-2 col-lg-2 py-3">
              <?php
                  $image_src = $CFG->wwwroot.'/local/newwaves/assets/images/user_avatar_small.png';
              ?>
              <img src="<?php echo $image_src; ?>" width="100" height="100" alt="Student Avatar"/>
        </div>

        <div class="col-xs-12 col-sm-8 col-md-10 col-lg-10 py-3">
              <div><h4><?php echo $surname.' '.$firstname.' '.$middlename; ?></h4></div>
              <div><h5><?php echo $admission_no; ?></h5></div>
              <div><h5><?php echo $class; ?></h5></div>
        </div>
   </div>


   <!-- get all subjects enrolled for student and respective Assessments//-->
   <div class="row mt-4">
      <div class="col-md-12 border-bottom"> <h4>Enrolled Courses</h4></div>
      <?php
          $enrolment = new Enrolment();
          $get_courses = $enrolment->getCoursesEnrolledforStudent($DB, $_GET_URL_Mdl_Student_id);

          echo "<table>";
          foreach($get_courses as $row){

          }
          echo "</table>";

      ?>


   </div>
   <!--  //-->



</div>



 <?php
  require_once($CFG->dirroot.'/local/newwaves/includes/modal_delete.inc.php');
  require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
?>


 <?php
  $page = "manage_course.php";

  echo "<input id='select_delete_record' type='hidden' value='' />";
  echo "<input id='school_id' type='hidden' value='{$_GET_URL_school_id}' />";
  echo "<input id='page' type='hidden' value='{$page}' />";
  require_once($CFG->dirroot.'/local/newwaves/includes/modal_delete.inc.php');
  //require_once($CFG->dirroot.'/local/newwaves/lib/mdb.js.php');
  //require_once($CFG->dirroot.'/local/newwaves/lib/mask.js');
  echo $OUTPUT->footer();

?>

<script>
  $(document).ready(function(){
      $(".btn-delete").on("click", function(){
          var selectedBtnId = $(this).attr('id');
          var userId = $(this).attr('id').replace(/\D/g,'');
          $('#select_delete_record').val(userId);
      });

      $("#btn-delete-modal").on("click", function(){
          var school_id = $("#school_id").val();
          var courseId = $("#select_delete_record").val();
          var qcode = generateMask(60);
          var zcode = generateMask(60);
          var page = 'manage_students.php';

          window.location='delete_course.php?q='+qcode+'&cid='+courseId+'&z='+zcode+'&sid='+school_id+'&pg='+page+'&j='+qcode;
      });
  });

  function generateMask(length){
      // declare all characters
      const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      let result = ' ';
      const charactersLength = characters.length;
        for ( let i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
  }




</script>
